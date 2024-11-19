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
import { VAceEditor } from 'vue3-ace-editor'
import 'ace-builds/src-noconflict/mode-json'
import 'ace-builds/src-noconflict/mode-php'
import 'ace-builds/src-noconflict/mode-vue'
import 'ace-builds/src-noconflict/mode-sql'
import 'ace-builds/src-noconflict/mode-typescript'
import 'ace-builds/src-noconflict/mode-tsx'
import 'ace-builds/src-noconflict/theme-dawn'
import 'ace-builds/src-noconflict/theme-github_dark'

import { previewCode } from '../api/codeApi'
import { useColorMode } from '@vueuse/core'

const { row } = defineProps<{ row: Record<string, any> }>()

const codeList = ref<any>()

const color = useColorMode()
const theme = computed(() => color.value === 'dark' ? 'github_dark' : 'dawn')

previewCode(row).then((response: any) => codeList.value = response.data)
</script>

<template>
  <el-tabs>
    <el-tab-pane v-for="(code, idx) in codeList" :key="idx" :label="code.filename">
      <div class="relative">
        <el-button class="absolute right-5 top-5 z-888" type="primary">
          <ma-svg-icon v-copy="code.contents" name="i-iconamoon:copy" /> 复制
        </el-button>
        <VAceEditor
          v-model:value="code.contents"
          :lang="code.filename.split('.')[1] === 'ts' ? 'typescript' : code.filename.split('.')[1]"
          :theme="theme"
          class="mt-2 h-500px text-base"
        />
      </div>
    </el-tab-pane>
  </el-tabs>
</template>

<style scoped lang="scss">

</style>
