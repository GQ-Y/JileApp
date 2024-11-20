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
import MaDictRadio from '@/components/ma-dict-picker/ma-dict-radio.vue'
import { concat } from 'lodash-es'
import { jileappCmsAdPositionTypeRadioDictData } from './common.tsx'

export default function getFormItems(formType: 'add' | 'edit' = 'add', t: any, model: any): MaFormItem[] {
  if (formType === 'add') {
    model.status_switch = true
    model.type_radio = 1
  }

  return concat([
    {
      label: t('cms.position.name'), prop: 'name_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.name') }) }, itemProps: {
        rules: [
          { required: true, message: t('form.pleaseInput', { msg: t('cms.position.name') }) },
        ],
      },
    },
    {
      label: t('cms.position.code'), prop: 'code_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.code') }), disabled: formType === 'edit' }, itemProps: {
        rules: [
          { required: true, message: t('form.pleaseInput', { msg: t('cms.position.code') }) },
          { pattern: /^[a-zA-Z_]+$/, message: t('cms.position.codeOnlyContainLetterAndUnderline') },
        ],
      },
    },
    { label: t('cms.position.description'), prop: 'description_text', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.description') }) } },
    { label: t('cms.position.type'), prop: 'type_radio', render: () => MaDictRadio, renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.type') }), data: jileappCmsAdPositionTypeRadioDictData(t) } },
    { label: t('cms.position.width'), prop: 'width_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.width') }) } },
    { label: t('cms.position.height'), prop: 'height_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.height') }) } },
    { label: t('cms.position.status'), prop: 'status_switch', render: 'switch', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.status') }) } },
  ])
}
