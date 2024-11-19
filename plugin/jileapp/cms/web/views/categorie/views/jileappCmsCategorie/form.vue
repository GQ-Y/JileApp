<!--
 - MineAdmin is committed to providing solutions for quickly building web applications
 - Please view the LICENSE file that was distributed with this source code,
 - For the full copyright and license information.
 - Thank you very much for using MineAdmin.
 -
 - @Author X.Mo<root@imoi.cn> and NEKGod<1559096467@qq.com>
 - @Link   https://github.com/mineadmin
-->
<script setup lang="ts">
import getFormItems from './data/getFormItems.tsx'
import type { MaFormExpose } from '@mineadmin/form'
import useForm from '@/hooks/useForm.ts'
import { ResultCode } from '@/utils/ResultCode.ts'
import { create, save } from '../../api/jileappCmsCategorie.ts'

defineOptions({ name: 'categorie:jileappCmsCategorie:form' })

const { formType = 'add', data = null } = defineProps<{
  formType: 'add' | 'edit'
  data?: any | null
}>()

const t = useTrans().globalTrans
const formRef = ref<MaFormExpose>()
const formData = ref<any>({})

useForm('formRef').then((form: MaFormExpose) => {
  if (formType === 'edit' && data) {
    Object.keys(data).map((key: string) => {
      formData.value[key] = data[key]
    })
  }
  form.setItems(getFormItems(formType, t, formData.value))
  form.setOptions({
    labelWidth: '80px',
  })
})

// 创建操作
function add(): Promise<any> {
  return new Promise((resolve, reject) => {
    create(formData.value).then((res: any) => {
      res.code === ResultCode.SUCCESS ? resolve(res) : reject(res)
    }).catch((err) => {
      reject(err)
    })
  })
}
// 更新操作
function edit(): Promise<any> {
  return new Promise((resolve, reject) => {
    save(formData.value.id as number, formData.value).then((res: any) => {
      res.code === ResultCode.SUCCESS ? resolve(res) : reject(res)
    }).catch((err) => {
      reject(err)
    })
  })
}

defineExpose({
  add,
  edit,
  maForm: formRef
})
</script>

<template>
  <ma-form ref="formRef" v-model="formData" />
</template>

<style scoped lang="scss">

</style>
