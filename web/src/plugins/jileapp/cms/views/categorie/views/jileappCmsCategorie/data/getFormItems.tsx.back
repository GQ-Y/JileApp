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
import { concat } from 'lodash-es'

export default function getFormItems(formType: 'add' | 'edit' = 'add', t: any, model: any): MaFormItem[] {
  if (formType === 'add') {
    model.status_switch = true
  }

  return concat([
    {
      label: t('cms.categorie.name'), prop: 'name_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.categorie.name') }) }, itemProps: {
        rules: [
          { required: true, message: t('form.pleaseInput', { msg: t('cms.categorie.name') }) },
        ],
      },
    },
    { label: t('cms.categorie.alias'), prop: 'slug_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.categorie.alias') }) } },
    { label: t('cms.categorie.description'), prop: 'description_text', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.categorie.description') }) } },
    { label: t('cms.categorie.parentId'), prop: 'parent_id', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.categorie.parentId') }) } },
    { label: t('cms.categorie.sort'), prop: 'sort', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.categorie.sort') }) } },
    { label: t('cms.categorie.status'), prop: 'status_switch', render: 'switch', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.categorie.status') }) }, modelValue: true },
  ])
}
