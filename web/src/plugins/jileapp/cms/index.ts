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
      name: 'jileapp/cms',
      version: '1.0.0',
      author: 'GQ-Y',
      description: '内容管理插件',
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
      name: 'cms:index',
      path: '/cms',
      meta: {
        title: '内容管理',
        i18n: 'cms.menu.cms',
        icon: 'ep:scale-to-original',
        type: 'M',
        hidden: false,
        breadcrumbEnable: true,
        copyright: true,
        cache: true,
      },
      children: [
        {
          name: 'tag:jileappCmsTag',
          path: '/tag/jileappCmsTag',
          meta: {
            title: '标签管理',
            i18n: 'cms.menu.tag',
            icon: 'ep:collection-tag',
            type: 'M',
            hidden: false,
            breadcrumbEnable: true,
            copyright: true,
            cache: true,
          },
          component: () => import(('./views/tag/views/jileappCmsTag/index.vue')),
        },
        {
          name: 'snippets:jileappCmsSnippets',
          path: '/snippets/jileappCmsSnippets',
          meta: {
            title: '变量管理',
            i18n: 'cms.menu.snippets',
            icon: 'ant-design:codepen-outlined',
            type: 'M',
            hidden: false,
            breadcrumbEnable: true,
            copyright: true,
            cache: true,
          },
          component: () => import(('./views/snippets/views/jileappCmsSnippets/index.vue')),
        },
        {
          name: 'categorie:jileappCmsCategorie',
          path: '/categorie/jileappCmsCategorie',
          meta: {
            title: '分类管理',
            i18n: 'cms.menu.categorie',
            icon: 'ri:folder-line',
            type: 'M',
            hidden: false,
            breadcrumbEnable: true,
            copyright: true,
            cache: true,
          },
          component: () => import(('./views/categorie/views/jileappCmsCategorie/index.vue')),
        },
        {
          name: 'article:jileappCmsArticle',
          path: '/article/jileappCmsArticle',
          meta: {
            title: '文章管理',
            i18n: 'cms.menu.article',
            icon: 'ri:article-line',
            type: 'M',
            hidden: false,
            breadcrumbEnable: true,
            copyright: true,
            cache: true,
          },
          component: () => import(('./views/article/views/jileappCmsArticle/index.vue')),
        },
        {
          name: 'advertisement:jileappCmsAdvertisement',
          path: '/advertisement/jileappCmsAdvertisement',
          meta: {
            title: '广告管理',
            i18n: 'cms.menu.advertisement',
            icon: 'ri:kanban-view',
            type: 'M',
            hidden: false,
            breadcrumbEnable: true,
            copyright: true,
            cache: true,
          },
          component: () => import(('./views/advertisement/views/jileappCmsAdvertisement/index.vue')),
        },
        {
          name: 'position:jileappCmsAdPosition',
          path: '/position/jileappCmsAdPosition',
          meta: {
            title: '广告位管理',
            i18n: 'cms.menu.position',
            icon: 'ri:advertisement-line',
            type: 'M',
            hidden: false,
            breadcrumbEnable: true,
            copyright: true,
            cache: true,
          },
          component: () => import(('./views/position/views/jileappCmsAdPosition/index.vue')),
        },

      ],
    },
  ],
}

export default pluginConfig
