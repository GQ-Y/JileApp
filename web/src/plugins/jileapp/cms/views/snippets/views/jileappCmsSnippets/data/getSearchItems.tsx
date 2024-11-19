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
export default function getSearchItems(t: any): MaSearchItem[] {
  return [
    { label: t('cms.snippets.name'), prop: 'name', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.snippets.name') }) } },
    { label: t('cms.snippets.code'), prop: 'code', render: 'input', renderProps: { placeholder: t('form.pleaseInput', { msg: t('cms.snippets.code') }) } },
  ]
}
