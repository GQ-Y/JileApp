<!--
 - MineAdmin is committed to providing solutions for quickly building web applications
 - Please view the LICENSE file that was distributed with this source code,
 - For the full copyright and license information.
 - Thank you very much for using MineAdmin.
 -
 - @Author X.Mo<root@imoi.cn>
 - @Link   https://github.com/mineadmin
-->
<script setup lang="ts">
import type { MaFormExpose } from '@mineadmin/form'
import { getTableInfo } from '../api/codeApi'
import { useMessage } from '@/hooks/useMessage.ts'
import { ResultCode } from '@/utils/ResultCode.ts'
import getFormItems from './data/getFormItems.tsx'
import type { UseDialogExpose } from '@/hooks/useDialog.ts'
import useDialog from '@/hooks/useDialog.ts'
import JsonEditor from './jsonEditor.vue'

defineOptions({ name: 'MineCodeGeneratorEditor' })

const msg = useMessage()
const route = useRoute()
const t = useTrans().globalTrans

const jsonEditorRef = ref()
const codeForm = ref<MaFormExpose>()
const formModel = ref<any>({})
const loading = ref<boolean>(false)

const dialog: UseDialogExpose = useDialog({
  title: '配置组件参数',
  ok: (row: any, okLoadingState: (state: boolean) => void) => {
    okLoadingState(true)
    try {
      row.form_component_config = jsonEditorRef.value?.getConfig()
      dialog.close()
      msg.success('组件参数设置成功')
    }
    catch {
      msg.error('json格式错误，或者最后一行配置加了 "," 号')
    }
    okLoadingState(false)
  },
})

onMounted(() => {
  loading.value = true
  const { pool, tableName } = route.params
  codeForm.value!.setOptions({
    labelWidth: '100px',
  })
  getTableInfo({ database_connection: pool as string, table_name: tableName as string })
    .then((res: any) => {
      if (res.code === ResultCode.SUCCESS) {
        formModel.value!.fields = res.data
        formModel.value!.database_connection = pool
        formModel.value!.table_name = tableName
        codeForm.value?.setItems(getFormItems(t, formModel, dialog))
      }
      loading.value = false
    })
    .catch((err) => {
      msg.error(err)
      loading.value = false
    })
})
</script>

<template>
  <div class="mine-card">
    <el-skeleton v-if="loading" :rows="5" animated />
    <ma-form ref="codeForm" v-model="formModel" />
    <component :is="dialog.Dialog">
      <template #default="row">
        <JsonEditor ref="jsonEditorRef" :row="row" />
      </template>
    </component>
  </div>
</template>

<style scoped lang="scss">
:deep(.mine-cell-flex-center) {
  @apply flex item-center justify-center;
}
:deep(.code-pro-table .mine-card) {
  margin: 0 !important;
  padding: 0 !important;
}
</style>
