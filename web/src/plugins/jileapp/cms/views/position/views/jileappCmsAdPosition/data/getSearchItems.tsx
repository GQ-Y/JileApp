/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://github.com/mineadmin
 */

import type { MaSearchItem } from '@mineadmin/search'
import { jileappCmsAdPositionTypeRadioDictData } from './common.tsx'
import MaDictRadio from '@/components/ma-dict-picker/ma-dict-radio.vue'

export default function getSearchItems(t: any): MaSearchItem[] {
  return [
    { label: t('cms.position.name'), prop: 'name_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.name') }) } },
    { label: t('cms.position.code'), prop: 'code_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.code') }) } },
    { label: t('cms.position.description'), prop: 'description_text', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.description') }) } },
    { label: t('cms.position.type'), prop: 'type_radio', render: () => MaDictRadio, renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.position.type') }), data: jileappCmsAdPositionTypeRadioDictData(t) } },
  ]
}
