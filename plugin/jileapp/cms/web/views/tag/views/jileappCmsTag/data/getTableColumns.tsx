/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://github.com/mineadmin
 */
import type { MaProTableColumns, MaProTableExpose } from '@mineadmin/pro-table'
import type { UseDialogExpose } from '@/hooks/useDialog.ts'

import defaultAvatar from '@/assets/images/defaultAvatar.jpg'
import { ElTag } from 'element-plus'
import { useMessage } from '@/hooks/useMessage.ts'
import { ResultCode } from '@/utils/ResultCode.ts'
import hasAuth from '@/utils/permission/hasAuth.ts'
import { deleteByIds } from '../../../api/jileappCmsTag.ts'
import { jileappCmsTagStatusDictData } from './common.tsx'
export default function getTableColumns(dialog: UseDialogExpose, formRef: any, t: any): MaProTableColumns[] {
  const msg = useMessage()

  return [
    { type: 'selection', showOverflowTooltip: false, label: () => t('crud.selection') },
    { label: 'id', prop: 'id' },
    { label: t('cms.tag.name'), prop: 'name_title' },
    { label: t('cms.tag.alias'), prop: 'slug_title' },
    {
      label: t('cms.tag.status'), prop: 'status_switch', cellRender: ({ row }) => {
        return (
          <ElTag type='primary'>
            {jileappCmsTagStatusDictData(t).find((item: any) => item.value === row.status_switch)?.label}
          </ElTag>
        )
      },
    },
    {
      type: 'operation', label: () => t('crud.operation'), operationConfigure: {
        actions: [
          {
            name: 'edit', icon: 'material-symbols:person-edit', text: () => t('crud.edit'), onClick: ({ row }) => {
              dialog.setTitle(t('crud.edit'))
              dialog.open({ formType: 'edit', data: row })
            }
          },
          {
            name: 'del', icon: 'mdi:delete', text: () => t('crud.delete'), onClick: ({ row }, proxy: MaProTableExpose) => {
              msg.delConfirm(t('crud.delDataMessage')).then(async () => {
                const response = await deleteByIds([row.id])
                if (response.code === ResultCode.SUCCESS) {
                  msg.success(t('crud.delSuccess'))
                  proxy.refresh()
                }
              })
            }
          },
        ]
      }
    },
  ]
}
