  <template>
  <MaDialog
    v-model="dialogVisible"
    title="装载数据表"
    append-to-body
    destroy-on-close
    align-center
    :footer="false"
  >
    <div class="h-[595px]">
        <div class="mine-layout pt-3">

          <MaProTable ref="proTableRef" :options="options" :schema="schema"></MaProTable>
        </div>

      </div>
  </MaDialog>
</template>

<script setup lang="ts">
import { omit } from 'lodash-es'

defineOptions({ name: 'MineCodeGeneratorLoadTable' })

const dialogVisible = defineModel<boolean>('visible', { default: false })

// 定义 open 和 close 方法
function open() {
  dialogVisible.value = true
}

function close() {
  dialogVisible.value = false
}

defineExpose({
  open,
  close
})
</script>

<style scoped>
/* 这里是样式区域 */
</style>
