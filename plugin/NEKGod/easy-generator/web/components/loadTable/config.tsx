/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://github.com/mineadmin
 */
import type {MaProTableColumns} from '@mineadmin/pro-table'
import {ElTag} from 'element-plus'
import {UserLoginLog} from '~/base/api/log.ts'
import {ResultCode} from '@/utils/ResultCode.ts'
import {useMessage} from '@/hooks/useMessage.ts'
import type {MaSearchItem} from "@mineadmin/search";
export function getLoadTableSearchItems(t: any): MaSearchItem[] {
  return [
    {
      label: () => t('表名'),
      prop: 'table',
      render: 'input',
      renderProps: { placeholder: t('form.pleaseInput', { msg: '表名'}) }
    },
  ]
}

export function getLoadTableColumns(t: any): MaProTableColumns[] {
  const dictStore = useDictStore()
  const msg = useMessage()
  return [
    {
      type: 'selection',
      showOverflowTooltip: false,
      label: () => t('crud.selection')
    },
    { label:'表名称', prop: 'name' },
    { label: '新名称', prop: 'new_name' },
    { label: '表注释', prop: 'comment'},
    { label: '新注释', prop: 'new_comment' },
    { label: '创建时间', prop: 'create_time' },
  ]
}
