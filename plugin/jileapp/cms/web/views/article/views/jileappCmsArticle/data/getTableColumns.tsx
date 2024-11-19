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
import { keyBy, get } from "lodash-es";
import { deleteByIds, save } from '../../../api/jileappCmsArticle.ts'
import { jileappCmsArticleStatusDictData } from './common.tsx'

export default function getTableColumns(dialog: UseDialogExpose, formRef: any, t: any): MaProTableColumns[] {
  const jileappCmsArticleStatusMap = keyBy(jileappCmsArticleStatusDictData(t), 'value')
  const msg = useMessage()

  return [
    { type: 'selection', showOverflowTooltip: false, label: () => t('crud.selection') },
    { label: t('form.id'), prop: 'id' },
    { label: t('cms.article.title'), prop: 'title_title' },
    {
      label: t('cms.article.thumbnail'), prop: 'thumbnail_image', multiple: false, cellRender: ({ row }) => {
        return (
          <el-popover>
          >
            {{
              reference: () => {
                return (<el-avatar src={row.thumbnail_image} />)
              },
              default: () => {
                return (<el-image src={row.thumbnail_image}></el-image>)
              },
            }}
          </el-popover>
        )
      },
    },
    { label: t('cms.article.categoryId'), prop: 'category_id' },
    {
      label: t('cms.article.status'), prop: 'status', cellRender: ({ row }) => {
        return (
          <ElTag type='primary'>
            {get(jileappCmsArticleStatusMap, row.status, { label: '未知' }).label}
          </ElTag>
        )
      },
    },
    { label: t('cms.article.publishedAt'), prop: 'published_at', mode: 'date', showTime: true },
    {
      type: 'operation', label: () => t('crud.operation'), operationConfigure: {
        actions: [
          {
            name: 'publish',
            icon: 'mdi:publish',
            text: () => t('cms.article.published'),
            show: ({ row }) => row.status === 0,
            onClick: ({ row }, proxy: MaProTableExpose) => {
              msg.confirm(t('cms.article.confirmPublish')).then(async () => {
                const response = await save(row.id, { ...row, status: 1 })
                if (response.code === ResultCode.SUCCESS) {
                  msg.success(t('cms.article.publishSuccess'))
                  proxy.refresh()
                }
              })
            },
          },
          {
            name: 'unpublish', 
            icon: 'ic:sharp-unpublished',
            text: () => t('cms.article.unpublished'),
            show: ({ row }) => row.status === 1,
            onClick: ({ row }, proxy: MaProTableExpose) => {
              msg.confirm(t('cms.article.confirmUnpublish')).then(async () => {
                const response = await save(row.id, { ...row, status: 2 })
                if (response.code === ResultCode.SUCCESS) {
                  msg.success(t('cms.article.unpublishSuccess'))
                  proxy.refresh()
                }
              })
            },
          },
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
