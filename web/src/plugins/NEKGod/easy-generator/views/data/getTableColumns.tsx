/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://github.com/mineadmin
 */
import type {MaProTableColumns, MaProTableExpose} from '@mineadmin/pro-table'
import type {UserVo} from '~/base/api/user.ts'

import defaultAvatar from '@/assets/images/defaultAvatar.jpg'
import {ElTag} from 'element-plus'
import hasAuth from '@/utils/permission/hasAuth.ts'
import type {TableColumnRenderer} from "@mineadmin/table";
import {useMessage} from "@/hooks/useMessage.ts";
import {getGenerateApi} from "../../api/codeApi.ts";
import {deleteByIds} from "~/base/api/user.ts";
import {ResultCode} from "@/utils/ResultCode.ts";
const download = (res, downName = '') => {
  const aLink = document.createElement('a');
  let fileName = downName
  let blob = res //第三方请求返回blob对象

  //通过后端接口返回
  if (res.headers && res.data) {
    blob = new Blob([res.data], {type: res.headers['content-type'].replace(';charset=utf8', '')})
    if (!downName) {
      const contentDisposition = decodeURI(res.headers['content-disposition'])
      const result = contentDisposition.match(/filename\*=utf-8\'\'(.+)/gi)
      fileName = result[0].replace(/filename\*=utf-8\'\'/gi, '')
    }
  }

  aLink.href = URL.createObjectURL(blob)
  // 设置下载文件名称
  aLink.setAttribute('download', fileName)
  document.body.appendChild(aLink)
  aLink.click()
  document.body.removeChild(aLink)
  URL.revokeObjectURL(aLink.href)
}

export default function getTableColumns(t: any, comp: any): MaProTableColumns[] {
  const dictStore = useDictStore()
  const { editInfoRef, proTableRef } = comp
  const msg = useMessage()

  return [
    // 多选列
    {
      type: 'selection', showOverflowTooltip: false, label: () => t('crud.selection'),
    },
    // 索引序号列
    {label: 'id', prop: 'id', width: 80},
    {label: '表名称', prop: 'table_name', search: true, width: 200},
    {label: '表描述', prop: 'table_comment', width: 200},
    {
      label: '生成类型', prop: 'type', formType: 'select', width: 120,
      // dict: { data: types, translation: true },
    },
    {label: '创建时间', prop: 'created_at'},
    // 操作列
    {
      type: 'operation',
      width: 360,
      label: () => t('crud.operation'),
      operationConfigure: {
        type: 'tile',
        actions: [
          // {
          //   name: 'preview',
          //   icon: 'i-hugeicons:laptop-programming',
          //   text: () => '预览',
          //   onClick: async ({ row }) => {
          //     row.database_connection = 'default'
          //     await router.push({ path: `/code-generator-editor/${row.database_connection}/${row.name}` })
          //   },
          // },
          {
            name: 'edit',
            icon: 'i-tabler:settings-code',
            text: () => '设置生成信息',
            onClick: async ({ row }) => {
              row.database_connection = 'default'
              editInfoRef.value.open(row)
              editInfoRef.value.callback(() => {
                proTableRef.value.refresh()
              })
            },
          },

          {
            name: 'generator',
            icon: 'i-solar:code-file-linear',
            text: () => '生成代码',
            onClick: async ({ row }) => {
              console.log(row)
              const response  = await getGenerateApi().generateCode({ ids: row.id.toString().split(',') })

              download(response, `MineAdmin ${row.table_name} ${row.updated_at}.zip`)
            },
          },
          // {
          //   name: 'reloadTable',
          //   icon: 'i-solar:code-file-linear',
          //   text: () => '重载表',
          //   onClick: async ({ row }) => {
          //     msg.confirm(t('重载表，会刷新表的保存信息？')).then(async () => {
          //       const response = await getGenerateApi().sync(row.id)
          //       if (response.code === ResultCode.SUCCESS) {
          //         msg.success(t('重载表成功'))
          //         proTableRef.value.refresh()
          //       }
          //     })
          //   },
          // },
          {
            name: 'del',
            icon: 'mdi:delete',
            text: () => t('crud.delete'),
            onClick: ({ row }, proxy: MaProTableExpose) => {
              console.log(row.id)
              msg.delConfirm(t('crud.delDataMessage')).then(async () => {
                const response = await getGenerateApi().deletes({ids: [row.id]})
                if (response.code === ResultCode.SUCCESS) {
                  msg.success(t('crud.delSuccess'))
                  proTableRef.value.refresh()
                }
              })
            },
          },
        ],
      },
    },
  ]
}
