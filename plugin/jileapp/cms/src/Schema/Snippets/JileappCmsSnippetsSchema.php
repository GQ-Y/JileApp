<?php
namespace Plugin\Cms\Schema\Snippets;

use App\Model\Snippets\JileappCmsSnippets;
use Hyperf\Swagger\Annotation\Property;
use Hyperf\Swagger\Annotation\Schema;

/**
 * 固定代码表
 */
#[Schema(title: 'JileappCmsSnippetsSchema')]
class JileappCmsSnippetsSchema implements \JsonSerializable
{
    #[Property(property: 'id', title: 'id', type: 'bigint')]
    public string $id;

    #[Property(property: 'name', title: '名称', type: 'varchar')]
    public string $name;

    #[Property(property: 'code', title: '调用代码', type: 'varchar')]
    public string $code;

    #[Property(property: 'content', title: '内容', type: 'text')]
    public string $content;

    #[Property(property: 'description', title: '描述', type: 'varchar')]
    public string $description;

    #[Property(property: 'status', title: '状态', type: 'tinyint')]
    public string $status;

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




    public function __construct(JileappCmsSnippets $model)
    {
       $this->id = $model->id;
       $this->name = $model->name;
       $this->code = $model->code;
       $this->content = $model->content;
       $this->description = $model->description;
       $this->status = $model->status;
       $this->created_by = $model->created_by;
       $this->updated_by = $model->updated_by;
       $this->created_at = $model->created_at;
       $this->updated_at = $model->updated_at;
       $this->deleted_at = $model->deleted_at;

    }

    public function jsonSerialize(): array
    {
        return ['id' => $this->id ,'name' => $this->name ,'code' => $this->code ,'content' => $this->content ,'description' => $this->description ,'status' => $this->status ,'created_by' => $this->created_by ,'updated_by' => $this->updated_by ,'created_at' => $this->created_at ,'updated_at' => $this->updated_at ,'deleted_at' => $this->deleted_at];
    }
}