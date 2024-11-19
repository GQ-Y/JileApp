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
class VueDataCommonGenerator extends MineGenerator implements CodeGenerator
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
        $path = BASE_PATH . "/runtime/generate/vue/src/modules/{$module}/views/{$this->getShortBusinessName()}/data/common.tsx";
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
        return $this->getStubDir() . '/Vue/data/common.stub';
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
            '{COLUMNS}',
        ];
    }

    /**
     * 获取要替换占位符的内容.
     * @return string[]
     */
    protected function getReplaceContent(): array
    {
        return [
            $this->getColumns(),
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
     * 获取列配置代码
     */
    protected function getColumns(): string
    {
        $jsFunction = [];
        foreach ($this->columns as $column) {
            if ($column['is_pk'] == 2) {
                continue;
            }
            $function_name = Str::camel($this->getBusinessEnName() . '_' . $column['column_name']) . 'DictData';
            if (!empty($column->options)) {
                $collection = $column->options['collection'] ?? [];
                // 自定义数据
                if (in_array($column->view_type, ['checkbox', 'radio', 'select', 'transfer']) && !empty($collection)) {
                    foreach ($collection as &$item) {
                        $value = &$item['value'];
                        if (is_numeric($value)) {
                            $value = (int)$value;
                        }else{
                            $value = (string)$value;
                        }
                    }
                    $jsFunction[$function_name] = $this->jsonFormat($collection);
                }
            }
        }
        $tlp = "export function %s () {
    return  %s
}";
        $functions = [];

        foreach ($jsFunction as $key => $option) {
            $functions[] = sprintf($tlp, $key, $option);
        }
        return implode(str_repeat(PHP_EOL, 2), $functions);
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


    protected function getOtherTemplate(string $tpl): string
    {
        return $this->filesystem->sharedGet($this->getStubDir() . "/Vue/{$tpl}.stub");
    }


}
