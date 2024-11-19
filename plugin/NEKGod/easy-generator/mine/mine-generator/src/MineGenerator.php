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

use Composer\InstalledVersions;
use Mine\Helper\Str;
use Psr\Container\ContainerInterface;

abstract class MineGenerator
{
    public const NO = 1;

    public const YES = 2;

    protected string $stubDir;

    protected string $namespace;

    protected array $importJs = [];

    protected string $commonJsImport = "";

    protected array $commonImport = [];
    protected array $apiImport = [];

    /**
     * MineGenerator constructor.
     */
    public function __construct(protected ContainerInterface $container)
    {
        $this->setStubDir(
            __DIR__ .'/../'. DIRECTORY_SEPARATOR . 'Stubs' . DIRECTORY_SEPARATOR
        );
    }

    public function getStubDir(): string
    {
        return $this->stubDir;
    }

    public function setStubDir(string $stubDir)
    {
        $this->stubDir = $stubDir;
    }

    public function getNamespace(): string
    {
        return $this->namespace;
    }

    /**
     * @param mixed $namespace
     */
    public function setNamespace(string $namespace): void
    {
        $this->namespace = $namespace;
    }

    public function replace(): self
    {
        return $this;
    }

    /**
     * array 到 json 数据格式化.
     */
    function isAssocArray(array $array): bool
    {
        reset($array);  // 重置数组的内部指针
        return key($array) !== 0;  // 如果键不是 0，则是关联数组
    }


    /**
     * array 到 json 数据格式化.
     */
    protected function jsonFormat(array $data, mixed $tab_num = 2): string
    {
        if (!$this->isAssocArray($data)) {
            $arrayJson = [];
            foreach ($data as $key => $value) {
                $json = $this->keyJson($key, $value);
                $arrayJson[] = str_repeat(' ', $tab_num * 2) . $json;
            }
            $arrayJson[count($arrayJson) - 1] .= ',';
            return '[' . PHP_EOL. implode(',' . PHP_EOL, $arrayJson) . PHP_EOL . str_repeat(' ', $tab_num). ']';
        }
        // 存储 JSON 字符串的数组
        $json = [];

        // 遍历数组
        foreach ($data as $key => $value) {
            $val = $this->keyJson($key, $value);
            // 拼接键值对到 JSON 数组
            $json[] = $val;
        }

        // 拼接生成最终的 JSON 字符串
        return '{' . implode(',', $json) . ' }';
    }

    /**
     * @param int|string $key
     * @param mixed $value
     * @return string
     */
    private function keyJson(int|string $key, mixed $value): string
    {
        // 处理值
        if (is_array($value)) {
            // 如果值是数组，递归调用处理
            $value = $this->jsonFormat($value);
        } elseif (is_string($value)) {
            // 正则表达式：匹配箭头函数或普通函数调用
            $pattern = '/\(\s*\)\s*=>\s*[\w$]+|\(\s*[\w$]*\s*(,\s*[\w$]+)*\s*\)\s*=>\s*\{.*\}|\w+\s*\(\s*.*\s*\)/';
            if (preg_match($pattern, $value)) {
                if (str_contains($value, 'MaDictRadio')) {
                    $this->importJsAdd("import MaDictRadio from '@/components/ma-dict-picker/ma-dict-radio.vue'");
                }
                if (str_contains($value, 'MaDictSelect')) {
                    $this->importJsAdd("import MaDictSelect from '@/components/ma-dict-picker/ma-dict-select.vue'");
                }
                if (str_contains($value, 'MaDictCheckbox')) {
                    $this->importJsAdd("import MaDictCheckbox from '@/components/ma-dict-picker/ma-dict-checkbox.vue'");
                }
                if (str_contains($value, 'MaUploadImage')) {
                    $this->importJsAdd("import MaUploadImage from '@/components/ma-upload-image/index.vue'");
                }
                if (str_contains($value, 'MaUploadFile')) {
                    $this->importJsAdd("import MaUploadFile from '@/components/ma-upload-file/index.vue'");
                }

//                $value = $value;  // 移除引号
            }else{
                $value = '\'' . addslashes($value) . '\'';  // 加上引号
            }

        } elseif (is_bool($value)) {
            // 布尔值直接转为 true 或 false
            $value = $value ? 'true' : 'false';
        } elseif (is_null($value)) {
            // null 转换为 JSON 的 null
            $value = 'null';
        }
        if (is_numeric($key)) {
            return $value;
        }
        return ' ' . addslashes((string)$key) . ': ' . $value;
    }

    /**
     * 视图组件.
     */
    protected function getViewType(string $viewType): string
    {
        // export type ComponentName = 'Radio' | 'RadioButton' | 'Checkbox' | 'CheckboxButton' | 'Input' | 'Autocomplete' | 'InputNumber' | 'Select' | 'Cascader' | 'Switch' | 'Slider' | 'TimePicker' | 'DatePicker' | 'Rate' | 'ColorPicker' | 'Mention' | 'Transfer' | 'TimeSelect' | 'SelectV2' | 'TreeSelect' | 'Upload';

        $viewTypes = [
            'select' => '() => MaDictSelect',
            'radio' => '() => MaDictRadio',
            'checkbox' => '() => MaDictCheckbox',
            'uploadImage' => '() => MaUploadImage',
            'uploadFile' => '() => MaUploadFile',

            'text' => 'input',
            'password' => 'input-password',
            'textarea' => 'mention',
            'inputNumber' => 'input-number',
            'inputTag' => 'input-tag',
            'switch' => 'switch',
            'slider' => 'slider',
            'treeSelect' => 'tree-select',
            'date' => 'DatePicker',
            'time' => 'TimePicker',
            'rate' => 'rate',
            'cascader' => 'cascader',
            'transfer' => 'transfer',
            'selectUser' => 'user-select',
            'userInfo' => 'user-info',
            'cityLinkage' => 'city-linkage',
            'icon' => 'icon-picker',
            'formGroup' => 'form-group',
            'selectResource' => 'resource',
            'editor' => 'editor',
            'wangEditor' => 'wang-editor',
            'codeEditor' => 'code-editor',
        ];

        return $viewTypes[$viewType] ?? 'input';
    }

    protected function commonImportAdd($commonImport): void
    {
        if (in_array($commonImport, $this->commonImport)) {
            return ;
        }
        $this->commonImport[] = $commonImport;
    }

    protected function apiImportAdd($apiImport): void
    {
        if (in_array($apiImport, $this->apiImport)) {
            return ;
        }
        $this->apiImport[] = $apiImport;
    }

    protected $columnInit = [];

    protected function columnInitAdd(string $code)
    {
        $this->columnInit[$code] = $code;
    }

    protected function importJsAdd($import): void
    {
        if (in_array($import, $this->importJs)) {
            return ;
        }
        $this->importJs[] = $import;
    }

    /**
     * @param mixed $column
     * @return array
     */
    public function formColumnAttr(mixed $column, $class): array
    {
        $tmp = [
            'label' => empty($column->column_comment) ? $column->column_name : $column->column_comment,
            'prop' => $column->column_name,
            'render' => $this->getViewType($column->view_type),
            'renderProps' => [
                'placeholder' => sprintf("t('form.pleaseInput', { msg: '%s'})", $column['column_comment']),
            ],
        ];
        if ($class == VueDataFormItemsGenerator::class && $column['is_required'] == self::YES) {
            $tmp['itemProps']['rules'] = [
                [
                    'required' => true,
                    'message' => "请输入{$column['column_comment']}"
                ]
            ];
        }
        if ($column->view_type == "textarea") {
            $tmp['renderProps']['type'] = "textarea";
        }
        // 扩展项
        if (!empty($column->options)) {
            $collection = $column->options['collection'] ?? [];
            // 合并
            $tmp = array_merge($tmp, $column->options);
            // 自定义数据
            if (in_array($column->view_type, ['checkbox', 'radio', 'select', 'transfer']) && !empty($collection)) {
                $function_name = Str::camel($this->getBusinessEnName() . '_' . $column['column_name']) . 'DictData';
                $this->commonImportAdd($function_name);
                $tmp['renderProps'] = array_merge($tmp['renderProps'] ?? [], [
                    'data' => "{$function_name}()"
                ]);
            }
            unset($tmp['collection']);
        }

        return $tmp;
    }

    /**
     * @return void
     */
    protected function genImportJsList(): void
    {
        if (!empty($this->apiImport)) {
            $module = $this->getModuleName();
            $businessEnName = $this->getBusinessEnName();
            $this->importJsAdd(sprintf("import %s from '~/{$module}/api/{$businessEnName}.ts'", sprintf("{ %s }", implode(', ', $this->apiImport))));
        }

        if (!empty($this->commonImport)) {
            $this->importJsAdd(sprintf("import %s  from './common.tsx'", sprintf("{ %s }", implode(', ', $this->commonImport))));
        }
    }

}
