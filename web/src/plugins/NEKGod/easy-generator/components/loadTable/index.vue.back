<template>
  <MaDialog
    v-model="dialogVisible"
    title="装载数据表"
    append-to-body
    @ok="loadTable"
    destroy-on-close
    align-center
    :footer="true"
  >
    <div class="mine-layout pt-3 w-full">
      <MineCodeGeneratorLoadTableTable ref="tableRef" />
    </div>
  </MaDialog>
</template>

<script setup lang="ts">
import MineCodeGeneratorLoadTableTable from "./table.vue"
import Message from "vue-m-message";
import {getGenerateApi} from "../../api/codeApi.ts";
import {useMessage} from "@/hooks/useMessage.ts";
import {ElMessage} from "element-plus";

defineOptions({ name: 'MineCodeGeneratorLoadTable' })

const dialogVisible = ref<boolean>(false)
const tableRef =  ref<InstanceType<typeof MineCodeGeneratorLoadTableTable>>()

// 定义 open 和 close 方法
function open() {
  dialogVisible.value = true
}

function close() {
  dialogVisible.value = false
}

async function loadTable() {
  let data = <any[]>tableRef.value?.getSelected()
  if (data.length < 1) {
      Message.info('至少要选择一条数据', { zIndex: 9999 })
      return false
  }

  let names = <any[]>[]
  data.filter(item => {
      names.push( { name: item.name, comment: item.comment, sourceName: item.name } )
  })
  const response = await getGenerateApi().loadTable({ names })
  if (response.success) {
    Message.success("操作成功", { zIndex: 9999 })
  }
  callbackDone()
  close()
}

let callbackDone;

function callback(callback){
  callbackDone = callback
}

defineExpose({
  open,
  close,
  callback,
})
</script>

<style scoped>
/* 这里是样式区域 */
</style>
