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
      label: t('cms.tag.name'), prop: 'name_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.tag.name') }) }, itemProps: {
        rules: [
          { required: true, message: t('form.pleaseInput', { msg: t('cms.tag.name') }) },
        ],
      },
    },
    {
      label: t('cms.tag.alias'), prop: 'slug_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.tag.alias') }) }, itemProps: {

      },
    },
    { label: t('cms.tag.status'), prop: 'status_switch', render: 'switch', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.tag.status') }) } },
  ])
}
