## ThinkPHP ORM 分页驱动库

### 环境

- php >= 7.2.5
- think-orm 2.0/3.0

### 安装

```bash
composer require hulang/think-paginator-driver
```

内含以下前端框架的分页驱动

* [Bootstrap](#Bootstrap)
* [Layui](#layui)
* [Amaze UI](#amaze-ui)
* [Foundation](#foundation)

## 配置

### 1.服务提供定义文件里重新绑定服务
编辑`app/provider.php`文件，在该文件里重新绑定`think\Paginator`分页服务，该方法适用于ThinkPHP6.0+，全局生效。
```php
return [
    'think\Paginator' => \hulang\thinkPaginatorDriver\Bootstrap::class
];
```

### 2.公共函数文件里绑定服务
编辑`app/common.php`文件，在该文件里重新绑定`think\Paginator`分页服务，该方法适用于ThinkPHP6，全局生效。

如果想单应用生效，请在应用的公共函数文件里重新绑定`think\Paginator`分页服务，如：`app/admin/common.php`。

```php
// 设置服务注入
\think\facade\App::bind('think\Paginator', \hulang\thinkPaginatorDriver\Bootstrap::class);
```

如果只想一个地方生效，可以在进行分页查询前，使用该代码重新绑定`think\Paginator`分页服务。

```
// 设置服务注入
\think\facade\App::bind('think\Paginator', \hulang\thinkPaginatorDriver\Bootstrap::class);

// 获取users表数据并进行分页
$list = \think\facade\Db::table('users')->paginate();
```

### 3.配置文件里定义分页类
编辑`config/paginate.php`文件，修改`type`配置项的值为`\hulang\thinkPaginatorDriver\Bootstrap::class`，该方法仅适用于ThinkPHP5.1.
```php
return [
    'type' => \hulang\thinkPaginatorDriver\Bootstrap::class,
];
```

## 已支持的前端框架

### Bootstrap4、Bootstrap5
框架官方文档：https://getbootstrap.com/docs/4.0/components/pagination/
```php
\think\facade\App::bind('think\Paginator', \hulang\thinkPaginatorDriver\Bootstrap::class);
```

### Layui
框架官方文档：https://layui.gitee.io/v2/docs/modules/laypage.html
```php
\think\facade\App::bind('think\Paginator', \hulang\thinkPaginatorDriver\Layui::class);
```

### Amaze UI
框架官方文档：https://amazeui.clouddeep.cn/css/pagination/
```php
\think\facade\App::bind('think\Paginator', \hulang\thinkPaginatorDriver\AmazeUI::class);
```

### Foundation
框架官方文档：https://foundation.zurb.com/sites/docs/pagination.html
```php
\think\facade\App::bind('think\Paginator', \hulang\thinkPaginatorDriver\Foundation::class);
```

