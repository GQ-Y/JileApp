<?php
namespace Plugin\Cms\Schema\Position;

use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use Plugin\Cms\Model\Position\JileappCmsAdPosition;

/**
 * 广告位表
 */
#[Schema(title: 'JileappCmsAdPositionSchema')]
class JileappCmsAdPositionSchema implements \JsonSerializable
{
    #[Property(property: 'id', title: 'id', type: 'bigint')]
    public string $id;

    #[Property(property: 'name_title', title: '广告位名称', type: 'varchar')]
    public string $name_title;

    #[Property(property: 'code_title', title: '广告位代码', type: 'varchar')]
    public string $code_title;

    #[Property(property: 'description_text', title: '描述', type: 'varchar')]
    public string $description_text;

    #[Property(property: 'type_radio', title: '类型', type: 'tinyint')]
    public string $type_radio;

    #[Property(property: 'width_title', title: '宽度', type: 'int')]
    public string $width_title;

    #[Property(property: 'height_title', title: '高度', type: 'int')]
    public string $height_title;

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




    public function __construct(JileappCmsAdPosition $model)
    {
       $this->id = $model->id;
       $this->name_title = $model->name_title;
       $this->code_title = $model->code_title;
       $this->description_text = $model->description_text;
       $this->type_radio = $model->type_radio;
       $this->width_title = $model->width_title;
       $this->height_title = $model->height_title;
       $this->status_switch = $model->status_switch;
       $this->created_by = $model->created_by;
       $this->updated_by = $model->updated_by;
       $this->created_at = $model->created_at;
       $this->updated_at = $model->updated_at;
       $this->deleted_at = $model->deleted_at;

    }

    public function jsonSerialize(): array
    {
        return ['id' => $this->id ,'name_title' => $this->name_title ,'code_title' => $this->code_title ,'description_text' => $this->description_text ,'type_radio' => $this->type_radio ,'width_title' => $this->width_title ,'height_title' => $this->height_title ,'status_switch' => $this->status_switch ,'created_by' => $this->created_by ,'updated_by' => $this->updated_by ,'created_at' => $this->created_at ,'updated_at' => $this->updated_at ,'deleted_at' => $this->deleted_at];
    }
}