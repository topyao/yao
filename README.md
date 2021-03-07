# Yao
是一款基于PHP的简单轻量的MVC框架，视图和框架分离，还可以用作API开发，方便快速。

## 安装要求
> 因为使用了大量的变量类型声明或者返回类型声明来提高性能(官方号称可以提高3-4倍)，所以要求PHP版本大于等于7.4。

同时要求环境安装了以下扩展（如果你需要使用相应功能的话需要开启）
```
PDO扩展 （数据库操作）
MBString扩展 （验证器验证字符长度）
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

> 欢迎各位大佬参与开发 ，联系邮箱：bigyao@139.com

<a href="https://www.chengyao.xyz/document">开发文档</a>
