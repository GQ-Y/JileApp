/**
 * MineAdmin is committed to providing solutions for quickly building web applications
 * Please view the LICENSE file that was distributed with this source code,
 * For the full copyright and license information.
 * Thank you very much for using MineAdmin.
 *
 * @Author X.Mo<root@imoi.cn>
 * @Link   https://github.com/mineadmin
 */
import type { App } from 'vue'
import type { Plugin } from '#/global'

const pluginConfig: Plugin.PluginConfig = {
  // eslint-disable-next-line unused-imports/no-unused-vars
  install(app: App) {},
  config: {
    enable: true,
    info: {
      name: 'mine-admin/code-generator',
      version: '1.0.0',
      author: 'X.Mo',
      description: 'MineAdmin 代码生成器，提供一键生成CRUD功能',
    },
  },
  views: [
    {
      name: 'MineCodeGenerator',
      path: '/code-generator',
      meta: {
        title: '代码生成器',
        i18n: 'codeGenerator.menu.codeGenerator',
        icon: 'i-solar:code-square-outline',
        type: 'M',
        hidden: false,
        breadcrumbEnable: true,
        copyright: true,
        cache: true,
      },
      component: () => import(('./views/index.vue')),
    },
    {
      name: 'MineCodeGeneratorEditor',
      path: '/code-generator-editor/:pool/:tableName',
      meta: {
        title: '编辑生成信息',
        i18n: 'codeGenerator.menu.codeGeneratorEditor',
        icon: 'i-solar:code-square-outline',
        type: 'M',
        hidden: true,
        breadcrumbEnable: true,
        copyright: true,
        cache: true,
        activeName: 'MineCodeGenerator',
      },
      component: () => import(('./views/form.vue')),
    },
  ],
}

export default pluginConfig
