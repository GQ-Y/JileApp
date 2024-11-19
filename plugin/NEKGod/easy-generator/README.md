

# 代码生成器使用文档

## 安装和配置

### 步骤 1: 下载应用

进入后端项目根目录后，执行以下命令来下载 `NEKGod/easy-generator` 插件，确保下载对应版本。

```bash
php bin/hyperf.php mine-extension:download NEKGod/easy-generator 1.2.0
```

### 步骤 2: 安装应用

下载完成后，执行以下命令进行应用安装。

```bash
php bin/hyperf.php mine-extension:install NEKGod/easy-generator -yes
```

## 数据库表设计

为了生成表单和数据字典等组件，您需要设计好数据库表结构。以下是一个示例 `test` 表的设计，包含了各种常见的表单字段类型（如文本框、单选框、多选框、文件上传等）及其相关字段后缀的映射规则。

### SQL 代码

```sql
CREATE TABLE `test` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `test_title` varchar(255) DEFAULT NULL COMMENT '文本输入框',
  `test_select` int(10) DEFAULT NULL COMMENT '单选选择框:1=选择1,2=选择2,3=选择3',
  `test_selects` json DEFAULT NULL COMMENT '多选选择框:1=选择1,2=选择2,3=选择3',
  `test_radio` tinyint(4) DEFAULT NULL COMMENT '单选框:1=选择1,2=选择2',
  `test_checkbox` json DEFAULT NULL COMMENT '复选框:1=选择1,2=选择2,3=选择3',
  `test_file` varchar(255) DEFAULT NULL COMMENT '文件上传',
  `test_image` varchar(255) DEFAULT NULL COMMENT '图片上传',
  `created_at` timestamp NULL DEFAULT NULL COMMENT '创建时间',
  `updated_at` timestamp NULL DEFAULT NULL COMMENT '更新时间',
  `status` tinyint(4) DEFAULT NULL COMMENT '状态:1=完成,2=转换中,0=转换失败',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='测试';
```

### 字段后缀映射规则

根据表字段的后缀，生成器会自动识别并生成相应的表单组件。以下是常见字段后缀及其对应的组件类型：

---

## 字段后缀映射规则

| 后缀名        | 生成的组件类型      | 说明                                                                 | 建议数据类型       |
|------------|-------------------|----------------------------------------------------------------------|------------------|
| `*`        | 文本输入框           | 生成一个文本输入框。                                                   | `VARCHAR`        |
| `select`   | 单选框               | 生成一个单选框，选项通过 `1=选择1, 2=选择2, 3=选择3` 映射为 `label` 和 `value`。  | `INT`            |
| `selects`  | 多选框               | 生成一个多选框，选项通过 JSON 格式存储，映射为 `label` 和 `value`。         | `JSON`           |
| `radio`    | 单选框（是/否）       | 生成一个单选框，`1=选择1, 2=选择2` 映射为选项的 `label` 和 `value`。       | `TINYINT`        |
| `checkbox` | 复选框               | 生成一个复选框，选项通过 JSON 格式存储，映射为 `label` 和 `value`。         | `JSON`           |
| `file`     | 文件上传组件          | 生成一个文件上传组件。                                                 | `VARCHAR`        |
| `image`    | 图片上传组件          | 生成一个图片上传组件。                                                 | `VARCHAR`        |
| `at`       | 时间选择器            | 生成一个时间选择器。                                                   | `TIMESTAMP`      |
| `status`   | 状态选择框            | 生成状态选择框，`1=完成, 2=转换中, 0=转换失败` 映射为 `label` 和 `value`。 | `TINYINT`        |
| `textarea` | 文本框               | 生成一个多行文本输入框。                                               | `VARCHAR`        |
---

### 详细说明

- **`select` 字段**：该字段会生成一个单选框。选项 `1=选择1, 2=选择2, 3=选择3` 会自动映射为单选框的 `label`（例如 `选择1`, `选择2`, `选择3`）和 `value`（例如 `1`, `2`, `3`）。

  生成的 HTML 代码示例如下：

  ```html
  <select name="test_select">
    <option value="1">选择1</option>
    <option value="2">选择2</option>
    <option value="3">选择3</option>
  </select>
  ```

- **`radio` 字段**：该字段会生成一个单选框，选项 `1=选择1, 2=选择2` 会自动映射为单选框的 `label` 和 `value`。

  生成的 HTML 代码示例如下：

  ```html
  <input type="radio" name="test_radio" value="1"> 选择1
  <input type="radio" name="test_radio" value="2"> 选择2
  ```

- **`checkbox` 字段**：该字段会生成一个复选框，选项 `1=选择1, 2=选择2, 3=选择3` 会通过 JSON 格式存储，并自动映射为复选框的 `label` 和 `value`。

- **`status` 字段**：该字段会生成一个状态选择框，选项 `1=完成, 2=转换中, 0=转换失败` 会自动映射为状态的 `label` 和 `value`。

## 自动识别组件

在表设计过程中，系统会根据字段的后缀自动识别出以下组件并生成相应的表单项。例如：

- `test_title` 会自动生成一个文本输入框。
- `test_select` 会自动生成一个单选框，选项为 `选择1`, `选择2`, `选择3`，对应值为 `1`, `2`, `3`。
- `test_radio` 会自动生成一个单选框，选项为 `选择1` 和 `选择2`，对应值为 `1` 和 `2`。
- `test_checkbox` 会自动生成复选框组件，支持多选。

## 生成的表单与组件

根据上述表结构，生成的表单将自动包含适合的表单组件，无需额外配置。您可以通过 `easy-generator` 扩展快速创建和管理表单、数据字典等。