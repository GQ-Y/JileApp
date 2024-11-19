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
import type { TableVo } from './types'

export function codeGeneratorTableInfo(data: TableVo): Promise<ResponseStruct<PageList<TableVo>>> {
  return useHttp().get('/plugin/codeGenerator/getTableInfo', { params: data })
}

export function getGenerateApi() {
  return {
    loadTable(data: any){
      return useHttp().post('/setting/code/loadTable', data)
    },
    /**
     * 获取代码生成列表
     * @returns
     */
    getPageList (data = {}) {
      return useHttp().get('/setting/code/index', { params: data })
    },
    readTable (data = {}) {
      return useHttp().get('setting/code/readTable', { params: data })
    },
    // 获取表中字段信息
    getTableColumns(params = {}) {
      return useHttp().get('setting/code/getTableColumns', { params: params })
    },
    update(data = {}){
      return useHttp().post('setting/code/update', data)
    },
    generateCode(data = {}){
      return useHttp().post('setting/code/generate', data, {
        responseType: 'blob'
      })
    },
    sync (id) {
      return useHttp().put('setting/code/sync/' + id)
    },
    deletes (data = {}) {
      return useHttp().delete('setting/code/delete', {data: data})
    },
  }
}
