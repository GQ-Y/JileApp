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
import type { MaProTableExpose, MaProTableOptions, MaProTableSchema } from '@mineadmin/pro-table'
import type { Ref } from 'vue'
import type { TransType } from '@/hooks/auto-imports/useTrans.ts'

import getSearchItems from './data/getSearchItems.tsx'
import getTableColumns from './data/getTableColumns.tsx'
import { useMessage } from '@/hooks/useMessage.ts'
import LoadTable  from "../components/loadTable/index.vue"
import EditInfo from "../components/editInfo/index.vue"

import {getGenerateApi} from "../api/codeApi.ts";


defineOptions({ name: 'MineCodeGenerator' })


const proTableRef = ref<MaProTableExpose>() as Ref<MaProTableExpose>
const formRef = ref()
const selections = ref<any[]>([])
const i18n = useTrans() as TransType
const t = i18n.globalTrans
const msg = useMessage()
const loadTableRef =  ref<InstanceType<typeof LoadTable>>()
const editInfoRef = ref<InstanceType<typeof EditInfo>>()

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
  searchFormOptions: { labelWidth: '90px' },
  // 请求配置
  requestOptions: {
    api: getGenerateApi().getPageList,
  },
})
// 架构配置
const schema = ref<MaProTableSchema>({
  // 搜索项
  searchItems: getSearchItems(t),
  // 表格列
  tableColumns: getTableColumns(t, {editInfoRef: editInfoRef, proTableRef: proTableRef}),
})

const generateCode = async (ids) => {

}

</script>

<template>
  <div class="mine-layout pt-3">
    <MaProTable ref="proTableRef" :options="options" :schema="schema">
      <template #actions>
        <el-button
          type="primary"
          @click="() => {
            loadTableRef.callback(() => {
              proTableRef.refresh()
            })
            loadTableRef.open()
          }"
        >
          {{ t('载入数据表') }}
        </el-button>
      </template>

    </MaProTable>

    <LoadTable
      ref="loadTableRef"
    />
    <EditInfo
      ref="editInfoRef"
    />
  </div>
</template>

<style scoped lang="scss">

</style>
