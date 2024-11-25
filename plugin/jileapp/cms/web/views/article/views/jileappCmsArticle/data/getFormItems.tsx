/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://github.com/mineadmin
 */
import type { MaFormItem } from '@mineadmin/form'
import MaUploadImage from '@/components/ma-upload-image/index.vue'
import MaDictRadio from '@/components/ma-dict-picker/ma-dict-radio.vue'
import MaRemoteSelect from '@/components/ma-remote-select/index.vue'
import { concat } from 'lodash-es'
import { formatPublishedAt, jileappCmsArticleStatusDictData } from './common.tsx'

export default function getFormItems(_formType: 'add' | 'edit' = 'add', t: any, _model: any): MaFormItem[] {
  if (_formType === 'add') {
    _model.status = 0
  }

  return concat([
    {
      label: t('cms.article.title'),
      prop: 'title_title',
      render: 'input',
      renderProps: {
        placeholder: t('form.pleaseInput', { msg: t('cms.article.title') }),
      },
      itemProps: {
        rules: [
          { required: true, message: t('form.pleaseInput', { msg: t('cms.article.title') }) },
        ],
      },
    },
    {
      label: t('cms.article.categorie'),
      prop: 'category_id',
      render: () => MaRemoteSelect,
      renderProps: {
        placeholder: t('form.pleaseInput', { msg: t('cms.article.categorie') }),
        multiple: false,
        url: '/categorie/jileappCmsCategorie/list',
        axiosConfig: {
          method: 'get',
          params: { pageSize: 9999 },
        },
        dataHandle: (response: any) => {
          const formatTree = (list: any[], parentId: number | string = 0): any[] => {
            return list
              .filter(item => item.status_switch === '1' && item.parent_id === parentId)
              .map(item => ({
                label: item.name_title || '',
                value: item.id,
                children: formatTree(list, item.id),
              }))
              .filter(item => item.label)
          }
          console.log(formatTree(response.data.list || []))
          return formatTree(response.data.list || [])
        },
      },
    },
    {
      label: t('cms.article.tag'),
      prop: 'tag_id',
      render: () => MaRemoteSelect,
      renderProps: {
        placeholder: t('form.pleaseInput', { msg: t('cms.article.tag') }),
        multiple: true,
        url: '/tag/jileappCmsTag/list',
        axiosConfig: {
          method: 'get',
          params: { pageSize: 9999 },
        },
        dataHandle: (response: any) => {
          return (response.data.list || [])
            .filter((item: any) => item.status_switch === '1')
            .map((item: any) => ({
              label: item.name_title || '',
              value: item.id,
            }))
            .filter((item: any) => item.label)
        },
      },
    },
    {
      label: t('cms.article.summary'),
      prop: 'summary_text',
      render: 'mention',
      renderProps: {
        placeholder: t('form.pleaseInput', { msg: t('cms.article.summary') }),
        type: 'textarea',
      },
    },
    {
      label: t('cms.article.content'),
      prop: 'content_editor',
      render: 'mention',
      renderProps: {
        placeholder: t('form.pleaseInput', { msg: t('cms.article.content') }),
        type: 'textarea',
      },
    },
    {
      label: t('cms.article.thumbnail'),
      prop: 'thumbnail_image',
      render: () => MaUploadImage,
      renderProps: {
        placeholder: t('form.pleaseInput', { msg: t('cms.article.thumbnail') }),
      },
      multiple: false,
    },
    {
      label: t('cms.article.status'),
      prop: 'status',
      render: () => MaDictRadio,
      renderProps: {
        placeholder: t('form.pleaseInput', { msg: t('cms.article.status') }),
        data: jileappCmsArticleStatusDictData(t),
      },
    },
    {
      label: t('cms.article.publishedAt'),
      prop: 'published_at',
      render: 'DatePicker',
      renderProps: {
        placeholder: t('form.pleaseInput', { msg: t('cms.article.publishedAt') }),
        valueFormat: 'YYYY-MM-DD HH:mm:ss',
        format: 'YYYY-MM-DD HH:mm:ss',
      },
      mode: 'date',
      showTime: true,
    },
  ])
}
