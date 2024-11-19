<?php
namespace Plugin\Cms\Schema\Advertisement;

use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use Plugin\Cms\Model\Advertisement\JileappCmsAdvertisement;

/**
 * 广告表
 */
#[Schema(title: 'JileappCmsAdvertisementSchema')]
class JileappCmsAdvertisementSchema implements \JsonSerializable
{
    #[Property(property: 'id', title: 'id', type: 'bigint')]
    public string $id;

    #[Property(property: 'title_title', title: '广告标题', type: 'varchar')]
    public string $title_title;

    #[Property(property: 'position_id', title: '广告位ID', type: 'bigint')]
    public string $position_id;

    #[Property(property: 'type_radio', title: '类型', type: 'tinyint')]
    public string $type_radio;

    #[Property(property: 'textarea', title: '内容', type: 'varchar')]
    public string $textarea;

    #[Property(property: 'content_image', title: '图片上传', type: 'varchar')]
    public string $content_image;

    #[Property(property: 'video_file', title: '视频上传', type: 'varchar')]
    public string $video_file;

    #[Property(property: 'url_title', title: '链接地址', type: 'varchar')]
    public string $url_title;

    #[Property(property: 'start_time', title: '开始时间', type: 'timestamp')]
    public string $start_time;

    #[Property(property: 'end_time', title: '结束时间', type: 'timestamp')]
    public string $end_time;

    #[Property(property: 'status_switch', title: '开关', type: 'varchar')]
    public string $status_switch;

    #[Property(property: 'sort', title: '排序', type: 'int')]
    public string $sort;

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




    public function __construct(JileappCmsAdvertisement $model)
    {
       $this->id = $model->id;
       $this->title_title = $model->title_title;
       $this->position_id = $model->position_id;
       $this->type_radio = $model->type_radio;
       $this->textarea = $model->textarea;
       $this->content_image = $model->content_image;
       $this->video_file = $model->video_file;
       $this->url_title = $model->url_title;
       $this->start_time = $model->start_time;
       $this->end_time = $model->end_time;
       $this->status_switch = $model->status_switch;
       $this->sort = $model->sort;
       $this->created_by = $model->created_by;
       $this->updated_by = $model->updated_by;
       $this->created_at = $model->created_at;
       $this->updated_at = $model->updated_at;
       $this->deleted_at = $model->deleted_at;

    }

    public function jsonSerialize(): array
    {
        return ['id' => $this->id ,'title_title' => $this->title_title ,'position_id' => $this->position_id ,'type_radio' => $this->type_radio ,'textarea' => $this->textarea ,'content_image' => $this->content_image ,'video_file' => $this->video_file ,'url_title' => $this->url_title ,'start_time' => $this->start_time ,'end_time' => $this->end_time ,'status_switch' => $this->status_switch ,'sort' => $this->sort ,'created_by' => $this->created_by ,'updated_by' => $this->updated_by ,'created_at' => $this->created_at ,'updated_at' => $this->updated_at ,'deleted_at' => $this->deleted_at];
    }
}