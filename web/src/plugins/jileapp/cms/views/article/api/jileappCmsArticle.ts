/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn> and NEKGod<1559096467@qq.com>
 * @Link   https://github.com/mineadmin
 */

/**
 * JileappCmsArticle API JS
 */

/**
* 获取JileappCmsArticle分页列表
* @returns
*/
export function page(data: any): Promise<ResponseStruct<any>> {
    return useHttp().get('article/jileappCmsArticle/list', { params: data })
}

/**
* 添加JileappCmsArticle
* @returns
*/
export function create(data: any): Promise<ResponseStruct<any>> {
  return useHttp().post('article/jileappCmsArticle', data)
}
/**
* 更新JileappCmsArticle数据
* @returns
*/
export function save(id: number, data: any): Promise<ResponseStruct<any>> {
    return useHttp().put(`article/jileappCmsArticle/${id}`, data)
}

/**
* 将JileappCmsArticle删除，有软删除则移动到回收站
* @returns
*/
export function deleteByIds(ids: number[]): Promise<ResponseStruct<null>> {
  return useHttp().delete('article/jileappCmsArticle', { data: ids })
}