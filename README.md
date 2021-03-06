# 安装

## 要求
```
PHP >= 7.4
PDO扩展
MBString扩展
```

## 使用composer安装：

```shell
composer create-project chengyao/yao .
```

这行命令会在你命令执行目录安装框架

> 你可以使用Git安装，安装完成后会自动启动服务

```
git clone https://github.com/topyao/yao.git . ; php yao serve
```

你也可以直接在项目目录更新依赖

```
composer install
```

安装完成后就可以使用 `php yao serve` 运行程序。框架强制路由，所以在编写控制器前应该先定义路由规则，如果你的环境是`windows`需要修改`public/.htaccess`中的`RewriteRule`或者`nginx`伪静态规则，在`index.php`后面加上`?`。框架对数据类型比较敏感，例如在该设置为`true`时候不要设置`1`。否则会报错。

> 如果你安装的是开发版本，安装完成后可能需要手动删除`vendor/chengyao`下的包中的`.git`文件夹。强烈不建议使用开发版本


<a href="https://www.chengyao.xyz/document">开发文档</a>
