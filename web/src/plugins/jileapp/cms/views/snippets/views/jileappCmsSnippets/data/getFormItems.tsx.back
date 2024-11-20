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
      label: t('cms.snippets.name'), prop: 'name', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.snippets.name') }) }, itemProps: {
        rules: [
          { required: true, message: t('form.pleaseInput', { msg: t('cms.snippets.name') }) },
        ],
      },
    },
    {
      label: t('cms.snippets.code'), prop: 'code', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.snippets.code') }), disabled: formType === 'edit' }, itemProps: {
        rules: [
          { required: true, message: t('form.pleaseInput', { msg: t('cms.snippets.code') }) },
          { pattern: /^[a-zA-Z_]+$/, message: t('cms.snippets.codeOnlyContainLetterAndUnderline') },
        ],
      },
    },
    { label: t('cms.snippets.content'), prop: 'content', render: 'mention', renderProps: { type: 'textarea', placeholder: t('form.pleaseInput', { msg: t('cms.snippets.content') }) } },
    { label: t('cms.snippets.description'), prop: 'description', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.snippets.description') }) } },
    { label: t('cms.snippets.status'), prop: 'status', render: 'switch', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.snippets.status') }) } },
  ]);
}
