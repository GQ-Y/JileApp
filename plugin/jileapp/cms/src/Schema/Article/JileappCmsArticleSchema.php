<?php
namespace Plugin\Cms\Schema\Article;

use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;
use Plugin\Cms\Model\Article\JileappCmsArticle;

/**
 * 文章表
 */
#[Schema(title: 'JileappCmsArticleSchema')]
class JileappCmsArticleSchema implements \JsonSerializable
{
    #[Property(property: 'id', title: 'id', type: 'bigint')]
    public string $id;

    #[Property(property: 'title_title', title: '文章标题', type: 'varchar')]
    public string $title_title;

    #[Property(property: 'slug_title', title: '文章别名', type: 'varchar')]
    public string $slug_title;

    #[Property(property: 'summary_text', title: '文章摘要', type: 'text')]
    public string $summary_text;

    #[Property(property: 'content_editor', title: '文章内容', type: 'longtext')]
    public string $content_editor;

    #[Property(property: 'thumbnail_image', title: '缩略图', type: 'varchar')]
    public string $thumbnail_image;

    #[Property(property: 'category_id', title: '分类ID', type: 'bigint')]
    public string $category_id;

    #[Property(property: 'status', title: '状态', type: 'tinyint')]
    public string $status;

    #[Property(property: 'published_at', title: '发布时间', type: 'timestamp')]
    public string $published_at;

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




    public function __construct(JileappCmsArticle $model)
    {
       $this->id = $model->id;
       $this->title_title = $model->title_title;
       $this->slug_title = $model->slug_title;
       $this->summary_text = $model->summary_text;
       $this->content_editor = $model->content_editor;
       $this->thumbnail_image = $model->thumbnail_image;
       $this->category_id = $model->category_id;
       $this->status = $model->status;
       $this->published_at = $model->published_at;
       $this->created_by = $model->created_by;
       $this->updated_by = $model->updated_by;
       $this->created_at = $model->created_at;
       $this->updated_at = $model->updated_at;
       $this->deleted_at = $model->deleted_at;

    }

    public function jsonSerialize(): array
    {
        return ['id' => $this->id ,'title_title' => $this->title_title ,'slug_title' => $this->slug_title ,'summary_text' => $this->summary_text ,'content_editor' => $this->content_editor ,'thumbnail_image' => $this->thumbnail_image ,'category_id' => $this->category_id ,'status' => $this->status ,'published_at' => $this->published_at ,'created_by' => $this->created_by ,'updated_by' => $this->updated_by ,'created_at' => $this->created_at ,'updated_at' => $this->updated_at ,'deleted_at' => $this->deleted_at];
    }
}