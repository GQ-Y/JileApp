/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://github.com/mineadmin
 */
import type { MaProTableColumns } from '@mineadmin/pro-table'
import type { UseDialogExpose } from '@/hooks/useDialog.ts'

export default function getTableColumns(formRef: any, t: any, dialog: UseDialogExpose): MaProTableColumns[] {
  const router = useRouter()

  return [
    // 多选列
    // { type: 'selection', showOverflowTooltip: false, label: () => t('crud.selection') },
    // 普通列
    { label: '表名称', prop: 'name', width: '300px', align: 'left' },
    { label: '表注释', prop: 'comment', align: 'left' },
    // 操作列
    {
      type: 'operation',
      width: '260px',
      align: 'right',
      label: () => t('crud.operation'),
      operationConfigure: {
        type: 'tile',
        actions: [
          {
            name: 'edit',
            icon: 'i-tabler:settings-code',
            text: () => '设置生成信息',
            onClick: async ({ row }) => {
              row.database_connection = 'default'
              await router.push({ path: `/code-generator-editor/${row.database_connection}/${row.name}` })
            },
          },
          {
            name: 'previewAndGenerator',
            icon: 'i-hugeicons:laptop-programming',
            text: () => '预览、生成代码',
            onClick: async ({ row }) => {
              row.database_connection = 'default'
              dialog.open(row, 'previewAndGenerator')
            },
          },
        ],
      },
    },
  ]
}
