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
namespace Plugin\Cms\Request\Snippets;

use Hyperf\Validation\Request\FormRequest;

/**
 * 固定代码表验证数据类
 */
class JileappCmsSnippetsRequest extends FormRequest
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
            //名称 验证
            'name' => 'required',
            //调用代码 验证
            'code' => 'required',

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
            'name' => '名称',
            'code' => '调用代码',

        ];
    }

public function messages(): array
{
    return [
            'id.required' => '必填id',
            'name.required' => '必填名称',
            'code.required' => '必填调用代码',

    ];
}
}