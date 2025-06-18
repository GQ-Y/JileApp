# MineAdmin系统初始化数据库流程

### 安装Vendor

./swoole-cli /opt/homebrew/Cellar/composer/2.8.9/bin/composer install -vvv

### 数据表迁移

./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php migrate

### 数据填充

./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php db:seed

# 前端启动

进入web目录：cd web

安装依赖：pnpm i

启动本地开发：pnpm dev

---

# 作者信息

**作者**: GQ
**邮箱**: 1959595510@qq.com
**官网**: www.guanqi.store
**GitHub**: [@GQ-Y](https://github.com/GQ-Y)

---

# MineAdmin插件开发规范要求

## 重要说明：命令执行器

### 命令执行规范

在本系统中，所有涉及PHP和Composer的命令操作必须使用特定的执行器：

1. **PHP命令执行**：使用 `./swoole-cli -d swoole.use_shortname='Off'` 作为PHP命令执行器

   ```bash
   # 示例：执行MineAdmin命令
   ./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:list
   ```
2. **Composer命令执行**：使用 `./swoole-cli /opt/homebrew/Cellar/composer/2.8.9/bin/composer` 作为Composer命令执行器

   ```bash
   # 示例：安装依赖
   ./swoole-cli /opt/homebrew/Cellar/composer/2.8.9/bin/composer install -vvv

   # 示例：更新依赖
   ./swoole-cli /opt/homebrew/Cellar/composer/2.8.9/bin/composer update
   ```

**注意**：本文档中所有命令示例均已按此规范更新，请严格按照此规范执行相关命令。

---

## 重要：MineAdmin插件安装机制

### 插件安装执行顺序

MineAdmin在安装插件时具有特定的执行顺序，理解这个顺序对于正确编写InstallScript和Migration至关重要：

1. **InstallScript执行**：首先执行插件的InstallScript::__invoke()方法
2. **数据库迁移执行**：然后自动执行Database/Migrations/目录下的迁移文件
3. **数据填充执行**：最后自动执行Database/Seeders/目录下的填充文件
4. **创建install.lock**：安装成功后自动创建install.lock文件标识插件已安装

### install.lock文件管理

**重要提醒：**`install.lock` 文件完全由MineAdmin框架自动管理，开发者不应该手动创建或删除此文件。

- **安装时**：框架自动创建 `install.lock` 文件
- **卸载时**：框架自动删除 `install.lock` 文件
- **状态检查**：框架通过此文件判断插件安装状态

**❌ 错误做法：**

```bash
# 不要手动创建install.lock文件
echo "1" > plugin/vendor/plugin-name/install.lock
```

**✅ 正确做法：**
让MineAdmin框架完全管理 `install.lock` 文件的生命周期。

### InstallScript最佳实践

**❌ 错误做法：**

```php
class InstallScript
{
    public function __invoke()
    {
        // 错误：手动创建表会与系统自动迁移冲突
        Schema::create('gq_tag_info', function ($table) {
            // ...
        });
    }
}
```

**✅ 正确做法：**

```php
class InstallScript
{
    public function __invoke()
    {
        try {
            // 只执行非数据库相关的初始化工作
            $this->initializeConfig();
            $this->setupDirectories();
        
            echo "Plugin installed successfully\n";
        } catch (\Throwable $e) {
            echo "Plugin installation failed: " . $e->getMessage() . "\n";
            // 不抛出异常，避免阻止后续安装流程
        }
    }

    private function initializeConfig(): void
    {
        // 初始化配置文件
        // 设置默认配置项
    }

    private function setupDirectories(): void
    {
        // 创建必要的目录
        // 设置权限等
    }
}
```

### 数据库迁移和填充分离

1. **Migration文件**：只负责数据库结构定义（表、索引、外键等）
2. **Seeder文件**：只负责初始数据填充
3. **InstallScript**：负责非数据库相关的初始化工作

这种分离确保了：

- 避免重复创建表的错误
- 保持代码职责单一
- 便于维护和调试

---

## MineAdmin官方支持的所有命令

```
Console Tool

Usage:
  command [options] [arguments]

Options:
  -h, --help            Display help for the given command. When no command is given display help for the list command
  -q, --quiet           Do not output any message
  -V, --version         Display this application version
      --ansi|--no-ansi  Force (or disable --no-ansi) ANSI output
  -n, --no-interaction  Do not ask any interactive question
  -v|vv|vvv, --verbose  Increase the verbosity of messages: 1 for normal output, 2 for more verbose output and 3 for debug

Available commands:
  completion                 Dump the shell completion script
  help                       Display help for a command
  info                       Dump the server info.
  list                       List commands
  migrate                    Run the database migrations
  start                      Start hyperf servers.
  tinker                     Interact with your application
 codeGen
  codeGen:model              Create new model classes.
 crontab
  crontab:run      
 db
  db:seed                    Seed the database with records
 describe
  describe:aspects           Describe the aspects.
  describe:listeners         Describe the events and listeners.
  describe:routes            Describe the routes information.
 gen
  gen:amqp-consumer          Create a new amqp consumer class
  gen:amqp-producer          Create a new amqp producer class
  gen:aspect                 Create a new aspect class
  gen:class                  Create a new class
  gen:command                Create a new command class
  gen:constant               Create a new constant class
  gen:controller             Create a new controller class
  gen:job                    Create a new job class
  gen:kafka-consumer         Create a new kafka consumer class
  gen:listener               Create a new listener class
  gen:middleware             Create a new middleware class
  gen:migration              Generate a new migration file
  gen:model                  Create new model classes.
  gen:nats-consumer          Create a new nats consumer class
  gen:nsq-consumer           Create a new nsq-consumer class
  gen:process                Create a new process class
  gen:request                Create a new form request class
  gen:resource               create a new resource
  gen:seeder                 Create a new seeder class
  gen:swagger                Generate swagger json file.
  gen:swagger-schema         Generate swagger schemas.
  gen:view-engine-cache      Generate View Engine Cache
 migrate
  migrate:fresh              Drop all tables and re-run all migrations
  migrate:install            Create the migration repository
  migrate:refresh            Reset and re-run all migrations
  migrate:reset              Rollback all database migrations
  migrate:rollback           Rollback the last database migration
  migrate:status             Show the status of each migration
 mine
  mine:model-gen             Generate model to module according to data table
  mine:request-gen           Generate validate form request class file
  mine:update-20241031   
 mine-extension
  mine-extension:create      Creating Plug-ins
  mine-extension:download    Download the specified remote plug-in file locally
  mine-extension:initial     MineAdmin Extended Store Initialization Command Line
  mine-extension:install     Installing Plugin Commands
  mine-extension:list        View a list of remote app store plugins
  mine-extension:local-list  List all locally installed extensions(列出本地所有已经安装的扩展)
  mine-extension:push        Quickly perform plugin packaging and deployment processing.
  mine-extension:release   
  mine-extension:script      Publish any publishable configs from vendor plugins.
  mine-extension:uninstall   Uninstalling Plugin Commands
 queue
  queue:dynamic-reload       Reload all failed message into waiting queue.
  queue:flush                Delete all message from failed queue.
  queue:info                 Get all messages from the queue.
  queue:reload               Reload all failed message into waiting queue.
 server
  server:watch               watch command
 vendor
  vendor:publish             Publish any publishable configs from vendor packages.
 view
  view:publish
```

---

## 一、插件初始化规范

### 1.1 插件创建命令

```bash
# 创建新插件
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:create <plugin-name>

# 示例：创建景点管理插件
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:create attraction-management
```

### 1.2 插件命名规范

- 插件名称使用小写字母和连字符，如：`attraction-management`
- 插件目录命名：`plugin/<vendor>/<plugin-name>/`
- 命名空间遵循PSR-4规范：`Plugin\<Vendor>\<PluginName>`

## 二、插件目录结构规范

### 2.1 标准目录结构

根据官方插件规范，标准目录结构如下：

```
plugin/
└── <vendor>/
    └── <plugin-name>/
        ├── Database/
        │   ├── Migrations/          # 数据库迁移文件
        │   └── Seeders/            # 数据填充文件
        ├── src/
        │   ├── ConfigProvider.php  # 配置提供者（必需）
        │   ├── InstallScript.php   # 安装脚本（可选）
        │   ├── UninstallScript.php # 卸载脚本（可选）
        │   ├── Controller/         # 控制器目录
        │   │   └── AbstractController.php  # 抽象控制器基类
        │   ├── Model/              # 模型目录
        │   ├── Repository/         # 仓储目录（可选）
        │   ├── Service/            # 服务目录（必需）
        │   └── Common/             # 公共类目录（可选）
        └── mine.json               # 插件元信息（必需）
```

**目录说明：**

- `src/`: 插件源码主目录
- `Controller/`: 控制器层，负责请求处理和响应
- `Service/`: 服务层，负责业务逻辑处理（必需）
- `Model/`: 模型层，负责数据模型定义
- `Repository/`: 仓储层，负责数据访问（可选）
- `Common/`: 公共工具类和辅助类
- `Database/`: 数据库相关文件

### 2.2 核心文件要求

#### ConfigProvider.php（必需）

参考官方插件的配置提供者实现：

```php
<?php

declare(strict_types=1);

namespace Plugin\<Vendor>\<PluginName>;

class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            // 合并到 config/autoload/annotations.php 文件
            'annotations' => [
                'scan' => [
                    'paths' => [
                        __DIR__,
                    ],
                ],
            ],
            // 可选配置项
            'dependencies' => [
                // 依赖注入配置
            ],
            'commands' => [
                // 命令行工具配置
            ],
            'listeners' => [
                // 事件监听器配置
            ],
        ];
    }
}
```

**配置要点：**

- 使用严格类型声明 `declare(strict_types=1)`
- `annotations.scan.paths` 必须包含当前目录 `__DIR__`
- 其他配置项根据插件需要选择性添加
- 保持配置的简洁性和必要性

#### InstallScript.php（推荐）

```php
<?php
namespace Plugin\<Vendor>\<PluginName>;

class InstallScript
{
    public function __invoke()
    {
        try {
            // 只执行非数据库相关的初始化工作
            $this->initializeConfig();
            $this->setupDirectories();
          
            echo "Plugin installed successfully\n";
        } catch (\Throwable $e) {
            echo "Plugin installation failed: " . $e->getMessage() . "\n";
            // 不抛出异常，避免阻止后续安装流程
        }
    }

    private function initializeConfig(): void
    {
        // 初始化配置文件
        // 设置默认配置项
    }

    private function setupDirectories(): void
    {
        // 创建必要的目录
        // 设置权限等
    }
}
```

#### UninstallScript.php（推荐）

```php
<?php
namespace Plugin\<Vendor>\<PluginName>;

use Hyperf\Database\Schema\Schema;

class UninstallScript
{
    public function __invoke()
    {
        try {
            // 删除数据表
            $this->dropTables();
          
            echo "Plugin uninstalled successfully\n";
        } catch (\Throwable $e) {
            echo "Plugin uninstallation failed: " . $e->getMessage() . "\n";
            throw $e;
        }
    }

    private function dropTables(): void
    {
        $tables = [
            'gq_plugin_table',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::dropIfExists($table);
            }
        }
    }
}
```

#### mine.json（必需）

根据官方插件规范，`mine.json` 文件应采用以下标准结构：

```json
{
  "name": "<vendor>/<plugin-name>",
  "description": "插件描述",
  "version": "1.0.0",
  "author": [
    {
      "name": "GQ",
      "email": "1959595510@qq.com"
    }
  ],
  "package": {
    "dependencies": {
      // 插件依赖的其他插件
    }
  },
  "composer": {
    "require": {
      "php": ">=8.0",
      "hyperf/hyperf": "~3.0.0"
    },
    "psr-4": {
      "Plugin\\<Vendor>\\<PluginName>\\": "src"
    },
    "installScript": "Plugin\\<Vendor>\\<PluginName>\\InstallScript",
    "uninstallScript": "Plugin\\<Vendor>\\<PluginName>\\UninstallScript",
    "config": "Plugin\\<Vendor>\\<PluginName>\\ConfigProvider"
  }
}
```

**字段说明：**

- `name`: 插件完整名称（vendor/plugin-name格式）
- `description`: 插件功能描述
- `version`: 版本号（遵循语义化版本规范）
- `author`: 作者信息数组
- `package.dependencies`: 插件依赖关系
- `composer.require`: Composer依赖要求
- `composer.psr-4`: PSR-4自动加载映射
- `composer.installScript`: 安装脚本类路径
- `composer.uninstallScript`: 卸载脚本类路径
- `composer.config`: ConfigProvider类路径

## 三、插件管理命令规范

### 3.1 安装插件

```bash
# 安装指定插件
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:install <vendor>/<plugin-name>

# 示例
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:install gq/tag-management
```

### 3.2 卸载插件

```bash
# 卸载指定插件
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:uninstall <vendor>/<plugin-name>

# 示例
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:uninstall gq/tag-management
```

### 3.3 插件管理命令

```bash
# 查看远程插件列表
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:list

# 查看本地已安装插件列表
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:local-list

# 创建新插件
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:create <plugin-name>

# 下载远程插件
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:download <plugin-name>

# 插件打包和部署
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:push

# 发布插件配置
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php mine-extension:script
```

## 四、数据库规范

### 4.1 表命名规范

- 表名格式：`<prefix>_<module>_<function>`
- 前缀统一使用：`gq_` (根据插件作者自定义)
- 示例：
  - `gq_attraction_category` (景点分类表)
  - `gq_attraction_info` (景点信息表)
  - `gq_attraction_images` (景点图片表)

### 4.2 迁移文件规范

```php
<?php
use Hyperf\Database\Schema\Schema;
use Hyperf\Database\Schema\Blueprint;
use Hyperf\Database\Migrations\Migration;

class CreateAttractionInfoTable extends Migration
{
    public function up(): void
    {
        Schema::create('gq_attraction_info', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->comment('景点名称');
            $table->text('description')->nullable()->comment('景点描述');
            $table->decimal('latitude', 10, 7)->comment('纬度');
            $table->decimal('longitude', 10, 7)->comment('经度');
            $table->tinyInteger('status')->default(1)->comment('状态:1启用,0禁用');
            $table->timestamps();
            $table->comment('景点信息表');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gq_attraction_info');
    }
}
```

### 4.3 数据填充规范

```php
<?php
use Hyperf\Database\Seeders\Seeder;
use Hyperf\DbConnection\Db;

class AttractionSeeder extends Seeder
{
    public function run()
    {
        Db::table('gq_attraction_info')->insert([
            'name' => '示例景点',
            'description' => '这是一个示例景点',
            'latitude' => 39.9042,
            'longitude' => 116.4074,
            'status' => 1,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]);
    }
}
```

## 五、代码开发规范

### 5.1 控制器规范

#### 5.1.1 抽象控制器基类

每个插件应该定义自己的抽象控制器基类：

```php
<?php

declare(strict_types=1);

namespace Plugin\<Vendor>\<PluginName>\Controller;

use App\Http\Common\Controller\AbstractController as BaseController;
use Hyperf\HttpServer\Contract\RequestInterface;

abstract class AbstractController extends BaseController
{
    public function __construct(
        protected RequestInterface $request
    ) {}
}
```

#### 5.1.2 具体控制器实现

```php
<?php

declare(strict_types=1);

namespace Plugin\<Vendor>\<PluginName>\Controller;

use App\Http\Common\Result;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\GetMapping;
use Hyperf\HttpServer\Annotation\PostMapping;

#[Controller(prefix: 'admin/plugin/<plugin-prefix>')]
class IndexController extends AbstractController
{
    #[Inject]
    public SomeService $service;

    #[GetMapping('index')]
    public function index(): Result
    {
        return $this->success($this->service->list($this->request->all()));
    }

    #[PostMapping('create')]
    public function create(): Result
    {
        return $this->success($this->service->create($this->request->all()));
    }
}
```

**规范要点：**

- 使用 `declare(strict_types=1)` 严格类型声明
- 继承插件内部的 `AbstractController`
- 使用 Hyperf 注解进行路由定义
- 路由前缀格式：`admin/plugin/<plugin-prefix>`
- 统一返回 `Result` 类型
- 使用依赖注入获取服务实例

### 5.2 模型规范

```php
<?php
namespace Plugin\<Vendor>\<PluginName>\Model;

use Hyperf\DbConnection\Model\Model;

class AttractionInfo extends Model
{
    protected ?string $table = 'gq_attraction_info';
  
    protected array $fillable = [
        'name', 'description', 'latitude', 'longitude', 'status'
    ];
  
    protected array $casts = [
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
        'status' => 'integer',
    ];
}
```

### 5.3 服务层规范

参考官方插件，服务层应该包含业务逻辑处理和异常处理：

```php
<?php

declare(strict_types=1);

namespace Plugin\<Vendor>\<PluginName>\Service;

use App\Exception\BusinessException;
use App\Http\Common\ResultCode;

class Service
{
    public function handleAction(array $params): bool
    {
        if (empty($params['required_field'])) {
            $this->throwParamsFail();
        }

        try {
            // 业务逻辑处理
            $result = $this->processBusinessLogic($params);
  
            if (!$result) {
                $this->throwProcessFail();
            }
  
            return true;
        } catch (\RuntimeException $e) {
            throw new \RuntimeException($e->getMessage());
        } catch (\Throwable $e) {
            throw new \RuntimeException($e->getMessage());
        }
    }

    protected function processBusinessLogic(array $params): bool
    {
        // 具体业务逻辑实现
        return true;
    }

    protected function throwParamsFail(): void
    {
        throw new BusinessException(ResultCode::FAIL, '参数错误');
    }

    protected function throwProcessFail(): void
    {
        throw new BusinessException(ResultCode::FAIL, '处理失败');
    }
}
```

**服务层规范要点：**

- 使用严格类型声明
- 统一异常处理机制
- 参数验证和业务逻辑分离
- 使用 `BusinessException` 处理业务异常
- 提供明确的错误提示信息

## 六、开发调试规范

### 6.1 开发环境要求

- PHP >= 8.0（通过 `./swoole-cli` 执行）
- Hyperf >= 3.0
- MySQL >= 5.7 或 PostgreSQL >= 10
- Redis >= 5.0

### 6.2 调试命令

```bash
# 启动Hyperf服务器
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php start

# 热重启服务（如果支持）
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php server:watch

# 查看路由信息
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php describe:routes

# 查看服务器信息
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php info

# 数据库迁移状态
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php migrate:status
```

### 6.3 代码生成命令

```bash
# 生成控制器
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php gen:controller <ControllerName>

# 生成模型
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php gen:model <ModelName>

# 生成迁移文件
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php gen:migration <migration_name>

# 生成Seeder
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php gen:seeder <SeederName>

# 生成请求验证类
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php gen:request <RequestName>

# 生成中间件
./swoole-cli -d swoole.use_shortname='Off' bin/hyperf.php gen:middleware <MiddlewareName>
```

## 七、性能和安全规范

### 7.1 性能优化

- 合理使用协程特性
- 数据库查询优化（避免N+1问题）
- 适当使用缓存机制
- 大数据处理使用消息队列

### 7.2 安全规范

- 输入验证和过滤
- SQL注入防护
- XSS攻击防护
- 权限控制验证
- 敏感数据加密存储

## 八、测试规范

### 8.1 单元测试

```php
<?php
namespace PluginTest\<Vendor>\<PluginName>;

use PHPUnit\Framework\TestCase;

class ServiceTest extends TestCase
{
    public function testMethod()
    {
        // 测试代码
    }
}
```

### 8.2 集成测试

- 测试插件安装/卸载流程
- 测试API接口功能
- 测试数据库操作正确性

## 九、版本管理规范

### 9.1 版本号规范

- 遵循语义化版本规范（Semantic Versioning）
- 格式：主版本号.次版本号.修订号（例：1.2.3）
- 主版本号：不兼容的API修改
- 次版本号：向下兼容的功能性新增
- 修订号：向下兼容的问题修正

## 十、基于官方插件的额外规范

### 10.1 文件上传处理

对于需要处理文件上传的插件：

```php
public function uploadFile(UploadedFile $file): bool
{
    try {
        $runtimePath = BASE_PATH . '/runtime/' . uniqid('plugin', true) . '.zip';
        $file->moveTo($runtimePath);
  
        // 处理文件逻辑
        $this->processFile($runtimePath);
  
        // 清理临时文件
        @unlink($runtimePath);
  
        return true;
    } catch (\Throwable $e) {
        throw new \RuntimeException($e->getMessage());
    }
}
```

### 10.2 插件依赖管理

在 `mine.json` 中使用 `package.dependencies` 字段管理插件间依赖关系：

```json
{
  "package": {
    "dependencies": {
      "mine-admin/core": ">=1.0.0",
      "vendor/required-plugin": "~2.0.0"
    }
  }
}
```

### 10.3 错误处理规范

基于官方插件的错误处理模式：

1. **统一异常类型**：使用 `BusinessException` 处理业务异常
2. **错误消息规范**：提供清晰的错误提示信息
3. **异常传播**：适当处理和传播异常信息
4. **资源清理**：确保异常时资源得到正确清理

### 10.4 插件配置规范

- 插件配置应该通过 `ConfigProvider` 进行管理
- 避免硬编码配置项
- 支持环境变量配置（如 `MINE_ACCESS_TOKEN`）
- 提供合理的默认值

### 10.5 插件安全检查

```php
#[GetMapping('hasAccessToken')]
public function hasAccessToken(): Result
{
    return $this->success(['isHas' => env('MINE_ACCESS_TOKEN') !== null]);
}
```

基于官方插件实现，应该提供安全检查接口，验证必要的配置项是否存在。

---

以上规范要求适用于MineAdmin系统的所有插件开发，开发者应严格遵循这些规范以确保插件的质量、兼容性和可维护性。本规范基于官方插件的最佳实践制定，代表了当前的技术标准和开发规范。

**文档作者**: GQ
**技术支持**: [@GQ-Y](https://github.com/GQ-Y)
**官方网站**: www.guanqi.store
