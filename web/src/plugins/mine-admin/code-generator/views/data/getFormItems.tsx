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
import { ElButton, ElInput, ElMessage } from 'element-plus'
import type { MaProTableExpose } from '@mineadmin/pro-table'
import type { TableColumnRenderer } from '@mineadmin/table'
import componentList from './componentList.tsx'
import queryType from './queryType.ts'
import type { UseDialogExpose } from '@/hooks/useDialog.ts'
import { saveTableSetting } from '$/mine-admin/code-generator/api/codeApi.ts'

export default function getFormItems(t: any, model: any, dialog: UseDialogExpose): MaFormItem[] {
  const tableRef = ref<MaProTableExpose>()
  const selectionAllState = ref<Record<string, boolean>>({
    is_required: false,
    is_form: false,
    is_list: false,
    is_query: false,
    is_sort: false,
  })

  const cols = { xs: 24, sm: 12, md: 12, lg: 8 }

  const renderSelectionAll = (data: TableColumnRenderer, key: string, modelKey: string) => {
    const { property }: any = data.column
    return (
      <div class="flex items-center justify-center">
        <el-popover
          placement="bottom"
          width={300}
          trigger="hover"
          v-slots={{
            reference: () => (
              <div class="cursor-pointer">
                <span>{t(key)}</span>
                <ma-svg-icon name="i-ic:baseline-arrow-drop-down" size={16} />
              </div>
            ),
            default: () => (
              <div class="text-center">
                <el-checkbox
                  v-model={selectionAllState.value[modelKey]}
                  onChange={(v: boolean) => {
                    // eslint-disable-next-line dot-notation
                    const data: any[] = tableRef.value?.getTableRef()?.getElTableRef()?.['data'] ?? []
                    data.map((item: any) => item[property] = v)
                  }}
                >
                  {t('codeGenerator.cgText.selectionAll')}
                  ?
                </el-checkbox>
              </div>
            ),
          }}
        />
      </div>
    )
  }

  const filterNode = (_: string, data: Record<string, any>) => {
    return data.meta?.type === 'M'
  }

  const treeSelectRef = ref()
  const menuList = ref<any[]>([])
  const planList = ref<any[]>([])

  useHttp().get('/admin/menu/list').then((res) => {
    menuList.value = res.data
  })

  return [
    {
      render: () => <el-divider />,
      prop: 'info',
      itemProps: { labelWidth: '0px' },
      renderProps: { 'content-position': 'left', 'modelValue': undefined },
      renderSlots: {
        default: () => (
          <div class="flex items-center gap-x-1.5">
            <div>生成信息</div>
            {h(
              ElInput,
              {
                'modelValue': model.value.plan_name,
                'onUpdate:modelValue': v => model.value.plan_name = v,
                'class': 'w-200px',
                'placeholder': '请输入方案名称',
              },
            )}
            {h(
              ElButton,
              {
                type: 'primary',
                onClick: () => {
                  if (!model.value?.plan_name) {
                    ElMessage.warning('请先填写方案名称')
                    return
                  }
                  saveTableSetting(model.value).then(async () => {
                    if (model.value?.id) {
                      ElMessage.success('方案更新成功')
                    }
                    else {
                      ElMessage.success('方案新增成功')
                    }
                    await useTabStore().refreshTab()
                  }).catch((err) => {
                    ElMessage.error(err.message)
                  })
                },
              },
              { default: () => '保存配置信息' },
            )}
          </div>
        ),
      },
    },
    {
      label: () => '生成方案',
      prop: 'list',
      cols,
      render: () => <ma-remote-select />,
      renderProps: {
        url: `/admin/plugin/code-generator/table-setting/${model.value.database_connection}/${model.value.table_name}`,
        dataHandle: (response: any) => {
          planList.value = response.data
          return response.data
        },
        props: { label: 'plan_name', value: 'id' },
        onChange: (id: number) => {
          if (id) {
            const plan = planList.value.find(item => item.id === id)
            Object.keys(plan).map((key: string) => {
              model.value[key] = plan[key]
            })
            tableRef.value?.changeApi(() => new Promise((resolve) => {
              resolve({ data: { list: model.value.fields } })
            }), true)
          }
        },
        onClear: () => model.value!.id = null,
      },
    },
    {
      label: () => '表名称',
      prop: 'table_name',
      cols,
      render: 'input',
      renderProps: {
        readonly: true,
      },
    },
    {
      label: () => '备注信息',
      prop: 'remark',
      cols,
      render: 'input',
      renderProps: {
        placeholder: '请输入备注信息',
      },
    },
    {
      label: () => '所属菜单',
      prop: 'menu_parent_id',
      cols,
      render: () => {
        return (
          <el-tree-select
            ref={treeSelectRef}
            data={menuList.value}
            props={{ value: 'id', label: 'title' }}
            check-strictly={true}
            default-expand-all={true}
            clearable={true}
            filter-node-method={filterNode}
          >
            {{
              default: ({ node }) => {
                const { meta } = node.data
                node.data.title = meta?.i18n ? useTrans(meta.i18n) : meta?.title ?? 'unknown'
              },
            }}
          </el-tree-select>
        )
      },
      renderProps: {
        placeholder: '请选择所属菜单，不选为顶级',
      },
    },
    {
      label: () => '菜单名称',
      prop: 'menu_name',
      cols,
      render: 'input',
      renderProps: {
        placeholder: '请输入菜单名称',
      },
      itemProps: {
        rules: [{ required: true, message: '请输入菜单名称' }],
      },
    },
    {
      label: () => '包名',
      prop: 'package_name',
      cols,
      render: 'input',
      renderProps: {
        placeholder: '请输入包名',
      },
      itemProps: {
        rules: [{ required: true, message: '请输入包名' }],
      },
    },
    {
      render: () => <el-divider />,
      prop: 'config',
      renderProps: { 'content-position': 'left' },
      itemProps: { labelWidth: '0px' },
      renderSlots: { default: () => '字段配置' },
    },
    {
      prop: 'fields',
      render: () => <ma-pro-table class="-mt-[10px]" />,
      itemProps: { labelWidth: '0px' },
      renderProps: {
        class: 'code-pro-table w-full',
        ref: (el: MaProTableExpose) => tableRef.value = el,
        modelValue: undefined,
        options: {
          header: { show: false },
          toolbar: false,
          tableOptions: { height: 420, adaption: false },
          searchOptions: { show: false },
          requestOptions: {
            api: () => new Promise((resolve) => {
              model.value.fields?.map((item: any, idx: number) => {
                model.value.fields[idx] = {
                  ...item,
                  is_required: false,
                  is_form: false,
                  is_list: false,
                  is_query: false,
                  is_sort: false,
                  query_type: 'eq',
                  permission: null,
                  form_component: '<el-input />',
                  form_component_name: 'input',
                  form_component_config: null,
                }
              })
              resolve({ data: { list: model.value.fields } })
            }),
          },
        },
        schema: {
          tableColumns: [
            {
              type: 'sort',
              label: () => t('codeGenerator.cols.sort'),
              width: '80px',
              className: 'pt-2',
            },
            {
              label: () => t('codeGenerator.cols.name'),
              prop: 'name',
              width: '130px',
            },
            {
              label: () => t('codeGenerator.cols.type'),
              prop: 'type',
              width: '120px',
            },
            {
              label: () => t('codeGenerator.cols.comment'),
              prop: 'comment',
              width: '220px',
              cellRender: ({ row }) => <el-input v-model={row.comment} clearable />,
            },
            {
              prop: 'is_required',
              width: '100px',
              cellRender: ({ row }) => <el-checkbox v-model={row.is_required} />,
              headerRender: (data: TableColumnRenderer) => renderSelectionAll(data, 'codeGenerator.cols.required', 'is_required'),
            },
            {
              label: '表单',
              prop: 'is_form',
              width: '80px',
              cellRender: ({ row }) => <el-checkbox v-model={row.is_form} />,
              headerRender: (data: TableColumnRenderer) => renderSelectionAll(data, 'codeGenerator.cols.form', 'is_form'),
            },
            {
              label: '列表',
              prop: 'is_list',
              width: '80px',
              cellRender: ({ row }) => <el-checkbox v-model={row.is_list} />,
              headerRender: (data: TableColumnRenderer) => renderSelectionAll(data, 'codeGenerator.cols.list', 'is_list'),
            },
            {
              label: '查询',
              prop: 'is_query',
              width: '80px',
              cellRender: ({ row }) => <el-checkbox v-model={row.is_query} />,
              headerRender: (data: TableColumnRenderer) => renderSelectionAll(data, 'codeGenerator.cols.query', 'is_query'),
            },
            {
              label: '排序',
              prop: 'is_sort',
              width: '80px',
              cellRender: ({ row }) => <el-checkbox v-model={row.is_sort} />,
              headerRender: (data: TableColumnRenderer) => renderSelectionAll(data, 'codeGenerator.cols.sort', 'is_sort'),
            },
            {
              label: () => t('codeGenerator.cols.queryType'),
              prop: 'query_type',
              width: '150px',
              cellRender: ({ row }) => (
                <div class="flex items-center gap-x-3">
                  <el-select v-model={row.query_type} clearable>
                    {queryType.map((item: any) => (
                      <el-option label={item.label} value={item.value} />
                    ))}
                  </el-select>
                </div>
              ),
            },
            {
              label: () => t('codeGenerator.cols.component'),
              prop: 'form_component_name',
              cellRender: ({ row }) => (
                <div class="flex items-center gap-x-2">
                  <el-select
                    v-model={row.form_component_name}
                    clearable
                    onChange={(name: string) => {
                      row.form_component = componentList.find((item: any) => item.labelValue === name)!.component
                    }}
                  >
                    {componentList.map((cmp: any) => (
                      <el-option label={t(`codeGenerator.component.${cmp.labelValue}`)} value={cmp.labelValue} />
                    ))}
                  </el-select>
                  <el-link
                    type="primary"
                    underline={false}
                    onClick={() => {
                      if (!row.form_component) {
                        ElMessage.error('请先选择组件')
                        return
                      }
                      dialog.open(row)
                    }}
                  >
                    { t('codeGenerator.op.settingComponent') }
                  </el-link>
                </div>
              ),
            },
            // {
            //   type: 'operation',
            //   width: '160px',
            //   align: 'center',
            //   label: () => t('codeGenerator.cols.permission'),
            //   operationConfigure: {
            //     actions: [
            //       {
            //         name: 'formPermission',
            //         icon: 'i-icon-park-outline:form-one',
            //         text: () => t('codeGenerator.op.formPermission'),
            //         onClick: ({ row }) => {
            //         },
            //       },
            //       {
            //         name: 'columnPermission',
            //         icon: 'i-fe:columns',
            //         text: () => t('codeGenerator.op.columnPermission'),
            //         onClick: ({ row }) => {
            //         },
            //       },
            //     ],
            //   },
            // },
          ],
        },
      },
    },
  ]
}
