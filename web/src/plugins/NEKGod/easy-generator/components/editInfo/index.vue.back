<template>
  <MaDialog
    :fullscreen="true"
    v-model="dialogVisible"
    title="编辑生成信息"
    append-to-body
    @ok="save"
    destroy-on-close
    align-center
    :footer="true"
  >
    <div class="mine-layout pt-3 w-full">
      <el-tabs v-model="activeTab">
        <el-tab-pane label="配置信息" name="base_config">

          <el-divider>基础信息</el-divider>

          <el-row :gutter="24">
            <el-col :span="24" :md="12" :xl="12">
              <el-form-item label="表名称" prop="table_name" label-width="100px">
                <el-input v-model="form.table_name" disabled />
              </el-form-item>
            </el-col>
            <el-col :span="24" :md="12" :xl="12">
              <el-form-item
                label="表描述"
                prop="table_comment"
                label-width="100px"
                :rules="[{ required: true, message: '表描述必填' }]"
              >
                <el-input v-model="form.table_comment" />
              </el-form-item>
            </el-col>
            <el-col :span="24" :md="24" :xl="24">
              <el-form-item label="备注信息" prop="remark" label-width="94px">
                <el-input type="textarea" v-model="form.remark" />
              </el-form-item>
            </el-col>
          </el-row>

          <el-divider>生成信息</el-divider>

          <el-row :gutter="24">
            <el-col :span="24" :md="12" :xl="12">
              <el-form-item
                label="所属菜单"
                :rules="[{ required: true, message: '菜单必选' }]"
                prop="belong_menu_id"
                label-width="100px"
                extra="分配业务功能在哪个菜单，例如：权限管理。不选择则为顶级菜单"
              >

                <el-tree-select
                  v-model="form.belong_menu_id"
                  :data="menus"
                  check-strictly
                  :render-after-expand="false"
                >
                  <template #default="{ data }">
                    {{ data.meta.title }}
                  </template>
                </el-tree-select>
<!--                <el-cascader-->
<!--                  v-model="form.belong_menu_id"-->
<!--                  :options="menus"-->
<!--                  expand-trigger="hover"-->
<!--                  style="width: 100%"-->
<!--                  placeholder="生成功能所属菜单"-->
<!--                  allow-search-->
<!--                  allow-clear-->
<!--                  check-strictly-->
<!--                />-->
              </el-form-item>
            </el-col>
            <el-col :span="24" :md="12" :xl="12">
              <el-form-item
                label="菜单名称"
                prop="menu_name"
                label-width="100px"
                :rules="[{ required: true, message: '菜单名称必选' }]"
                extra="显示在左侧菜单上的名称、以及代码中的业务名称"
              >
                <el-input v-model="form.menu_name"

                          placeholder="请输入菜单名称" allow-clear />
              </el-form-item>
            </el-col>
          </el-row>

          <el-row :gutter="24">
            <el-col :span="24" :md="12" :xl="12">
              <el-form-item
                label="包名"
                prop="package_name"
                label-width="100px"
                :rules="[{ required: true, message: '包名必输入' }]"
                extra="指定控制器文件所在控制器目录的二级目录名，如：Premission"
              >
                <el-input v-model="form.package_name" placeholder="请输入包名" allow-clear />
              </el-form-item>
            </el-col>
            <el-col :span="24" :md="12" :xl="12">
              <el-form-item
                label="生成方式"
                prop="generate_type"
                label-width="100px"
                :rules="[{ required: true, message: '菜单名称必选' }]"
                extra="如选择生成到目录，只会对后端文件进行到目录生成（覆盖形式），前端文件和菜单SQL还以压缩包方式下载"
              >
                <el-radio-group v-model="form.generate_type" type="button">
                  <el-radio :value="1">压缩包下载</el-radio>
<!--                  <el-radio :value="2">生成到目录</el-radio>-->
                </el-radio-group>
              </el-form-item>
            </el-col>
          </el-row>

          <el-row :gutter="24">
            <el-col :span="24" :md="12" :xl="12">
              <el-form-item
                label="组件样式"
                prop="component_type"
                label-width="100px"
                extra="设置新增和修改组件显示方式，Tag页表示新打开的一个标签来显示新增和编辑"
              >
                <el-radio-group v-model="form.component_type" type="button">
                  <el-radio :value="1">模态框</el-radio>
<!--                  <el-radio :value="2">抽屉</el-radio>-->
<!--                  <el-radio :value="3">Tag页</el-radio>-->
                </el-radio-group>
              </el-form-item>
            </el-col>
<!--            <el-col :span="24" :md="12" :xl="12">-->
<!--              <el-form-item-->
<!--                label="构建菜单"-->
<!--                prop="build_menu"-->
<!--                label-width="100px"-->
<!--                :rules="[{ required: true, message: '菜单名称必选' }]"-->
<!--                extra="如选择构建菜单，在每次生成代码都会进行生成菜单操作。"-->
<!--              >-->
<!--                <el-radio-group v-model="form.build_menu" type="button">-->
<!--                  <el-radio :value="1">不构建菜单</el-radio>-->
<!--                  <el-radio :value="2">构建菜单</el-radio>-->
<!--                </el-radio-group>-->
<!--              </el-form-item>-->
<!--            </el-col>-->
          </el-row>

          <div v-if="form.type === 'tree'">
            <el-divider>树表配置</el-divider>
            <el-row :gutter="24">
              <el-col :span="24" :md="8" :xl="8">
                <el-form-item
                  label="树主ID"
                  prop="tree_id"
                  label-width="100px"
                  extra="指定树表的主要ID，一般为主键"
                >
                  <el-select
                    v-model="formOptions.tree_id"
                    placeholder="请选择树表的主ID"
                    allow-clear
                    allow-search
                    style="width: 100%"
                  >
                    <el-option
                      v-for="(item, index) in form.columns"
                      :key="index"
                      :label="item.column_name + ' - ' + item.column_comment"
                      :value="item.column_name"
                    >
                      <div class="flex justify-between">
                        <span>{{ item.column_name }}</span>
                        <span>{{ item.column_comment }}</span>
                      </div>
                    </el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="8" :xl="8">
                <el-form-item
                  label="树父ID"
                  prop="tree_parent_id"
                  label-width="100px"
                  extra="指定树表的父ID，比如：parent_id"
                >
                  <el-select
                    v-model="formOptions.tree_parent_id"
                    placeholder="请选择树表的父ID"
                    allow-clear
                    allow-search
                    style="width: 100%"
                  >
                    <el-option
                      v-for="(item, index) in form.columns"
                      :key="index"
                      :label="item.column_name + ' - ' + item.column_comment"
                      :value="item.column_name"
                    >
                      <div class="flex justify-between">
                        <span>{{ item.column_name }}</span>
                        <span>{{ item.column_comment }}</span>
                      </div>
                    </el-option>
                  </el-select>
                </el-form-item>
              </el-col>
              <el-col :span="24" :md="8" :xl="8">
                <el-form-item
                  label="树名称"
                  prop="tree_name"
                  label-width="100px"
                  extra="指定树表的名称，如：name"
                >
                  <el-select
                    v-model="formOptions.tree_name"
                    placeholder="请选择树表的名称"
                    allow-clear
                    allow-search
                    style="width: 100%"
                  >
                    <el-option
                      v-for="(item, index) in form.columns"
                      :key="index"
                      :label="item.column_name + ' - ' + item.column_comment"
                      :value="item.column_name"
                    >
                      <div class="flex justify-between">
                        <span>{{ item.column_name }}</span>
                        <span>{{ item.column_comment }}</span>
                      </div>
                    </el-option>
                  </el-select>
                </el-form-item>
              </el-col>
            </el-row>
          </div>

        </el-tab-pane>

        <el-tab-pane label="字段配置" name="field_config">
          <el-alert title="提示" type="info">
            使用数组形式字段的组件，请在模型的
            <el-tag type="primary">casts</el-tag>
            设置相应字段为 <el-tag type="primary">array</el-tag> 类型
            <p>数据字典在页面控件为下拉框、单选框、复选框和数据穿梭框才可选择</p>
          </el-alert>
          <el-table :data="form.columns" :pagination="false" class="mt-3" border>
<!--            <el-table-column label="排序" width="200" >-->
<!--              <template #default="scope">-->
<!--                <el-input-number v-model="scope.row.sort" />-->
<!--              </template>-->
<!--            </el-table-column>-->
            <el-table-column label="字段名称" width="150"  show-overflow-tooltip  prop="column_name"></el-table-column>
            <el-table-column label="字段描述" width="180">
              <template #default="scope">
                <el-input v-model="scope.row.column_comment" clearable />
              </template>
            </el-table-column>
            <el-table-column label="物理类型" width="120" prop="column_type"></el-table-column>
            <el-table-column label="必填" width="80">
              <template #header>
                <span>必填</span>
                <el-tooltip content="全选 / 全不选" placement="bottom">
                  <el-checkbox @change="handlerAll($event, 'required')" />
                </el-tooltip>
              </template>
              <template #default="scope">
                <el-checkbox v-model="scope.row.is_required" />
              </template>
            </el-table-column>
            <el-table-column label="插入" width="80">
              <template #header>
                <span>插入</span>
                <el-tooltip content="全选 / 全不选" placement="bottom">
                  <el-checkbox @change="handlerAll($event, 'insert')" />
                </el-tooltip>
              </template>
              <template #default="scope">
                <el-checkbox v-model="scope.row.is_insert" />
              </template>
            </el-table-column>
            <el-table-column label="编辑" width="80">
              <template #header>
                <span>编辑</span>
                <el-tooltip content="全选 / 全不选" placement="bottom">
                  <el-checkbox @change="handlerAll($event, 'edit')" />
                </el-tooltip>
              </template>
              <template #default="scope">
                <el-checkbox v-model="scope.row.is_edit" />
              </template>
            </el-table-column>
            <el-table-column label="列表" width="80">
              <template #header>
                <span>列表</span>
                <el-tooltip content="全选 / 全不选" placement="bottom">
                  <el-checkbox @change="handlerAll($event, 'list')" />
                </el-tooltip>
              </template>
              <template #default="scope">
                <el-checkbox v-model="scope.row.is_list" />
              </template>
            </el-table-column>
            <el-table-column label="查询" width="80">
              <template #header>
                <span>查询</span>
                <el-tooltip content="全选 / 全不选" placement="bottom">
                  <el-checkbox @change="handlerAll($event, 'query')" />
                </el-tooltip>
              </template>
              <template #default="scope">
                <el-checkbox v-model="scope.row.is_query" />
              </template>
            </el-table-column>
            <el-table-column label="排序" width="80">
              <template #header>
                <span>排序</span>
                <el-tooltip content="全选 / 全不选" placement="bottom">
                  <el-checkbox @change="handlerAll($event, 'sort')" />
                </el-tooltip>
              </template>
              <template #default="scope">
                <el-checkbox v-model="scope.row.is_sort" />
              </template>
            </el-table-column>
            <el-table-column label="查询方式" width="180">
              <template #default="scope">
                <el-select v-model="scope.row.query_type" :options="vars.queryType" clearable >
                  <el-option
                    v-for="item in vars.queryType"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                  />
                </el-select>
              </template>
            </el-table-column>
            <el-table-column label="搜索框控件" width="240">
              <template #default="scope">
                <el-space>
                  <el-select v-model="scope.row.view_type" style="width: 160px;" :options="vars.viewComponent" clearable >
                    <el-option
                      v-for="item in vars.viewComponent"
                      :key="item.value"
                      :label="item.label"
                      :value="item.value"
                    />
                  </el-select>
                </el-space>
              </template>
            </el-table-column>
            <el-table-column label="表单控件" width="240">
              <template #default="scope">
                <el-space>
                  <el-select v-model="scope.row.view_type" style="width: 160px;" :options="vars.viewComponent" clearable >
                    <el-option
                      v-for="item in vars.viewComponent"
                      :key="item.value"
                      :label="item.label"
                      :value="item.value"
                    />
                  </el-select>
                  <el-link
                    v-if="notNeedSettingComponents.includes(scope.row.view_type)"
                    @click="settingComponentRef.open(scope.row)"
                  >设置</el-link>
                </el-space>
              </template>
            </el-table-column>
<!--            <el-table-column label="数据字典" width="180">-->
<!--              <template #default="scope">-->
<!--                <el-select-->
<!--                  v-model="scope.row.dict_type"-->
<!--                  :options="dicts"-->
<!--                  clearable-->
<!--                  :field-names="{ label: 'name', value: 'code' }"-->
<!--                  placeholder="选择数据字典"-->
<!--                  :disabled="!['select', 'radio', 'checkbox', 'transfer'].includes(record.view_type)"-->
<!--                />-->
<!--              </template>-->
<!--            </el-table-column>-->
<!--            <el-table-column label="允许角色" width="200">-->
<!--              <template #default="scope">-->
<!--                <el-select-->
<!--                  v-model="scope.row.allow_roles"-->
<!--                  multiple-->
<!--                  :options="roles"-->
<!--                  :max-tag-count="1"-->
<!--                  clearable-->
<!--                  :field-names="{ label: 'name', value: 'code' }"-->
<!--                  placeholder="选择允许查看字段的角色"-->
<!--                />-->
<!--              </template>-->
<!--            </el-table-column>-->
          </el-table>
        </el-tab-pane>
        <el-tab-pane label="菜单配置" name="menu_config">
          <el-alert title="提示" type="warning" show-icon>未选择的菜单，后端也对应不生成方法。注意：列表按钮菜单是默认的</el-alert>

          <el-checkbox-group v-model="form.generate_menus" class="mt-3">
            <el-row v-for="(menu, index) in vars.menuList" >
              <el-checkbox :label="menu.value" :key="index">
                {{ menu.name + '　-　' + menu.comment }}
              </el-checkbox>
            </el-row>
          </el-checkbox-group>
        </el-tab-pane>
      </el-tabs>
    </div>
    <SettingComponent
      ref="settingComponentRef" @confrim="confrimSetting"
    />
  </MaDialog>
</template>

<script setup>
import {getGenerateApi} from "../../api/codeApi.ts";

import SettingComponent from '../settingComponent/index.vue'
import * as vars from './config.ts'
import {page} from "~/base/api/menu.ts";
import {useMessage} from "@/hooks/useMessage.ts";
import Message from "vue-m-message";
// import type {MenuVo} from "~/base/api/menu.js";
console.log(vars)
defineOptions({ name: 'MineCodeGeneratorLoadTable' })

const settingComponentRef = ref()
const activeTab = ref('base_config')
const notNeedSettingComponents = ref([
  'select', 'radio', 'checkbox',
])
const form = ref({
  generate_menus: ['save', 'update' , 'read', 'delete' , 'recycle', 'changeStatus', 'numberOperation', 'import', 'export'],
  columns: [],
  belong_menu_id: [],
})
// form扩展组
const formOptions = ref({
  relations: []
})
// 菜单列表
const menus = ref([])
// 角色列表
const roles = ref([])
// 字典列表
const dicts = ref([])
// 模型列表
const models = ref([])
// 表列表
const tables = ref([])
// 模块信息
const modules = ref([])
const record = ref({})

function addPathToNodes(nodes, path = '', label = '') {
  nodes.forEach(node => {
    // 当前节点的 value 为路径
    node.value = node.id;
    node.label = path ? `${label}-${node.meta.title}` : `${node.meta.title}`;
    // 如果有子节点，递归处理
    if (node.children && node.children.length > 0) {
      addPathToNodes(node.children, node.value, node.label);  // 递归时传递当前路径
    }
  });
}

async function getMenu() {
  const { data } = await page()
  addPathToNodes(data)
  menus.value = data
}

const handlerAll = (value, type) => {
  form.value.columns.map(item => { item['is_' + type] = value })
}

const init = () => {
  // 设置form数据
  for (let name in record.value) {
    if (name === 'generate_menus') {
      form.value[name] = record.value[name] ? record.value[name].split(',') :  ['save', 'update' , 'delete']
    } else {
      form.value[name] = record.value[name]
    }
  }

  if (record.value.options && record.value.options.relations) {
    formOptions.value.relations = record.value.options.relations
  } else {
    formOptions.value.relations = []
  }

  if (record.value.component_type === 3) {
    formOptions.value.tag_id = record.value?.options?.tag_id ?? undefined
    formOptions.value.tag_name = record.value?.options?.tag_name ?? undefined
    formOptions.value.tag_view_name = record.value?.options?.tag_view_name ?? undefined
  }

  // 请求表字段
  getGenerateApi().getTableColumns({ table_id: record.value.id }).then( res => {
    form.value.columns = []
    res.data.map(item => {
      item.is_required = item.is_required === 2
      item.is_insert = item.is_insert === 2
      item.is_edit = item.is_edit === 2
      item.is_list = item.is_list === 2
      item.is_query = item.is_query === 2
      item.is_sort = item.is_sort === 2
      form.value.columns.push(item)
    })
  })

  // // 模块列表
  // commonApi.getModuleList().then( res => modules.value = res.data )
  // // 请求菜单列表
  // menuApi.tree({ onlyMenu: true }).then( res => {
  //   menus.value = res.data
  //   menus.value.unshift({ id: 0, value: 0, label: '顶级菜单' })
  // })
  // // 请求角色列表
  // roleApi.getList().then( res => roles.value = res.data )
  // // 请求所有模型
  // generate.getModels().then( res => models.value = res.data )
  // // 请求所有数据表
  // dataMaintain.getPageList({ pageSize: 999 }).then( res => tables.value = res.data.items )
  // // 请求所有字典类型
  // dictType.getTypeList({ pageSize: 999 }).then( res => dicts.value = res.data.items )
}

const save = async (done) => {
  // const validResult = await formRef.value.validate()
  // if (validResult) {
  //   for (let i in validResult) {
  //     Message.error(validResult[i].message)
  //   }
  //   return false
  // }
  form.value.options = formOptions.value
  const response = await getGenerateApi().update(form.value)
  if (response.success) {
    Message.success("操作成功", { zIndex: 9999})
  }
  callbackDone()
  close()
}


const dialogVisible = defineModel('visible', { default: false })

// 定义 open 和 close 方法
async function open(row) {
  const response = await getGenerateApi().readTable({ id: row.id })
  record.value = response.data
  await getMenu()
  init()
  dialogVisible.value = true
}

function close() {
  dialogVisible.value = false
}

let callbackDone;

function callback(callback){
  callbackDone = callback
}

async function loadTable() {
  return false;
}

defineExpose({
  open,
  close,
  callback
})
</script>

<style scoped>
/* 这里是样式区域 */
</style>
