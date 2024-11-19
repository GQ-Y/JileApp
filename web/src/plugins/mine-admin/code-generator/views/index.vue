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
import { useProTableToolbar } from '@mineadmin/pro-table'
import useDialog from '@/hooks/useDialog.ts'
import getSearchItems from './data/getSearchItems.tsx'
import getTableColumns from './data/getTableColumns.tsx'
import PreviewAndGenerator from './previewAndGenerator.vue'
import PreviewCode from './previewCode.vue'

import type { Ref } from 'vue'
import type { TransType } from '@/hooks/auto-imports/useTrans.ts'
import type { UseDialogExpose } from '@/hooks/useDialog.ts'

import { getTableList } from '../api/codeApi.ts'
import { useMessage } from '@/hooks/useMessage.ts'

defineOptions({ name: 'MineCodeGenerator' })

const proTableRef = ref<MaProTableExpose>() as Ref<MaProTableExpose>
const formRef = ref()
const selections = ref<any[]>([])
const msg = useMessage()
const i18n = useTrans() as TransType
const t = i18n.globalTrans

// 隐藏搜索
useProTableToolbar().hide('mineProTableSearch')

// 参数配置
const options = ref<MaProTableOptions>({
  // 表格距离底部的像素偏移适配
  adaptionOffsetBottom: 161,
  header: {
    mainTitle: () => t('codeGenerator.cgText.mainTitle'),
    subTitle: () => t('codeGenerator.cgText.subTitle'),
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
    show: false,
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
    api: getTableList,
    responseDataHandler: (tableData: any) => tableData.filter((item: any) => item.comment !== ''),
  },
})

const dialog: UseDialogExpose = useDialog({
  title: '预览、生成代码',
  footer: false,
})

// 架构配置
const schema = ref<MaProTableSchema>({
  // 搜索项
  searchItems: getSearchItems(t),
  // 表格列
  tableColumns: getTableColumns(formRef, t, dialog),
})
</script>

<template>
  <div class="mine-layout pt-3">
    <MaProTable ref="proTableRef" :options="options" :schema="schema">
      <template #toolbarLeft>
        <el-alert type="warning" :closable="false">
          代码会生成到目录，后端请重启，前端请刷新
        </el-alert>
      </template>
    </MaProTable>

    <component :is="dialog.Dialog">
      <template #default="row, type">
        <PreviewAndGenerator v-if="type === 'previewAndGenerator'" :row="row" :dialog="dialog" />
        <PreviewCode v-if="type === 'preview'" :row="row" />
      </template>
    </component>
  </div>
</template>

<style scoped lang="scss">

</style>
