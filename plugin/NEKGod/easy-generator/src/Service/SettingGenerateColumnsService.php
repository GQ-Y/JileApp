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

namespace Plugin\NEK\CodeGenerator\Service;

use Plugin\NEK\CodeGenerator\Mapper\SettingGenerateColumnsMapper;
use Plugin\NEK\CodeGenerator\Model\SettingGenerateColumns;
use Mine\Abstracts\AbstractService;
use Mine\Interfaces\ServiceInterface\GenerateColumnServiceInterface;

/**
 * 业务生成字段信息表业务处理类
 * Class SettingGenerateColumnsService.
 */
class SettingGenerateColumnsService extends AbstractService implements GenerateColumnServiceInterface
{
    /**
     * @var SettingGenerateColumnsMapper
     */
    public $mapper;

    /**
     * SettingGenerateColumnsService constructor.
     */
    public function __construct(SettingGenerateColumnsMapper $mapper)
    {
        $this->mapper = $mapper;
    }

    /**
     * 循环插入数据.
     */
    public function save(array $data): mixed
    {
        $default_column = ['created_at', 'updated_at', 'created_by', 'updated_by', 'deleted_at', 'remark'];
        // 组装数据
        foreach ($data as $k => $item) {
            $column = [
                'table_id' => $item['table_id'],
                'column_name' => $item['column_name'],
                'column_comment' => $item['column_comment'],
                'column_type' => $item['data_type'],
                'is_pk' => empty($item['column_key']) ? SettingGenerateColumns::NO : SettingGenerateColumns::YES,
                'is_required' => $item['is_nullable'] == 'NO' ? SettingGenerateColumns::YES : SettingGenerateColumns::NO,
                'query_type' => 'eq',
                'view_type' => 'text',
                'sort' => count($data) - $k,
                'allow_roles' => $item['allow_roles'] ?? null,
                'options' => $item['options'] ?? null,
                'extra' => $item['extra'],
            ];

            // 设置默认选项
            if (! in_array($item['column_name'], $default_column) && empty($item['column_key'])) {
                $column = array_merge(
                    $column,
                    [
                        'is_insert' => SettingGenerateColumns::YES,
                        'is_edit' => SettingGenerateColumns::YES,
                        'is_list' => SettingGenerateColumns::YES,
                        'is_query' => SettingGenerateColumns::YES,
                        'is_sort' => SettingGenerateColumns::NO,
                    ]
                );
            }

            $this->mapper->save(
                $this->fieldDispose($column)
            );
        }
        return 1;
    }

    public function update(mixed $id, array $data): bool
    {
        $data['is_insert'] = $data['is_insert'] ? SettingGenerateColumns::YES : SettingGenerateColumns::NO;
        $data['is_edit'] = $data['is_edit'] ? SettingGenerateColumns::YES : SettingGenerateColumns::NO;
        $data['is_list'] = $data['is_list'] ? SettingGenerateColumns::YES : SettingGenerateColumns::NO;
        $data['is_query'] = $data['is_query'] ? SettingGenerateColumns::YES : SettingGenerateColumns::NO;
        $data['is_sort'] = $data['is_sort'] ? SettingGenerateColumns::YES : SettingGenerateColumns::NO;
        $data['is_required'] = $data['is_required'] ? SettingGenerateColumns::YES : SettingGenerateColumns::NO;
        return $this->mapper->update($id, $data);
    }

    private function fieldDispose(array $column): array
    {
        $object = new class {
            public function viewTypeDispose(&$column): void
            {
                switch ($column['column_type']) {
                    case 'varchar':
                        $column['query_type'] = 'like';
                        $column['view_type'] = 'text';
                        break;
                        // 富文本
                    case 'text':
                    case 'longtext':
                        $column['is_list'] = SettingGenerateColumns::NO;
                        $column['is_query'] = SettingGenerateColumns::NO;
                        $column['view_type'] = 'editor';
                        break;
                        // 日期字段
                    case 'timestamp':
                    case 'datetime':
                        $column['view_type'] = 'date';
                        $column['options']['mode'] = 'date';
                        $column['options']['showTime'] = true;
                        $column['query_type'] = 'between';
                        break;
                    case 'date':
                        $column['view_type'] = 'date';
                        $column['options']['mode'] = 'date';
                        $column['options']['showTime'] = false;
                        $column['query_type'] = 'between';
                        break;
                    case 'json':
                        $column['is_list'] = SettingGenerateColumns::NO;
                        $column['is_query'] = SettingGenerateColumns::NO;
                        break;
                }
            }

            public function columnCommentDispose(&$column): void
            {
                $column_names = explode('_', $column['column_name']);
//                if (in_array('id', $column_names)) {
//                    $column['view_type'] = 'select';
//                }else if (in_array('ids', $column_names)) {
//                    $column['view_type'] = 'select';
//                    $column['options']['renderProps'] = [];
//                    $column['options']['renderProps']['multiple'] = true;
//                }
                if (preg_match('/.*:.*=.*/m', $column['column_comment'])) {
                    $regs = explode(':', $column['column_comment']);
                    $column['column_comment'] = $regs[0] ?? '';
                    if (in_array('radio', $column_names)) {
                        $column['view_type'] = 'radio';
                    }else if (in_array('checkbox', $column_names)) {
                        $column['view_type'] = 'checkbox';
                    }else if (in_array('selects', $column_names)) {
                        $column['view_type'] = 'select';
                        $column['options']['renderProps'] = [];
                        $column['options']['renderProps']['multiple'] = true;
                    }else{
                        $column['view_type'] = 'select';
                    }

                    $column['options']['collection'] = array_map(function ($item) {
                        $item = explode('=', $item);
                        return [
                            'label' => $item[1] ?? '',
                            'value' => $item[0] ?? '',
                        ];
                    }, explode(',', $regs[1] ?? ''));
                }
            }

            public function columnName(&$column): void
            {
                if (stristr($column['column_name'], 'status')) {
                    $column['view_type'] = 'radio';
                }

                if (stristr($column['column_name'], 'textarea')) {
                    $column['is_query'] = SettingGenerateColumns::NO;
                    $column['view_type'] = 'textarea';
                }

                if (str_contains($column['column_name'], 'switch')) {
                    $column['is_query'] = SettingGenerateColumns::NO;
                    $column['view_type'] = 'switch';
                }

                if (stristr($column['column_name'], 'image')) {
                    $column['is_query'] = SettingGenerateColumns::NO;
                    $column['view_type'] = 'uploadImage';
                    $column['options']['multiple'] = false;
                    $column['query_type'] = 'eq';
                }

                if (stristr($column['column_name'], 'images')) {
                    $column['is_query'] = SettingGenerateColumns::NO;
                    $column['view_type'] = 'uploadImage';
                    $column['options']['multiple'] = true;
                    $column['query_type'] = 'eq';
                }

                if (stristr($column['column_name'], 'file')) {
                    $column['is_query'] = SettingGenerateColumns::NO;
                    $column['view_type'] = 'uploadFile';
                    $column['options']['multiple'] = false;
                    $column['query_type'] = 'eq';
                }

                if (stristr($column['column_name'], 'files')) {
                    $column['is_query'] = SettingGenerateColumns::NO;
                    $column['view_type'] = 'uploadFile';
                    $column['options']['multiple'] = true;
                    $column['query_type'] = 'eq';
                }
            }
        };

        $object->viewTypeDispose($column);
        $object->columnCommentDispose($column);
        $object->columnName($column);
        return $column;
    }
}
