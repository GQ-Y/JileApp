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
 * JileappCmsTag API JS
 */

/**
* 获取JileappCmsTag分页列表
* @returns
*/
export function page(data: any): Promise<ResponseStruct<any>> {
    return useHttp().get('tag/jileappCmsTag/list', { params: data })
}

/**
* 添加JileappCmsTag
* @returns
*/
export function create(data: any): Promise<ResponseStruct<any>> {
  return useHttp().post('tag/jileappCmsTag', data)
}
/**
* 更新JileappCmsTag数据
* @returns
*/
export function save(id: number, data: any): Promise<ResponseStruct<any>> {
    return useHttp().put(`tag/jileappCmsTag/${id}`, data)
}

/**
* 将JileappCmsTag删除，有软删除则移动到回收站
* @returns
*/
export function deleteByIds(ids: number[]): Promise<ResponseStruct<null>> {
  return useHttp().delete('tag/jileappCmsTag', { data: ids })
}