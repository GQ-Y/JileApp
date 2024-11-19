<script setup lang="tsx">
import type {MaProTableExpose, MaProTableOptions, MaProTableSchema} from '@mineadmin/pro-table'
import type {Ref} from 'vue'
import type {TransType} from '@/hooks/auto-imports/useTrans.ts'
import {useMessage} from "@/hooks/useMessage.ts";
import {getLoadTableColumns, getLoadTableSearchItems} from "./config.tsx";
import {codeGeneratorTableInfo} from "../../api/codeApi.ts";

defineOptions({name: 'MineCodeGeneratorLoadTableTable'})

const proTableRef = ref()
const selections = ref<any[]>([])
const i18n = useTrans() as TransType
const t = i18n.globalTrans
const msg = useMessage()
const formRef = ref()

// 参数配置
const options = ref<MaProTableOptions>({
  // 表格距离底部的像素偏移适配
  adaptionOffsetBottom: 161,
  header: {
    mainTitle: () => "代码生成器",
    subTitle: () => "提供CRUD生成功能",
  },
  // 表格参数
  tableOptions: {
    adaption:false,
    maxHeight:500,
    on: {
      // 表格选择事件
      onSelectionChange: (selection: any[]) => selections.value = selection,
    },
  },
  // 搜索参数
  searchOptions: {
    fold: true,
    text: {
      searchBtn: () => t('crud.search'),
      resetBtn: () => t('crud.reset'),
      isFoldBtn: () => t('crud.searchFold'),
      notFoldBtn: () => t('crud.searchUnFold'),
    },
  },
  // 搜索表单参数
  searchFormOptions: {labelWidth: '90px'},
  // 请求配置
  requestOptions: {
    api: codeGeneratorTableInfo,
  },
})
// 架构配置
const schema = ref<MaProTableSchema>({
  // 搜索项
  searchItems: getLoadTableSearchItems(t),
  // 表格列
  tableColumns: getLoadTableColumns(t),
})

defineExpose({
  getSelected(): any[] {
    return selections.value
  }
})
</script>

<template>
  <MaProTable ref="proTableRef" :options="options" :schema="schema">

  </MaProTable>
</template>

<style scoped lang="scss">

</style>
