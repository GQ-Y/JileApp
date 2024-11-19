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
import { keyBy, get } from 'lodash-es'
import { deleteByIds } from '../../../api/jileappCmsAdvertisement.ts'
import { jileappCmsAdvertisementStatusDictData, jileappCmsAdvertisementTypeRadioDictData } from './common.tsx'

export default function getTableColumns(dialog: UseDialogExpose, formRef: any, t: any): MaProTableColumns[] {
  const jileappCmsAdvertisementTypeRadioMap = keyBy(jileappCmsAdvertisementTypeRadioDictData(t), 'value')
  const msg = useMessage()
  return [
    { type: 'selection', showOverflowTooltip: false, label: () => t('crud.selection') },
    { label: t('cms.advertisement.title'), prop: 'title_title' },
    {
      label: t('cms.advertisement.type'), prop: 'type_radio', cellRender: ({ row }) => {
        return (
          <ElTag type='primary'>
            {get(jileappCmsAdvertisementTypeRadioMap, row.type_radio, { label: t('cms.advertisement.unknown') }).label}
          </ElTag>
        )
      },
    },
    { label: t('cms.advertisement.content'), prop: 'textarea' },
    {
      label: t('cms.advertisement.image'), prop: 'content_image', multiple: false, cellRender: ({ row }) => {
        return (
          <el-popover>
            {{
              reference: () => {
                return (<el-avatar src={row.content_image} />)
              },
              default: () => {
                return (<el-image src={row.content_image}></el-image>)
              },
            }}
          </el-popover>
        )
      },
    },
    {
      label: t('cms.advertisement.video'), prop: 'video_file', multiple: false, cellRender: ({ row }) => {
        return (
          <el-link onClick={() => row?.video_file ? window.open(row?.video_file) : msg.info(t('cms.advertisement.noFile'))} target='_blank'>
            <icon-view />{t('cms.advertisement.viewFile')}
          </el-link>
        )
      },
    },
    { label: t('cms.advertisement.url'), prop: 'url_title' },
    { label: t('cms.advertisement.startTime'), prop: 'start_time', mode: 'date', showTime: true },
    { label: t('cms.advertisement.endTime'), prop: 'end_time', mode: 'date', showTime: true },
    { label: t('cms.advertisement.status'), prop: 'status_switch', cellRender: ({ row }) => {
      return (
        <ElTag type='primary'>
          { jileappCmsAdvertisementStatusDictData.find((item: any) => item.value === row.status_switch)?.label }
        </ElTag>
      )
    },
    },
    { label: t('cms.advertisement.sort'), prop: 'sort' },
    {
      type: 'operation', label: () => t('crud.operation'), operationConfigure: {
        actions: [
          {
            name: 'edit', icon: 'material-symbols:person-edit', text: () => t('crud.edit'), onClick: ({ row }) => {
              dialog.setTitle(t('crud.edit'))
              dialog.open({ formType: 'edit', data: row })
            },
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
            },
          },
        ],
      },
    },
  ]
}
