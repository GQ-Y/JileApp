/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn> And NEKGod<1559096467@qq.com>
 * @Link   https://github.com/mineadmin
 */

export function jileappCmsArticleStatusDictData(t: any) {
  return [
    { label: t('cms.article.draft'), value: 0 },
    { label: t('cms.article.published'), value: 1 },
    { label: t('cms.article.unpublished'), value: 2 },
    { label: t('cms.article.archived'), value: 3 },
  ]
}

// 写一个方法，将时间格式化成YYYY-MM-DD HH:mm:ss
export function formatPublishedAt(date: string) {
  return moment(date).format('YYYY-MM-DD HH:mm:ss')
}
