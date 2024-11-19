<script setup lang="ts">
import { VAceEditor } from 'vue3-ace-editor'
import 'ace-builds/src-noconflict/mode-json'
import 'ace-builds/src-noconflict/theme-dawn'
import 'ace-builds/src-noconflict/theme-github_dark'
import componentList from './data/componentList.tsx'
import formatJson from '../utils/formatJson.ts'
import { useColorMode } from '@vueuse/core'

const { row } = defineProps<{
  row: Record<string, any>
}>()

const t = useTrans().globalTrans

const color = useColorMode()
const theme = computed(() => color.value === 'dark' ? 'github_dark' : 'dawn')
const cmp = computed(() => {
  return componentList.find((item: any) => item.labelValue === row.form_component_name) ?? {}
})

const content = ref(formatJson(row.form_component_config ?? cmp.value!.renderProps ?? {
  placeholder: `请输入${row!.comment}`,
}))

const getConfig = () => JSON.parse(content.value)

defineExpose({ getConfig })
</script>

<template>
  <div>
    <div class="flex items-center">
      当前选择的组件：
      <span class="text-[rgb(var(--ui-primary))]">{{ t(`codeGenerator.component.${row.form_component_name}`) }}</span>，
      <el-link v-if="cmp!.docUrl" type="danger" :underline="false" target="_blank" class="ml-0.5" :href="cmp!.docUrl">
        查看该组件 Element-plus 官方文档属性！
      </el-link>
      <span v-if="cmp!.docUrl">复制属性粘贴到下面的 JSON 编辑器即可。</span>
      <span v-else>该组件为 MineAdmin 封装，暂没有文档。</span>
    </div>
    <div v-if="cmp!.renderProps" class="mt-2">
      此组件 MineAdmin 基于 Element plus 封装，以下 props 为组件特有属性，剩下可参考组件库文档
    </div>
    <VAceEditor
      v-model:value="content"
      lang="json"
      :theme="theme"
      class="mt-2 h-500px text-base"
    />
  </div>
</template>

<style scoped lang="scss">

</style>
