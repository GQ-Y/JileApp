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
class VueFormGenerator extends MineGenerator implements CodeGenerator
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
        $path = BASE_PATH . "/runtime/generate/vue/src/modules/{$module}/views/{$this->getShortBusinessName()}/form.vue";
        $this->filesystem->makeDirectory(
            BASE_PATH . "/runtime/generate/vue/src/modules/{$module}/views/{$this->getShortBusinessName()}",
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
        return $this->getStubDir() . '/Vue/form.stub';
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
            '{BUSINESS_EN_NAME}',
            '{SWITCH_STATUS}',
            '{MODULE_NAME}',
            '{PK}',
            '{IMPORT_JS}',
            '{FUNCTION_List}',
            '{DEFINE_EXPOSE_IMPORT}'
        ];
    }

    /**
     * 获取要替换占位符的内容.
     * @return string[]
     */
    protected function getReplaceContent(): array
    {
        $this->getOptions();
        return [
            $this->getCode(),
            $this->getBusinessEnName(),
            $this->getSwitchStatus(),
            $this->getModuleName(),
            $this->getPk(),
            implode(PHP_EOL, $this->importJs),
            implode(PHP_EOL, $this->function_import),
            implode(',' . PHP_EOL. '  ', $this->defineExposeImport)
        ];
    }

    /**
     * 获取标识代码
     */
    protected function getCode(): string
    {
        return Str::lower($this->tablesContract->getModuleName()) . ':' . $this->getShortBusinessName();
    }

    protected array $defineExposeImport = [];
    protected function defineExposeImportAdd($defineExposeImport): void
    {
        if (in_array($defineExposeImport, $this->defineExposeImport)) {
            return ;
        }
        $this->defineExposeImport[] = $defineExposeImport;
    }

    protected array $function_import = [];

    protected function functionImportAdd($function_import): void
    {
        if (in_array($function_import, $this->function_import)) {
            return ;
        }
        $this->function_import[] = $function_import;
    }

    /**
     * 获取CRUD配置代码
     */
    protected function getOptions(): string
    {
        $this->importJsAdd("import getFormItems from './data/getFormItems.tsx'");
        $this->importJsAdd("import type { MaFormExpose } from '@mineadmin/form'");
        $this->importJsAdd("import useForm from '@/hooks/useForm.ts'");
        $this->importJsAdd("import { ResultCode } from '@/utils/ResultCode.ts'");
        // 配置项
        $gen_menus = explode(',', $this->tablesContract->getGenerateMenus());
        foreach ($gen_menus as $type) {
            switch ($type) {
                case "save":
                    $this->apiImportAdd("create");
                    $this->defineExposeImportAdd("add");
                    $this->functionImportAdd("// 创建操作
function add(): Promise<any> {
  return new Promise((resolve, reject) => {
    create(formData.value).then((res: any) => {
      res.code === ResultCode.SUCCESS ? resolve(res) : reject(res)
    }).catch((err) => {
      reject(err)
    })
  })
}");
                    break;
                case "update":
                    $this->defineExposeImportAdd("edit");
                    $this->apiImportAdd("save");
                    $this->functionImportAdd("// 更新操作
function edit(): Promise<any> {
  return new Promise((resolve, reject) => {
    save(formData.value.id as number, formData.value).then((res: any) => {
      res.code === ResultCode.SUCCESS ? resolve(res) : reject(res)
    }).catch((err) => {
      reject(err)
    })
  })
}");
                    break;
            }
        }
        $this->defineExposeImportAdd("maForm: formRef");

        $this->genImportJsList();
        return '';
    }

    /**
     * 获取列配置代码
     */
    protected function getColumns(): string
    {
       return "";
    }

    protected function getShowRecycle(): string
    {
        return (strpos($this->tablesContract->getGenerateMenus(), 'recycle') > 0) ? 'true' : 'false';
    }

    /**
     * 获取业务英文名.
     */
    protected function getBusinessEnName(): string
    {
        return Str::camel(str_replace(env('DB_PREFIX', ''), '', $this->tablesContract->getTableName()));
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

}
