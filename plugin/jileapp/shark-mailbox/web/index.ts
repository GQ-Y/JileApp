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
      name: 'jileapp/shark-mailbox',
      version: '1.0.0',
      author: 'GQ-Y',
      description: '鲨鱼信箱插件',
      order: 1,
    },
  },
  hooks: {
    // 插件在启动时被调用，会传入插件的 config 对象
    start: (config) => {},
    // 插件在系统执行到 `vue` 的 `setup` 生命周期时被调用。
    setup: () => {},
    // 在用户登录时被调用，传入(用户名、token等参数)
    login: (formInfo) => {},
    // 在用户退出时被调用
    logout: () => {},
    // 在请求用户信息后被调用，传入用户权限、角色等数据。
    getUserInfo: (userInfo) => {
      console.log(userInfo)
    },
  },
  views: [
    {
      name: 'shark-mailbox:index',
      path: '/shark-mailbox',
      meta: {
        title: '鲨鱼信箱',
        i18n: 'shark-mailbox.menu.shark-mailbox',
        icon: 'ep:scale-to-original',
        badge: () => 'New',
        type: 'M',
        hidden: false,
        breadcrumbEnable: true,
        copyright: true,
        cache: true,
      },
      children: [
        {
          name: 'shark-mailbox:dashboard',
          path: '/shark-mailbox/dashboard',
          meta: {
            title: '总览',
            i18n: 'shark-mailbox.menu.dashboard',
            icon: 'mdi:finance',
            type: 'M',
            hidden: false,
            breadcrumbEnable: true,
            copyright: false,
            cache: false,
          },
          component: () => import(('./views/dashboard/index.vue')),
        },

      ],
    },
  ],
}

export default pluginConfig
