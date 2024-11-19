<?php

declare(strict_types=1);
/**
 * This file is part of MineAdmin.
 *
 * @link     https://www.mineadmin.com
 * @document https://doc.mineadmin.com
 * @contact  root@imoi.cn
 * @license  https://github.com/mineadmin/MineAdmin/blob/master/LICENSE
 */

namespace Mine\Generator;

use Hyperf\Database\Model\Builder;
use Hyperf\Database\Model\Collection;
use Hyperf\Support\Filesystem\Filesystem;
use Mine\Exception\NormalStatusException;
use Mine\Generator\Contracts\GeneratorTablesContract;
use Mine\Generator\Enums\ComponentTypeEnum;
use Mine\Helper\Str;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

use function Hyperf\Support\env;
use function Hyperf\Support\make;

/**
 * Vue index文件生成
 * Class self.
 */
class VueDataTableGenerator extends MineGenerator implements CodeGenerator
{
    protected GeneratorTablesContract $tablesContract;

    protected string $codeContent;

    protected Filesystem $filesystem;

    protected Collection $columns;

    /**
     * 设置生成信息.
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function setGenInfo(GeneratorTablesContract $tablesContract): self
    {
        $this->tablesContract = $tablesContract;
        $this->filesystem = make(Filesystem::class);
        if (empty($tablesContract->getModuleName()) || empty($tablesContract->getMenuName())) {
            throw new NormalStatusException(t('setting.gen_code_edit'));
        }
        $this->columns = $this->tablesContract->handleQuery(function (Builder $query) {
            return $query->where('table_id', $this->tablesContract->getId())->orderByDesc('sort')
                ->get([
                    'column_name', 'column_comment', 'allow_roles', 'options', 'is_required', 'is_insert',
                    'is_edit', 'is_query', 'is_sort', 'is_pk', 'is_list', 'view_type', 'dict_type',
                ]);
        });
        return $this->placeholderReplace();
    }

    /**
     * 生成代码
     */
    public function generator(): void
    {
        $module = Str::lower($this->tablesContract->getModuleName());
        $path = BASE_PATH . "/runtime/generate/vue/src/modules/{$module}/views/{$this->getShortBusinessName()}/data/getTableColumns.tsx";
        $this->filesystem->makeDirectory(
            BASE_PATH . "/runtime/generate/vue/src/modules/{$module}/views/{$this->getShortBusinessName()}/data",
            0755,
            true,
            true
        );
        $this->filesystem->put($path, $this->replace()->getCodeContent());
    }

    /**
     * 预览代码
     */
    public function preview(): string
    {
        return $this->replace()->getCodeContent();
    }

    /**
     * 获取短业务名称.
     */
    public function getShortBusinessName(): string
    {
        return Str::camel($this->tablesContract->table_name);
    }

    /**
     * 获取组件类型.
     */
    public function getComponentType(int $type): string
    {
        return match ($type) {
            2 => "'drawer'",
            3 => "'tag'",
            default => "'modal'"
        };
    }

    /**
     * 设置代码内容.
     */
    public function setCodeContent(string $content)
    {
        $this->codeContent = $content;
    }

    /**
     * 获取代码内容.
     */
    public function getCodeContent(): string
    {
        return $this->codeContent;
    }

    /**
     * 获取模板地址
     */
    protected function getTemplatePath(): string
    {
        return $this->getStubDir() . '/Vue/data/getTableColumns.stub';
    }

    /**
     * 读取模板内容.
     */
    protected function readTemplate(): string
    {
        return $this->filesystem->sharedGet($this->getTemplatePath());
    }

    /**
     * 占位符替换.
     */
    protected function placeholderReplace(): self
    {
        $this->setCodeContent(str_replace(
            $this->getPlaceHolderContent(),
            $this->getReplaceContent(),
            $this->readTemplate()
        ));

        return $this;
    }

    /**
     * 获取要替换的占位符.
     */
    protected function getPlaceHolderContent(): array
    {
        return [
            '{CODE}',
            '{OPTIONS}',
            '{COLUMNS}',
            '{BUSINESS_EN_NAME}',
            '{INPUT_NUMBER}',
            '{SWITCH_STATUS}',
            '{MODULE_NAME}',
            '{PK}',
            '{COLUMN_INIT}',
            '{IMPORTJS}',
            '{APIIMPORT}'
        ];
    }

    /**
     * 获取要替换占位符的内容.
     * @return string[]
     */
    protected function getReplaceContent(): array
    {
        return [
            $this->getCode(),
            $this->getOptions(),
            $this->getColumns(),
            $this->getBusinessEnName(),
            $this->getInputNumber(),
            $this->getSwitchStatus(),
            $this->getModuleName(),
            $this->getPk(),
            implode(PHP_EOL, $this->columnInit),
            implode(PHP_EOL, $this->importJs),
        ];
    }

    /**
     * 获取标识代码
     */
    protected function getCode(): string
    {
        return Str::lower($this->tablesContract->getModuleName()) . ':' . $this->getShortBusinessName();
    }

    /**
     * 获取CRUD配置代码
     */
    protected function getOptions(): string
    {
        // 配置项
        $options = [];

        return 'const options = reactive(' . $this->jsonFormat($options, true) . ')';
    }


    /**
     * 获取列配置代码
     */ 
    protected function getColumns(): string
    {
        // 字段配置项
        // { type: 'selection', showOverflowTooltip: false, label: () => t('crud.selection'),
        //      cellRender: ({ row }): any => row.id === 1 ? '-' : undefined,
        //      selectable: (row: UserVo) => ![1].includes(row.id as number),
        //    },
        $options = [
            [
                'type' => 'selection',
                'showOverflowTooltip' => false,
                'label' => "() => t('crud.selection')"
            ]
        ];
        foreach ($this->columns as $column) {
            $tmp = [
                'label' => empty($column->column_comment) ? $column->column_name:$column->column_comment,
                'prop' => $column->column_name,
//                'render' => $this->getViewType($column->view_type),
            ];
            if ($column->is_list == self::NO) {
                continue;
            }
            // 扩展项
            if (!empty($column->options)) {
                $tmp = $this->getAttrSelect($column, $tmp);
            }

            $options[] = $tmp;
        }

        $options = $this->getArrActionOptions($options);

        $this->genImportJsList();

        return $this->jsonFormat($options);
    }

    /**
     * 获取业务英文名.
     */
    protected function getBusinessEnName(): string
    {
        return Str::camel(str_replace(env('DB_PREFIX', ''), '', $this->tablesContract->getTableName()));
    }
    protected function getShowRecycle(): string
    {
        return (strpos($this->tablesContract->getGenerateMenus(), 'recycle') > 0) ? 'true' : 'false';
    }


    protected function getModuleName(): string
    {
        return Str::lower($this->tablesContract->getModuleName());
    }

    /**
     * 返回主键.
     */
    protected function getPk(): string
    {
        foreach ($this->columns as $column) {
            if ($column->is_pk == self::YES) {
                return $column->column_name;
            }
        }
        return '';
    }

    /**
     * 计数器组件方法.
     * @noinspection BadExpressionStatementJS
     */
    protected function getInputNumber(): string
    {
        if (in_array('numberOperation', explode(',', $this->tablesContract->getGenerateMenus()))) {
            return str_replace('{BUSINESS_EN_NAME}', $this->getBusinessEnName(), $this->getOtherTemplate('numberOperation'));
        }
        return '';
    }

    /**
     * 计数器组件方法.
     * @noinspection BadExpressionStatementJS
     */
    protected function getSwitchStatus(): string
    {
        if (in_array('changeStatus', explode(',', $this->tablesContract->getGenerateMenus()))) {
            return str_replace('{BUSINESS_EN_NAME}', $this->getBusinessEnName(), $this->getOtherTemplate('switchStatus'));
        }
        return '';
    }

    protected function getOtherTemplate(string $tpl): string
    {
        return $this->filesystem->sharedGet($this->getStubDir() . "/Vue/{$tpl}.stub");
    }

    /**
     * 视图组件.
     */
    protected function getViewType(string $viewType): string
    {
        $viewTypes = [
            'text' => 'input',
            'password' => 'input-password',
            'textarea' => 'textarea',
            'inputNumber' => 'input-number',
            'inputTag' => 'input-tag',
            'mention' => 'mention',
            'switch' => 'switch',
            'slider' => 'slider',
            'select' => 'select',
            'radio' => 'radio',
            'checkbox' => 'checkbox',
            'treeSelect' => 'tree-select',
            'date' => 'date',
            'time' => 'time',
            'rate' => 'rate',
            'cascader' => 'cascader',
            'transfer' => 'transfer',
            'selectUser' => 'user-select',
            'userInfo' => 'user-info',
            'cityLinkage' => 'city-linkage',
            'icon' => 'icon-picker',
            'formGroup' => 'form-group',
            'upload' => 'upload',
            'selectResource' => 'resource',
            'editor' => 'editor',
            'wangEditor' => 'wang-editor',
            'codeEditor' => 'code-editor',
        ];

        return $viewTypes[$viewType] ?? 'input';
    }


    /**
     * @param mixed $column
     * @param array $tmp
     * @return array
     */
    private function getAttrSelect(mixed $column, array $tmp): array
    {
        $collection = $column->options['collection'] ?? [];
        // 合并
        $tmp = array_merge($tmp, $column->options);
        // 自定义数据
        if (in_array($column->view_type, ['checkbox', 'radio', 'select', 'transfer']) && !empty($collection)) {
            $tmp = $this->getDictComp($column, $tmp);
        }
        if (in_array($column->view_type, ['uploadFile', 'uploadImage'])) {
            $tmp = $this->getUploadComp($column, $tmp);
        }
        unset($tmp['collection']);
        return $tmp;
    }

    /**
     * @param array $options
     * @return array
     */
    private function getArrActionOptions(array $options): array
    {
        $gen_menus = explode(',', $this->tablesContract->getGenerateMenus());
        $actions = [];
        foreach ($gen_menus as $type) {
            switch ($type) {
                case "update":
                    $this->columnInitAdd("  const msg = useMessage()");
                    $actions[0] = [
                        'name' => 'edit',
                        'icon' => 'material-symbols:person-edit',
                        'text' => "() => t('crud.edit')",
                        'onClick' => "({ row }) => {
              dialog.setTitle(t('crud.edit'))
              dialog.open({ formType: 'edit', data: row })
            }"
                    ];
                    break;
                case "delete":
                    $this->apiImportAdd("deleteByIds");
                    $actions[1] = [
                        'name' => 'del',
                        'icon' => 'mdi:delete',
                        'text' => "() => t('crud.delete')",
                        'onClick' => "({ row }, proxy: MaProTableExpose) => {
              msg.delConfirm(t('crud.delDataMessage')).then(async () => {
                const response = await deleteByIds([row.id])
                if (response.code === ResultCode.SUCCESS) {
                  msg.success(t('crud.delSuccess'))
                  proxy.refresh()
                }
              })
            }"
                    ];
                    break;
            }
        }

        ksort($actions);
        $options[] = [
            'type' => 'operation',
            'label' => "() => t('crud.operation')",
            'operationConfigure' => [
                'actions' => $actions,
            ],
        ];
        return $options;
    }

    /**
     * @param mixed $column
     * @param array $tmp
     * @return array
     */
    private function getDictComp(mixed $column, array $tmp): array
    {
        $var_name = Str::camel($this->getBusinessEnName() . '_' . $column['column_name']) . 'Map';
        $function_name = Str::camel($this->getBusinessEnName() . '_' . $column['column_name']) . 'DictData';
        $this->commonImportAdd($function_name);
        $this->importJsAdd("import { keyBy, get } from \"lodash-es\";");
        $this->columnInitAdd(sprintf("  const %s = %s", $var_name, "keyBy({$function_name}(), 'value')"));
        $render = "one_map";
        if (!empty($column->options['renderProps'])) {
            $renderProps = $column->options['renderProps'];
            if ($renderProps['multiple']) {
                $render = "multiple_map";
            }
        }
        if ($column->view_type == 'checkbox') {
            $render = "multiple_map";
        }
        if ($render == "multiple_map") {
            $tmp['cellRender'] = sprintf("({ row }) => {
            return row?.%s?.map((val) => {
                return (
                    <ElTag type='primary' class='m-l-1'>
                        {get(%s, val, {label: '未知'}).label}
                    </ElTag>
                )
            })
        }", $column['column_name'], $var_name);
        } else {
            $tmp['cellRender'] = sprintf("({ row }) => {
            return (
                <ElTag type='primary'>
                    {get(%s, row.%s, {label: '未知'}).label}
                </ElTag>
            )
        }", $var_name, $column['column_name']);
        }
        return $tmp;
    }

    private function getUploadComp(mixed $column, array $tmp)
    {
        if ($column->view_type == "uploadFile") {
            $tmp['cellRender'] = sprintf('({ row }) => {                       
    return (
        <el-link onClick={() => row?.%s ? window.open(row?.%s):msg.info("无文件") } target="_blank"><icon-view />查看文件</el-link>
    )
}', $column['column_name'], $column['column_name']);
        }
        if ($column->view_type == "uploadImage") {
            $tmp['cellRender'] = sprintf('({row}) => {
    return (
        <el-popover
        >
            {{
                reference: () => {
                    return (<el-avatar src={row.%s}/>)
                },
                default: () => {
                    return (<el-image src={row.%s}></el-image>)
                }
            }}
        </el-popover>
    )
}', $column['column_name'], $column['column_name']);
        }
        return $tmp;
    }


}
