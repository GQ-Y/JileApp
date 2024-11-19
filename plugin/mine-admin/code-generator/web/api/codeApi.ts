/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://github.com/mineadmin
 */

import type { PageList, ResponseStruct } from '#/global'
import type { RequestTableInfo, TableVo } from './types'

export function page(data: TableVo): Promise<ResponseStruct<PageList<TableVo>>> {
  return useHttp().get('/admin/user/list', { params: data })
}

export function getTableInfo(data: RequestTableInfo): Promise<ResponseStruct<RequestTableInfo>> {
  return useHttp().get('/admin/plugin/code-generator/get-table-info', { params: data })
}

export function getTableList(data: any = {}, pool: string = 'default'): Promise<ResponseStruct<TableVo>> {
  return useHttp().get(`/admin/plugin/code-generator/database/${pool}`, { params: data })
}

export function saveTableSetting(data: any): Promise<any> {
  return useHttp().post(`/admin/plugin/code-generator/save-table-setting`, data)
}

export function previewCode(data: any): Promise<any> {
  return useHttp().post(`/admin/plugin/code-generator/preview-table`, data)
}

export function generator(data: any): Promise<any> {
  return useHttp().post(`/admin/plugin/code-generator/generator`, data)
}
