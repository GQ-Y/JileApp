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
import { jileappCmsArticleStatusDictData }  from './common.tsx'
import MaDictRadio from '@/components/ma-dict-picker/ma-dict-radio.vue'

export default function getSearchItems(t: any): MaSearchItem[] {
    return [
    { label: t('form.id'), prop: 'id', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('form.id')}) } },
    { label: t('cms.article.title'), prop: 'title_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.article.title')}) } },
    { label: t('cms.article.alias'), prop: 'slug_title', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.article.alias')}) } },
    { label: t('cms.article.categoryId'), prop: 'category_id', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.article.categoryId')}) } },
    { label: t('cms.article.status'), prop: 'status', render: () => MaDictRadio, renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.article.status')}), data: jileappCmsArticleStatusDictData(t) } },
    { label: t('cms.article.publishedAt'), prop: 'published_at', render: 'DatePicker', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.article.publishedAt')}), mode: 'date', showTime: true } },
  ]
}
