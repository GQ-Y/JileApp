<?php
declare(strict_types=1);
/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://gitee.com/xmo/MineAdmin
 */
namespace Plugin\Cms\Request\Article;

use Hyperf\Validation\Request\FormRequest;

/**
 * 文章表验证数据类
 */
class JileappCmsArticleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    /**
     * 新增数据验证规则
     * return array
     */
    public function rules(): array
    {
        return [
            //文章标题 验证
            'title_title' => 'required',

        ];
    }


    /**
     * 字段映射名称
     * return array
     */
    public function attributes(): array
    {
        return [
            'id' => 'id',
            'title_title' => '文章标题',

        ];
    }

public function messages(): array
{
    return [
            'id.required' => '必填id',
            'title_title.required' => '必填文章标题',

    ];
}
}