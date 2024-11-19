<?php

namespace Plugin\MineAdmin\CodeGenerator\Model;

use Hyperf\DbConnection\Model\Model;
use Plugin\MineAdmin\CodeGenerator\Model\Enums\SearchTypeEnum;

/**
 * @property string $name
 * @property string $type
 * @property string $comment
 * @property bool $is_required
 * @property bool $is_form
 * @property bool $is_list
 * @property bool $is_query
 * @property bool $is_sort
 * @property SearchTypeEnum $query_type
 * @property string $permission
 * @property string $form_component
 * @property string $form_component_name
 * @property array $form_component_config
 */
final class FieldSetting extends Model
{
    public bool $incrementing = false;

    public string $keyType = 'string';

    protected array $fillable = [
        'name', 'comment', 'type', 'is_required', 'is_form', 'is_list',
        'is_query', 'is_sort', 'query_type', 'permission', 'form_component', 'form_component_name', 'form_component_config'
    ];

    protected array $casts = [
        'name' => 'string',
        'type' => 'string',
        'comment' => 'string',
        'is_required' => 'boolean',
        'is_form' => 'boolean',
        'is_list' => 'boolean',
        'is_query' => 'boolean',
        'is_sort' => 'boolean',
        'query_type' => SearchTypeEnum::class,
        'form_component' => 'string',
        'form_componen_name' => 'string',
        'form_component_config' => 'array',
    ];
}