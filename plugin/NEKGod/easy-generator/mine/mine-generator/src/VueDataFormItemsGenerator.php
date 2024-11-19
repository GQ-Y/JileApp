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
class VueDataFormItemsGenerator extends MineGenerator implements CodeGenerator
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
        $path = BASE_PATH . "/runtime/generate/vue/src/modules/{$module}/views/{$this->getShortBusinessName()}/data/getFormItems.tsx";
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
        return $this->getStubDir() . '/Vue/data/getFormItems.stub';
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
            '{BUSINESS_EN_NAME}',
            '{MODULE_NAME}',
            '{PK}',
            '{IMPORTJS}',
            '{GET_COLUMNS_TYPE}',
            "{COLUMN_INIT}"
        ];
    }

    /**
     * 获取要替换占位符的内容.
     * @return string[]
     */
    protected function getReplaceContent(): array
    {
        $columns = $this->getColumnsType();
        return [
            $this->getBusinessEnName(),
            $this->getModuleName(),
            $this->getPk(),
            implode(PHP_EOL, $this->importJs),
            $columns,
            implode(PHP_EOL, $this->columnInit),
        ];
    }

    public function getColumnsType()
    {
        $columnConfigType = [
            'add' => [],
            'edit' => [],
            'all' => [],
        ];
        foreach ($this->columns as $column) {
            if ($column['is_pk'] == 2) {
                continue;
            }
            if ($column['is_insert'] == self::NO && $column['is_edit'] == self::NO) {
                continue;
            }
            $tmp = $this->formColumnAttr($column, self::class);
            if ($column['is_insert'] == self::YES && $column['is_edit'] == self::YES) {
                $columnConfigType['all'][] = $tmp;
                continue;
            }
            if ($column['is_insert'] == self::YES) {
                $columnConfigType['add'][] = $tmp;
                continue;
            }
            if ($column['is_edit'] == self::YES) {
                $columnConfigType['edit'][] = $tmp;
                continue;
            }
        }

        $tlp = [];
        $jsArr = [];
        if (!empty($columnConfigType['add'])) {
            $this->columnInitAdd("let addColumns = []");
            $jsArr[] = "addColumns";
            $json = $this->jsonFormat($columnConfigType['add'], 6);
            $tlp[] = sprintf("if (formType == 'add') {
      addColumns = %s
    }", $json);
        }
        if (!empty($columnConfigType['edit'])) {
            $this->columnInitAdd("    let editColumns = []");
            $jsArr[] = "editColumns";
            $json = $this->jsonFormat($columnConfigType['edit'], 6);
            $tlp[] = sprintf("    if (formType == 'edit') {
      editColumns = %s
    }", $json);
        }
        $jsArr[] = $this->jsonFormat($columnConfigType['all']);
        $this->importJsAdd("import { concat } from 'lodash-es'");
        $tlp[] = sprintf("  return concat(%s);", implode(", ", $jsArr));

        $this->genImportJsList();

        return implode(str_repeat(PHP_EOL, 2), $tlp);
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
       return '';
    }

    /**
     * 获取列配置代码
     */
    protected function getColumns(): string
    {
        return '';
//        return $columnConfigType;
//        return $this->jsonFormat($options);
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


}
