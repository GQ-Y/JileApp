## 代码生成器

MineAdmin 3.0 版本代码生成器插件。

## 下载插件

- 后台应用市场下载插件
- 命令安装，在后端根目录下执行命令：

```bash
php bin/hyperf.php mine-extension:download mine-admin/code-generator
```
## 安装插件

- 后台应用商店安装插件
- 命令安装，在后端根目录下执行命令：

```bash
php bin/hyperf.php mine-extension:install mine-admin/code-generator --yes
```


## 注意事项
如果报错，可能是前端缺少依赖，请在前端根目录下执行以下命令：
```bash
pnpm i ace-builds vue3-ace-editor -D
```