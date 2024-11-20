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
 * JileappCmsAdvertisement API JS
 */

/**
* 获取JileappCmsAdvertisement分页列表
* @returns
*/
export function page(data: any): Promise<ResponseStruct<any>> {
    return useHttp().get('advertisement/jileappCmsAdvertisement/list', { params: data })
}

/**
* 添加JileappCmsAdvertisement
* @returns
*/
export function create(data: any): Promise<ResponseStruct<any>> {
  return useHttp().post('advertisement/jileappCmsAdvertisement', data)
}
/**
* 更新JileappCmsAdvertisement数据
* @returns
*/
export function save(id: number, data: any): Promise<ResponseStruct<any>> {
    return useHttp().put(`advertisement/jileappCmsAdvertisement/${id}`, data)
}

/**
* 将JileappCmsAdvertisement删除，有软删除则移动到回收站
* @returns
*/
export function deleteByIds(ids: number[]): Promise<ResponseStruct<null>> {
  return useHttp().delete('advertisement/jileappCmsAdvertisement', { data: ids })
}

/**
* 获取JileappCmsAdPosition分页列表
* @returns
*/
export function getPositionList(data: any): Promise<ResponseStruct<any>> {
  return useHttp().get('position/jileappCmsAdPosition/list', { params: data })
}