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
import MaUploadImage from '@/components/ma-upload-image/index.vue'
import MaUploadFile from '@/components/ma-upload-file/index.vue'
import { concat } from 'lodash-es'
import { jileappCmsAdvertisementTypeRadioDictData } from './common.tsx'

export default function getFormItems(formType: 'add' | 'edit' = 'add', t: any, model: any): MaFormItem[] {
  if (formType === 'add') {
    model.type_radio = 1
    model.status_switch = true
  }

  return concat([
    {
      label: t('cms.advertisement.title'), prop: 'title_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.title') }) }, itemProps: {
        rules: [
          { required: true, message: t('form.pleaseInput', { msg: t('cms.advertisement.title') }) },
        ],
      },
    },
    { label: t('cms.advertisement.type'), prop: 'type_radio', render: () => MaDictRadio, renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.type') }), data: jileappCmsAdvertisementTypeRadioDictData(t), modelValue: 1 } },
    { label: t('cms.advertisement.content'), prop: 'textarea', render: 'mention', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.content') }), type: 'textarea' } },
    { label: t('cms.advertisement.image'), prop: 'content_image', render: () => MaUploadImage, renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.image') }) }, multiple: false },
    { label: t('cms.advertisement.video'), prop: 'video_file', render: () => MaUploadFile, renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.video') }) }, multiple: false },
    { label: t('cms.advertisement.url'), prop: 'url_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.url') }) } },
    { label: t('cms.advertisement.startTime'), prop: 'start_time', render: 'DatePicker', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.startTime') }), valueFormat: 'YYYY-MM-DD HH:mm:ss', format: 'YYYY-MM-DD HH:mm:ss' }, mode: 'date', showTime: true },
    { label: t('cms.advertisement.endTime'), prop: 'end_time', render: 'DatePicker', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.endTime') }), valueFormat: 'YYYY-MM-DD HH:mm:ss', format: 'YYYY-MM-DD HH:mm:ss' }, mode: 'date', showTime: true },
    { label: t('cms.advertisement.status'), prop: 'status_switch', render: 'switch', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.status') }) } },
    { label: t('cms.advertisement.sort'), prop: 'sort', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.advertisement.sort') }) } },
  ]);
}
