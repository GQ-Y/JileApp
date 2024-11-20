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
import { jileappCmsAdvertisementTypeRadioDictData } from './common.tsx'
import MaDictRadio from '@/components/ma-dict-picker/ma-dict-radio.vue'

export default function getSearchItems(t: any): MaSearchItem[] {
  return [
    { label: t('cms.advertisement.title'), prop: 'title_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.title') }) } },
    { label: t('cms.advertisement.type'), prop: 'type_radio', render: () => MaDictRadio, renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.type') }), data: jileappCmsAdvertisementTypeRadioDictData(t) } },
    { label: t('cms.advertisement.url'), prop: 'url_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.url') }) } },
    { label: t('cms.advertisement.startTime'), prop: 'start_time', render: 'DatePicker', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.startTime') }) }, mode: 'date', showTime: true },
    { label: t('cms.advertisement.endTime'), prop: 'end_time', render: 'DatePicker', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.endTime') }) }, mode: 'date', showTime: true },
    { label: t('cms.advertisement.sort'), prop: 'sort', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.sort') }) } },
  ]
}
