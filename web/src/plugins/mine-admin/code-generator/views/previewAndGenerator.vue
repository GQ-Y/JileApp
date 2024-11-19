<!--
 - MineAdmin is committed to providing solutions for quickly building web applications
 - Please view the LICENSE file that was distributed with this source code,
 - For the full copyright and license information.
 - Thank you very much for using MineAdmin.
 -
 - @Author X.Mo<root@imoi.cn>
 - @Link   https://github.com/mineadmin
-->
<script setup lang="tsx">
import type { MaFormItem } from '@mineadmin/form'
import { useMessage } from '@/hooks/useMessage.ts'
import type { UseDialogExpose } from '@/hooks/useDialog.ts'
import { generator } from '../api/codeApi.ts'

const { row, dialog } = defineProps<{
  row: Record<string, any>
  dialog: UseDialogExpose
}>()

const model = ref({
  plan: null,
})

const msg = useMessage()

const loading = ref<boolean>(false)

function checkSelectPlan() {
  if (!model.value.plan) {
    msg.error('请先选择生成方案')
  }
  return model.value.plan
}

const items = ref<MaFormItem[]>([
  {
    label: () => '选择方案',
    prop: 'plan',
    render: () => <ma-remote-select />,
    renderProps: {
      url: `/admin/plugin/code-generator/table-setting/${row.database_connection}/${row.name}`,
      dataHandle: (response: any) => {
        return response.data
      },
      props: { label: 'plan_name', value: 'id' },
    },
  },
  {
    prop: 'op',
    render: () => (
      <div class="w-full flex items-center justify-center gap-x-3">
        <el-button
          plain
          type="primary"
          onClick={() => {
            if (!checkSelectPlan()) {
              return false
            }
            dialog.setTitle('预览代码')
            dialog.open({ id: model.value.plan }, 'preview')
          }}
        >
          预览代码
        </el-button>
        <el-button
          loading={loading.value}
          onClick={() => {
            if (!checkSelectPlan()) {
              return false
            }
            generator({ id: model.value.plan, type: 2 }).then(() => {
              msg.alertError('生成成功')
            }).catch(() => {
              msg.alertError('生成失败')
            })
          }}
        >
          { loading.value ? '生成中...' : '生成代码' }
        </el-button>
      </div>
    ),
    itemProps: {
      labelWidth: '0px',
    }
    ,
  },
])
</script>

<template>
  <div>
    <el-alert type="success" title="提示" :closable="false">
      代码将直接生成到目录下，并会覆盖原文件，生成后，前端可能因为热更新而自动刷新页面。目前版本暂不支持自动导入SQL，需要到后端 runtime/sql 目录下手动复制SQL导入，或通过预览代码复制SQL。
    </el-alert>
    <ma-form v-model="model" :items="items" class="mt-3" />
  </div>
</template>

<style scoped lang="scss">

</style>
