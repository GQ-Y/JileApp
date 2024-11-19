<template>
  <MaDialog
    v-model="visible"
    title="编辑生成信息"
    append-to-body
    @ok="save"
    destroy-on-close
    align-center
    :footer="true"
  >
    <el-form :model="form">
      <!-- 数字输入框 / 滑块 -->
      <div v-if="row.view_type == 'inputNumber' || row.view_type == 'slider'">
        <el-form-item label="最小值" prop="min" label-width="80px">
          <el-input-number v-model="form.min"/>
        </el-form-item>
        <el-form-item label="最大值" prop="max" label-width="80px">
          <el-input-number v-model="form.max"/>
        </el-form-item>
        <el-form-item label="步长" prop="step" label-width="80px">
          <el-input-number v-model="form.step" :min="0" />
        </el-form-item>
        <el-form-item label="精度" prop="precision" label-width="80px" v-if="row.view_type != 'slider'">
          <el-input-number v-model="form.precision" :min="0"  />
        </el-form-item>
        <el-form-item label="刻度线" prop="showTicks" label-width="80px" v-if="row.view_type != 'inputNumber'">
          <el-radio-group v-model="form.showTicks">
            <el-radio :value="true">显示</el-radio>
            <el-radio :value="false">不显示</el-radio>
          </el-radio-group>
        </el-form-item>
      </div>
      <!-- 开关 -->
      <div v-if="row.view_type == 'switch'">
        <el-form-item label="选中时的值" prop="checkedValue" label-width="120px">
          <el-input v-model="form.checkedValue"/>
        </el-form-item>
        <el-form-item label="未选中时的值" prop="uncheckedValue" label-width="120px">
          <el-input v-model="form.uncheckedValue"/>
        </el-form-item>
      </div>
      <!-- 下拉、复选、单选 -->
      <div v-if="['select', 'checkbox', 'radio', 'transfer'].includes(row.view_type)">
        <el-form-item label="是否多选" prop="multiple" label-width="80px" v-if="row.view_type == 'select'">
          <el-radio-group v-model="form.multiple">
            <el-radio :value="true">是</el-radio>
            <el-radio :value="false">否</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-divider>设置数据 <el-link class="ml-2" @click="add"><i class="el-icon-plus" /> 添加</el-link></el-divider>
        <el-card v-for="(item, idx) in form.collection" :key="idx" class="mt-2 relative">
          <el-row justify="end" class="mt-2 mb-2">
            <el-link type="danger" @click="del(idx)" class="setdata-button" icon="el-icon-delete">删除</el-link>
          </el-row>
          <el-form-item label="label" prop="label" label-width="80px">
            <el-input v-model="item.label" />
          </el-form-item>
          <el-form-item label="value" prop="value" label-width="80px">
            <el-input v-model="item.value" />
          </el-form-item>
        </el-card>
      </div>
      <!-- 树形下拉框、级联选择器 -->
      <div v-if="['treeSelect', 'cascader'].includes(row.view_type)">
        该组件涉及多层数据嵌套，请看 <el-tag type="primary">Arco Design</el-tag> 官方文档
        <el-link class="mt-2" :href="'https://arco.design/vue/docs/start'" target="_blank">https://arco.design/vue/docs/start</el-link>
      </div>
      <!-- 编辑器相关 -->
      <div v-if="['codeEditor', 'editor','wangEditor'].includes(row.view_type)">
        <el-form-item label="编辑器高度" prop="height" label-width="120px">
          <el-input-number v-model="form.height" :max="1000" :min="100"/>
        </el-form-item>
        <el-form-item label="双向绑定数据" prop="isBind" label-width="120px" v-if="row.view_type == 'codeEditor'">
          <el-radio-group v-model="form.isBind">
            <el-radio :value="true">是</el-radio>
            <el-radio :value="false">否</el-radio>
          </el-radio-group>
        </el-form-item>
      </div>
      <!-- 上传、资源选择器相关 -->
      <div v-if="['upload', 'selectResource'].includes(row.view_type)">
        <el-form-item label="返回数据" prop="onlyData" label-width="120px">
          <el-radio-group v-model="form.onlyData">
            <el-radio :value="true">单个字段数据</el-radio>
            <el-radio :value="false">全量数据</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="返回数据" prop="returnType" label-width="120px" v-if="form.onlyData" :extra="'支持 uploadfile 数据表所有字段，这里仅列常用部分'">
          <el-select v-model="form.returnType" placeholder="请选择上传返回数据类型">
            <el-option value="url">附件URL</el-option>
            <el-option value="id">附件ID</el-option>
            <el-option value="hash">附件HASH</el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="是否可多选" prop="multiple" label-width="120px">
          <el-radio-group v-model="form.multiple">
            <el-radio :value="true">是</el-radio>
            <el-radio :value="false">否</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="是否分片上传" prop="chunk" label-width="120px" extra="分片上传不限制文件类型，选择分片上传后，上传文件类型则失效" v-if="row.view_type == 'upload'">
          <el-radio-group v-model="form.chunk">
            <el-radio :value="true">是</el-radio>
            <el-radio :value="false">否</el-radio>
          </el-radio-group>
        </el-form-item>
        <el-form-item label="上传类型" prop="type" label-width="100px" v-if="row.view_type == 'upload' && !form.chunk" :extra="'可在 系统配置 -> 上传配置 里修改允许格式'">
          <el-select v-model="form.type" placeholder="默认为图片类型">
            <el-option value="image">图片格式类型</el-option>
            <el-option value="file">非图片格式类型</el-option>
          </el-select>
        </el-form-item>
      </div>
      <!-- 用户选择器 -->
      <div v-if="row.view_type == 'selectUser'">
        <el-form-item label="返回数据" prop="onlyId" label-width="100px">
          <el-radio-group v-model="form.onlyId">
            <el-radio :value="true">仅用户ID</el-radio>
            <el-radio :value="false">全量数据</el-radio>
          </el-radio-group>
        </el-form-item>
      </div>
      <!-- 省市区联动 -->
      <div v-if="row.view_type == 'cityLinkage'">
        <el-alert title="提示" type="info">
          <p>级联选择器返回的数据类型为 String</p>
          <p>下拉框联动返回的数据类型为 Array</p>
        </el-alert>
        <el-form-item class="mt-3" label="组件类型" prop="type" label-width="100px">
          <el-select v-model="form.mode" placeholder="默认为下拉框联动" allow-clear>
            <el-option value="select">下拉框联动</el-option>
            <el-option value="cascader">级联选择器</el-option>
          </el-select>
        </el-form-item>
        <el-form-item class="mt-3" label="返回数据" prop="mode" label-width="100px">
          <el-select v-model="form.mode" placeholder="默认为省市名称" allow-clear>
            <el-option value="name">省市名称</el-option>
            <el-option value="code">省市编码</el-option>
          </el-select>
        </el-form-item>
      </div>
      <!-- 日期、时间选择器 -->
      <div v-if="['time', 'date'].includes(row.view_type)">
        <el-form-item class="mt-3" label="选择器类型" prop="formType" label-width="120px" v-if="row.view_type == 'date'">
          <el-select v-model="form.mode" allow-clear>
            <el-option value="date">日期选择器</el-option>
            <el-option value="week">周选择器</el-option>
            <el-option value="month">月份选择器</el-option>
          </el-select>
        </el-form-item>
        <el-form-item label="格式" prop="format" label-width="120px">
          <el-input v-model="form.format" />
        </el-form-item>
        <el-form-item label="是否禁用" prop="disabled" label-width="120px">
          <el-radio-group v-model="form.disabled">
            <el-radio :value="true">禁用</el-radio>
            <el-radio :value="false">启用</el-radio>
          </el-radio-group>
        </el-form-item>
      </div>
    </el-form>
  </MaDialog>
</template>

<script setup>
import { ref } from 'vue'

const emit = defineEmits(['confrim'])
const visible = ref(false)
const row = ref({})
const form = ref({
  collection: []
})

const open = (record) => {
  row.value = record
  form.value = record.options ? record.options : { collection: [] }
  visible.value = true
}

const add = () => {
  form.value.collection.push({ label: '', value: ''})
}
const del = (idx) => {
  form.value.collection.splice(idx, 1)
}

const save = () => {
  emit('confrim', row.value.column_name, form.value)
  visible.value = false
}

defineExpose({ open })
</script>

<style>

</style>
