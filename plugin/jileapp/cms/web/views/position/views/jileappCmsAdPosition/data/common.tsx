/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn> And NEKGod<1559096467@qq.com>
 * @Link   https://github.com/mineadmin
 */

export function jileappCmsAdPositionTypeRadioDictData(t: any) {
  return [
    { label: t('cms.position.text'), value: 1 },
    { label: t('cms.position.link'), value: 2 },
    { label: t('cms.position.image'), value: 3 },
    { label: t('cms.position.video'), value: 4 },
    { label: t('cms.position.audio'), value: 5 },
  ]
}

export function jileappCmsAdPositionStatusDictData(t: any) {
  return [
    { label: t('cms.position.enable'), value: '1' },
    { label: t('cms.position.disable'), value: '0' },
  ]
}
