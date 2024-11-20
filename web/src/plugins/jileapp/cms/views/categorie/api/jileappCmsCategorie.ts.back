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
 * JileappCmsCategorie API JS
 */

/**
* 获取JileappCmsCategorie分页列表
* @returns
*/
export function page(data: any): Promise<ResponseStruct<any>> {
    return useHttp().get('categorie/jileappCmsCategorie/list', { params: data })
}

/**
* 添加JileappCmsCategorie
* @returns
*/
export function create(data: any): Promise<ResponseStruct<any>> {
  return useHttp().post('categorie/jileappCmsCategorie', data)
}
/**
* 更新JileappCmsCategorie数据
* @returns
*/
export function save(id: number, data: any): Promise<ResponseStruct<any>> {
    return useHttp().put(`categorie/jileappCmsCategorie/${id}`, data)
}

/**
* 将JileappCmsCategorie删除，有软删除则移动到回收站
* @returns
*/
export function deleteByIds(ids: number[]): Promise<ResponseStruct<null>> {
  return useHttp().delete('categorie/jileappCmsCategorie', { data: ids })
}