<?php
namespace Plugin\Cms\Schema\Tag;

use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use Plugin\Cms\Model\Tag\JileappCmsTag;

/**
 * 文章标签表
 */
#[Schema(title: 'JileappCmsTagSchema')]
class JileappCmsTagSchema implements \JsonSerializable
{
    #[Property(property: 'id', title: 'id', type: 'bigint')]
    public string $id;

    #[Property(property: 'name_title', title: '标签名称', type: 'varchar')]
    public string $name_title;

    #[Property(property: 'slug_title', title: '标签别名', type: 'varchar')]
    public string $slug_title;

    #[Property(property: 'status_switch', title: '开关', type: 'varchar')]
    public string $status_switch;

    #[Property(property: 'created_by', title: '创建者', type: 'bigint')]
    public string $created_by;

    #[Property(property: 'updated_by', title: '更新者', type: 'bigint')]
    public string $updated_by;

    #[Property(property: 'created_at', title: '创建时间', type: 'timestamp')]
    public string $created_at;

    #[Property(property: 'updated_at', title: '更新时间', type: 'timestamp')]
    public string $updated_at;

    #[Property(property: 'deleted_at', title: '删除时间', type: 'timestamp')]
    public string $deleted_at;




    public function __construct(JileappCmsTag $model)
    {
       $this->id = $model->id;
       $this->name_title = $model->name_title;
       $this->slug_title = $model->slug_title;
       $this->status_switch = $model->status_switch;
       $this->created_by = $model->created_by;
       $this->updated_by = $model->updated_by;
       $this->created_at = $model->created_at;
       $this->updated_at = $model->updated_at;
       $this->deleted_at = $model->deleted_at;

    }

    public function jsonSerialize(): array
    {
        return ['id' => $this->id ,'name_title' => $this->name_title ,'slug_title' => $this->slug_title ,'status_switch' => $this->status_switch ,'created_by' => $this->created_by ,'updated_by' => $this->updated_by ,'created_at' => $this->created_at ,'updated_at' => $this->updated_at ,'deleted_at' => $this->deleted_at];
    }
}