/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://github.com/mineadmin
 */
const url = 'https://element-plus.org/zh-CN/component'
export default [
  {
    labelValue: 'input',
    component: 'el-input',
    docUrl: `${url}/input.html#attributes`,
  },
  {
    labelValue: 'inputNumber',
    component: 'el-input-number',
    docUrl: `${url}/input-number.html#attributes`,
  },
  {
    labelValue: 'switch',
    component: 'el-switch',
    docUrl: `${url}/switch.html#attributes`,
  },
  {
    labelValue: 'timePicker',
    component: 'el-time-picker',
    docUrl: `${url}/time-picker.html#attributes`,
  },
  {
    labelValue: 'datePicker',
    component: 'el-date-picker',
    docUrl: `${url}/date-picker.html#属性`,
  },
  {
    labelValue: 'remoteSelect',
    component: 'ma-remote-select',
    docUrl: `${url}/select-v2.html#attributes`,
    renderProps: {
      url: '',
      axiosConfig: {
        method: 'get',
        params: {},
        data: {},
        header: {},
        timeout: 5000,
      },
      dataHandle: null,
    },
  },
  {
    labelValue: 'dictRadio',
    component: 'ma-dict-radio',
    docUrl: `${url}/radio.html#radio-attributes`,
    renderProps: {
      dictName: '',
      data: [],
      transScope: 'global',
    },
  },
  {
    labelValue: 'dictCheckbox',
    component: 'ma-dict-checkbox',
    docUrl: `${url}/checkbox.html#checkbox-attributes`,
    renderProps: {
      dictName: '',
      data: [],
      transScope: 'global',
    },
  },
  {
    labelValue: 'dictSelect',
    component: 'ma-dict-select',
    docUrl: `${url}/select.html#select-attributes`,
    renderProps: {
      dictName: '',
      data: [],
      transScope: 'global',
    },
  },
  {
    labelValue: 'iconPicker',
    component: 'ma-icon-picker',
  },
  {
    labelValue: 'uploadFile',
    component: 'ma-upload-file',
    renderProps: {
      title: '文件上传',
      fileSize: 10 * 1024 * 1024,
      fileType: ['doc', 'xls', 'ppt', 'txt', 'pdf'],
      limit: 1,
      multiple: false,
    },
  },
  {
    labelValue: 'uploadImage',
    component: 'ma-upload-image',
    renderProps: {
      title: '图片上传',
      fileSize: 10 * 1024 * 1024,
      fileType: ['image/jpeg', 'image/png', 'image/gif'],
      limit: 1,
      multiple: false,
    },
  },
  {
    labelValue: 'cascader',
    component: 'el-cascader',
    docUrl: `${url}/cascader.html#cascader-attributes`,
  },
  {
    labelValue: 'rate',
    component: 'el-rate',
    docUrl: `${url}/rate.html#attributes`,
  },
  {
    labelValue: 'selectV2',
    component: 'el-select-v2',
    docUrl: `${url}/select-v2.html#attributes`,
  },
  {
    labelValue: 'treeSelect',
    component: 'el-tree-select',
    docUrl: `${url}/tree-select.html#attributes`,
  },
  {
    labelValue: 'MaTree',
    component: 'ma-tree',
    docUrl: `${url}/tree.html#属性`,
  },
  {
    labelValue: 'colorPicker',
    component: 'el-color-picker',
    docUrl: `${url}/color-picker.html#attributes`,
  },
  {
    labelValue: 'slider',
    component: 'el-slider',
    docUrl: `${url}/slider.html#属性`,
  },
  {
    labelValue: 'autocomplete',
    component: 'el-autocomplete',
    docUrl: `${url}/autocomplete.html#attributes`,
  },
  {
    labelValue: 'transfer',
    component: 'el-transfer',
    docUrl: `${url}/transfer#transfer-属性`,
  },

]
