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
git clone https://github.com/topyao/yao.git . && php yao serve
```

你也可以直接在项目目录更新依赖

```
composer install
```

安装完成后就可以使用 `php yao serve` 运行程序。框架强制路由，所以在编写控制器前应该先定义路由规则，如果你的环境是`windows`需要修改`public/.htaccess`中的`RewriteRule`或者`nginx`伪静态规则，在`index.php`后面加上`?`。框架对数据类型比较敏感，例如在该设置为`true`时候不要设置`1`。否则会报错。

> 如果你安装的是开发版本，安装完成后可能需要手动删除`vendor/chengyao`下的包中的`.git`文件夹。强烈不建议使用开发版本

## 2.伪静态

下面提供了`apache`和`nginx`的伪静态配置

>apache

```
<IfModule mod_rewrite.c>
  Options +FollowSymlinks -Multiviews
  RewriteEngine On
  RewriteCond %{REQUEST_FILENAME} !-d
  RewriteCond %{REQUEST_FILENAME} !-f
  RewriteRule ^(.*)$ index.php/$1 [QSA,PT,L]
</IfModule>
```

>nginx 

```
if (!-d $request_filename){
	set $rule_0 1$rule_0;
}
if (!-f $request_filename){
	set $rule_0 2$rule_0;
}
if ($rule_0 = "21"){
	rewrite ^/(.*)$ /index.php/$1 last;
}
```

# 目录结构
- app  应用目录
  - Http
    - Controllers  控制器目录
    - Middleware 中间件目录
    - Validate 验证器目录
    - Controller.php 基础控制器类
    - Provider.php 服务注册类
    - Validate.php 验证器类
  - Models 模型目录
  - Services 服务目录
  - Facade 用户自定义门面目录
  - common.php 用户自定义函数文件
- config 配置文件目录
  - app.php 应用配置文件
  - database.php 数据库配置文件
  - view.php 视图配置文件
- extend 扩展类库目录【命名空间为\\】
- public 应用访问目录
  - .htaccess apache伪静态文件
  - nginx.conf nginx伪静态文件
  - index.php 入口文件
- routes 路由目录
  - web.php	路由文件
- vendor 扩展包（包含框架核心）
- views 视图目录
- .env 环境变量文件
- .example.env 环境变量示例文件
- .htaccess 伪静态文件
- composer.json composer配置文件
- composer.lock composer锁定文件
- LICENSE 开源许可证
- README.md 手册
- yao 命令行文件

> 框架对单/多应用这个概念比较模糊，只是在定义路由和渲染模板的时候应该有所注意，这里在下面的章节中会提到。

# 配置

配置文件包含两种，一种是`config`目录下的以小写字母开头的`.php`为后缀的文件，另一种是框架根目录下的`.env`文件，下面简单介绍下如何使用他们。

## ENV
在开发环境下大多数配置都可以通过`.env`文件获取，而且默认为从`.env`文件获取，线上环境需要删除`.env`文件或者将配置中的`env`去掉，例如在`app.php`中有这样`'debug' => env('app.debug', false),`一个配置，我们可以更改为`'debug' => false,`
.env文件可以使用节，例如：

```
[APP]
DEBUG=true #开启调试
AUTO_START=true 
```
其中app就是一节，获取`DEBUG`配置可以使用`env('app.debug')`或者`\Yao\Facade\Env::get('app.debug');`

## config
配置文件是位于`config`目录下，以`.php`结尾的返回一个关联数组的文件。

获取所有配置使用

```php
\Yao\Facade\Config::get();
```

可以传入一个参数例如`app`,则会获取`app.php`文件中的配置，传入`app.auto_start` 则获取`app`中的`auto_start`参数的值

如果需要自定义一个配置文件，可以在`/config`目录下新建例如`alipay.php`文件并返回一个数组。

```php
\Yao\Facade\Config::load('alipay');         //加载配置（一次请求只需要加载一次）
\Yao\Facade\Config::get('alipay.param');	   //获取配置
```

>可以使用辅助函数`config()` ，例如`config('app.debug')`


# 路由
路由可以添加在`route/route.php`文件中，如果需要分文件存放，只需要在route目录下新建文件

> 注意：需要引入`Yao\Facade\Route`类

## 路由定义

路由的定义方式有三种：字符串，数组，闭包

路由定义需要设置请求方式例如

```php
Route::get('路由地址','路由表达式');   //get方式请求的路由  
Route::post('路由地址','路由表达式');  //post方式请求的路由
```

请求方式可以是`get,post,put,delete,patch`等请求类型,以下非特殊都是用`get`做演示，这里的路由地址是不包含`queryString`的，即使`url`中有`queryString`,也会匹配该路由。

### 字符串

当我们使用单应用模式的时候，按照下面的方法定义路由

```php
Route::get('路由地址','控制器/方法');
```
例如
```php
Route::get('index','index/index'); 
```

这里的`index/index`中最后一个斜线后的字符串为调用的方法名，前面的组成类似`App\Http\Controllers\Index`的类名,对应到目录中为`/app/Http/Controllers/index.php` 这样就很容易理解如何创建单/多应用。只需给路由表达式添加多个斜线分割，对应于类所处的文件夹上下级。

### 数组

使用数组的方式定义路由，数组的第一个参数必须是一个控制器类的完整类名，第二个参数为方法名字符串，例如

```php
Route::get('index',['\App\Http\Controllers\Index','index']);
```

表示映射到`\App\Http\Controllers\Index`控制器的`index`方法

### 闭包

```php
Route::get('index',function(){
       return view('模板文件');
});
```

> 注意：这里使用到了view助手函数，当路由地址中含有参数时可以给闭包函数传递相应参数，在下面会提到。

## 路由高级

### 多请求类型路由

当我们一个url需要多种请求方式来访问的时候可以定义`rule`类型的路由，例如：（这里的/非必须，但是建议加上）

```php
Route::rule('/', 'index/index/index', ['get', 'post']);
```

第三个参数传入请求方式数组，可以为空，为空默认为`get`和`post`

### 正则表达式与参数传递

在上面提到了路由是可以给控制器方法或者闭包传递参数的。

例如我定义了一个如下的路由

```php
Route::get('/article/index(\d+)\.html', 'index/article/read');
```

该路由的第一个参数是一个不带定界符的正则表达式，该表达式会匹配`/article/任意数字.html`的请求地址，这个正则中使用了一个匹配组`(\d+)`,并且这个组是第一次出现的，那么就可以在控制器方法或者闭包中传入一个参数。

> 给闭包传参

```php
Route::get('/article/index(\d*)\.html',function($id = 0){
	echo $id;
});
```

> 给控制器方法传参

```php
public function read($id = 0){
	echo $id;
}
```

可以传入多个参数,传入顺序按照`preg_match`之后的`match`数组去掉第一个之后的顺序传入,，例如：

```php
Route::get('/(\w+)-index(\d+)\.html',function($a,$b){
	echo $a,$b;
});
```

访问`blog-index2.html` 时会输出`blog` 和 `2`

> 注意：正则路由中的正则不需要添加定界符，多个参数是按匹配到的顺序传递的。转义符号务必使用反斜线，否则url助手函数可能不能正确获取到正则路由的地址

## 路由支持注册别名，例如
```
Route::get('/','index/index/index')->alias('index');
```

之后就可以在任意位置使用url助手函数获取路由地址，例如url('index') 返回'/'，如果url() 函数中传入的参数并没有被注册别名，那么会原样返回。url函数可以添加第二个参数来给正则路由传递参数，例如
```
Route::get('/b(.*)\.html','index/index/index')->alias('blog');
```

此时可以使用`url('blog',[1]);` 生成的`url`地址为`/b1.html` ，这里`url`的第二个参数为一个索引数组，参数按照在数组中的顺序传递。

## 路由可以设置缓存
```shell
php yao route   //根据提示选择选项
```

设置缓存文件后路由不会再通过调用/route下文件中的大量方法来注册，而是直接从缓存文件中读取，所以在开发环境上建议不要使用路由缓存，否则新增或删除路由不能及时更新

## 其他规则路由

**未匹配到路由**

使用

```php
Route::none(function(){},$data = []);
```
创建一个none路由，当所有路由未匹配到时会匹配该路由，需要给第一个参数传入一个闭包，第二个参数可选地传入一个索引数组，数组的每一个值都会按照数组的索引顺序传入闭包中，闭包中需要有相应形参或其他方式来获取传值。

**可以直接定义视图路由**，

```php
Route::view('index','index/index',['get']);
```

该路由表示`get`方式请求的`/index`会被映射到`views`目录下的`index`目录下的`index.html`模板文件,分隔符后最后的部分为模板文件名，前面均为目录名。最后一个参数为可选参数，为空默认为`get`方式请求的路由；

**可以定义重定向路由**

```php
Route::redirect('index','https://www.1kmb.com',['get'],302);
```

该路由表示`get`方式请求的`/index`会被重定向到`https://www.1kmb.com`。后两个参数为可选参数，第一个为路由请求方式，默认为`get`；第二个为响应状态码，默认为302；

## 跨域支持【开发中】

可以在定义路由的时候设置允许跨域【0.0.7版本的跨域功能勉强可以用，现在估计用不成了，没测试】
```
Route::get('/','index/index/index')->cors('*'); 
```

# 请求
## 获取请求参数
获取请求可以用Facade 

```php
\Yao\Facade\Request::get()
```

如果需要获取某一个参数，可以使用

```php
\Yao\Facade\Request::get('a');
```
可以给第二个参数传入一个默认值，例如

```php
\Yao\Facade\Request::get('a','default');
```

获取多个参数可以使用

```php
\Yao\Facade\Request::get(['a','b']);
```
可以给第二个参数传入一个索引数组的默认值，例如
```php
\Yao\Facade\Request::get(['a','b'],[1,'time']);
```
此时如果b不存在，则b的值为time

获取`post`请求的内容

```php
\Yao\Facade\Request::post();
```

获取所有`$_REQUEST`使用

```php
\Yao\Facade\Request::param();
```

>post和param使用方法和get一样。可以给这些方法添加第二个参数，第一个参数为字符串且不存在的时候会返回默认参数

## 获取$_SETVER 变量
替代地，可以使用Request::server($name) 获取$_SERVER中的值，如果不存在返回null

## 获取`header`
可以使用Request::header(); 获取所有header信息，可以传入一个参数，例如Request::header('user_agent');获取UA

## 判断请求类型
使用`isMethod`方法判断任何请求类型，例如判断请求类型是否为get
```php
\Yao\Facade\Request::isMethod('get');
```

还可以判断是否是`ajax`请求
```php
\Yao\Facade\Request::isAjax() 
```

## 参数过滤
请求是可以设置函数进行过滤的，可以在`app.php`中的`filter`数组中添加过滤函数，注意函数必须只能传入一个参数，并且返回过滤后的字符串。如果使用`Request`类获取参数默认是被过滤的。不需要过滤可以使用`$_GET`数组。

注意：如果需要获取的参数不存在，该参数的值将会是null，例如`Request::get(['a','b'])`当b不存在的时候会是`null`，此时需要用`is_null`判断。

# 中间件
支持控制器和路由前置后置中间件

首先需要创建一个中间件，例如

```php
<?php

namespace App\Http\Middleware;

use Yao\Facade\Session;

class Login
{
    public function handle($request, \Closure $next)
    {
        if(!Session::get('user')){
            return view('index/404');
        }
        $response = $next($request);
        echo '执行完了';
        return $response;
    }
}
```
# 控制器中间件
在控制器中添加属性

```php
    public $middleware = [
        'edit' => \App\Http\Middleware\Login::class,
    ];
```
表示控制器中的方法edit会使用Login中间件

在这个请求中如果获取不到session中的user，就会渲染视图404，不会向下执行，如果可以获取user，那么向下执行，执行控制器方法，执行完毕后再输出'执行完了'

## 路由中间件
可以使用middleware方法注册一个路由中间件，例如

Route::get('index','index/index')->middleware('\App\Http\Middleware\Login::class);

不管路由中注册的是闭包还是类名，都会经过中间件，目前路由中间件优先于控制器中间件，且只可以添加一个😂😂😂😂😂😂😂。

# 响应

在控制器中可以直接return 一个数组，框架会自动转为json输出，也可以使用json() 助手函数，或者response()函数,，例如json(array $data,202,['Content-Type:application/json']); 第一个参数为数据，第二个为状态码，第三个为头信息。

# 验证器

>需要验证的数据必须是数组，比如通过Request类方法传入数组获取的数组。

## 控制器验证
```
public function test()
   {
       $data = Request::post();
       $vali = Yao\Facade\Validate::rule([
           'username' => ['required' => true, 'max' => 10, 'regexp' => '\w+']
       ])->check($data);
       if (true !== $vali) {
           exit($vali);
       }
   }
```
验证器操作必须按照如上代码写，可以在`App\Validate`类中添加方法例如`_checkUservali`，验证成功返回true，失败将消息新增到成员属性$message数组后返回false。之后使用rule方法的时候就可以使用rule(['username' => ['uservali' => 1]);验证username字段。当一个字段验证失败后就不会再验证其他字段了！
验证器支持全部验证，只需要给check方法的第二个参数传入true即可开启全部验证，非批量验证失败返回消息字符串，批量验证失败返回消息索引数组。

> 默认可用的验证器有max,min,length,enum,required,regexp,bool,confirm

`_checkBool` 当值为`'on', 'yes', 'true', true, 1, '1'`时为真，相反为假，在验证规则中应该传入true或者false
在验证`regexp`的时候需要编写完整验证正则表达式包括定界符，例如：`/\d+@\w+\.\w{3}/i` 注意这里验证使用了`preg_match`，所以在编写正则表达式的时候应该注意，例如不要使用模式修正符g

## 独立验证
添加了独立验证，你可以在任何可以`composer`自动加载的位置添加验证器类例如`UserVali`，并继承`App\Validate`，在该类中添加验证规则$rule

```
 protected array $rule = [
        'username' => ['required' => true]
    ];
```
如果你继承了基础控制器，就可以使用下面的方法进行数据验证

```php
$res = $this->validate(UserVali::class,$data);
```

第一个参数为需要验证的数据，第二个参数为验证器类名完整字符串，注意这里追加的规则时使用`+`语法将两个数组合并，可能导致覆盖，独立验证可以设置属性$checkAll用来设置是否是全部验证,当`$checkAll`为true时开启批量验证，否则一旦有验证失败的条目都会结束验证。独立验证可以使用连贯操作和追加删除操作，例如

```php
$vali = $this->validate(UserVali::class,$data)->min(['a' => 1])->remove(['password' => ['required']])->append(['password' => ['min' => 1]])->check();
```

验证器随意增加或者删除验证规则,例如：
```php
Validate::rule(['a' => ['required' => true])->append(['a' => ['max' => 2,'min' => 1]])->append(['b' => ['required' => true])->remove('a')->remove(['a' => ['required','max'])->remove(['a' => 'min'])->check($data);
```


## 验证器还可以使用连贯操作
```php
$vali = Validate::data($data)->max(['a' => 10])->required(['a' => true,'b' => true)->check();
```
或者使用
```php
(new Validate($data))->max('a',10)->check();
```

或者使用
```php
(new Validate())->max('a',10)->check($data);
```

注意：这的`Validate`可以是任意你新建的继承了`App\Validate`或者`\Yao\Validate`的类，只是前者会包含你自定义的验证规则，后则会不包含，并且如果在你的验证器类中存在rule属性的设置就不再需要传入rule规则了，直接使用check即可。如果验证成功会返回true，否则返回带有错误信息的数组，使用闭包验证时func方法第一个参数传入要验证的字段，第二个参数传入闭包，第三个参数可选传入传递给闭包的参数列表数组。

## 验证提示
可以自定义验证规则的提示，只需要给属性notice设置和验证规则类似的数组，并且将验证的限定值改为提示信息即可。

> 验证器支持设置验证失败抛出异常，只需将独立验证的属性throwAble设置为true，或者给check方法传入第三个参数true，即可开启抛出异常，批量验证失败抛出异常信息为json。


# 控制器
假如我定义了以下路由

```php
Route::get('/','index/index/index');
```


如果需要编写控制器代码，就需要编写`/app/Http/Controllers/Index`目录下的`Index.php`控制器里的`index`方法

控制器的基本代码如下：
```
<?php

namespace App\Http\Controllers\Index;

class Index
{
    public function index()
    {
    }
}
```
> 控制器可以继承\App\Http\Controller 基础控制器来使用基础控制器中提供的方法，你也可以自定义基础控制器

>可以给控制器方法传入参数，参数个数和位置取决于路由中正则匹配到的参数。
>当路由中的参数为可选，就应该给控制器参数一个初始值

# 模型

模型的目录在app\Models下，新建模型继承Yao\Model类即可使用模型提供的方法。模型名为表名，也可以在模型中设置name属性，此时的表名就是name的值。
例如我新建了一个Notes的模型，可以在模型中直接使用
$this->where(['name' => 'cheng'])->select() 
进行查询

# 视图
### 使用内置模板驱动
模板引擎可以使用twig或者smarty，可以在config/view.php中设置模板引擎。
> 注意：需要手动改安装对应模板引擎；

视图目录位于根项目目录下views文件夹，可以使用助手函数渲染模板
```php
view('index/index');
```
这里的第一个参数和控制器解析规则类似，表示/views/index/index.html 模板文件，这里的模板后缀可以在`/config/view`中修改`suffix` 选项

模板渲染方法可以传入第二个数组参数用来给模板赋值，例如
```php
view('index',['data'=>$data]);
```

或者使用`Facade`

```php
\Yao\Facade\View::render('index',$params);
```

> 你可以使用composer安装你喜欢的模板引擎

### 自定义驱动
框架允许你自定义任何视图驱动，可以在任何可以composer自动加载的位置定义视图驱动，并且在视图配置view.php中将type和视图配置名改为你的视图驱动完整类名。

视图驱动需要继承\Yao\View\Driver.php 并且实现public function render($params){}方法。继承该类后可以使用$this->template 获取需要渲染的模板文件名。使用方法可以参考内置的视图驱动。

# Facade(类静态代理)

facade基本代码示例如下：
```
<?php

namespace App\Index\facade;

use Yao\Facade;

class UserCheck extends Facade
{
    protected static function getFacadeClass()
    {
        return \App\Index\validate\UserCheck::class;
    }

}
```

> 你可以在任何可以composer自动加载的位置创建独立验证器类并继承Yao\Facade类，就可以实现静态代理，但是为了方便维护，建议创建在应用对应的facade目录下。

>注意: Facade默认实例化对象都不是单例的。如果需要使用单例，可以加入`protected static $singleInstance = true;`，当然仅仅是在你的请求的页面中使用该类的方法全部为facade的时候才是单例的。

# 数据库

支持mysql，pgsql

很遗憾，由于本人技术有限，目前的`Db`类只对`mysql`支持良好，其他数据库暂时没有测试。如果有需求可以使用`composer`安装第三方的数据库操作类，例如：`medoo`，`thinkorm`

## 新增
```php
db('users')->insert(['name' => 'username','age' => 28]);
```

## 删除
```php
db('users')->where(['id' => 1])->delete();
```

## 查询
```php
\Yao\Facade\Db::name('表名')->field('字段')->where(['条件'])->limit(1,3)->find()/select();
```

查询到的是数据集对象，可以使用`toArray`或者`toJson`获取，例如

```php
\Yao\Facade\Db::name('users')->limit(1)->select()->toArray();
```

可以使用`value($fiels);` 获取某一个字段的值

## 更新

```php
db('users')->where('id > 10')->update(['name' => 'zhangsan']);
```

其中`field`默认为`*`，`where`可以传入字符串或者一维数组，`find`查询一条，`select`查询所有。`limit`可以传入1到2个参数，对应`mysql`的`limit`。目前只对`where`条件做了预处理

例如我可以写如下语句
```php
\Yao\Facade\Db::name('users')->field('username')->where(['age' => 19])->limit(1,2)->select();
```

表示我要查询users表中年龄为19的用户名，并且取出偏移量为2，限制条数为1的用户名。
当然可以使用`\yao\Facade\Db::name('users')->select()` 查询全部
可以使用助手函数例如：`db($tableName)->select();`

添加`whereLike(array $array)` 需要传入一个数组，数组的键为字段名，数组的值为模糊匹配值，例如%name%

```php
whereLike(['a' => '%time%','b' => '%b%'])
```

添加`whereIn(array $array)` 需要传入一个数组，数组的键为字段名，数组的值范围数组，例如

```php
whereIn(['a' => ['1','4'],'b' => ['c','d'])
```

当然我们更方便地使用`exec`和`query`两个方法来操作数据库，一般`query`是对应于查询，`exec`用来增加删改。使用方法如下:
`Db::exec($sql,$data)`，其中sql可以是预处理语句，需要绑定的数据传入`data`，可以使用?占位符和:占位符,返回值为前一条语句影响的条数
`Db::query($sql,$data，$all)` 前两个参数和`exec`是一致的，第三个参数为true时查询出全部数据(默认)，为false时查询出单条数据。
例如

```php
Db::query('SELECT * from users where id > :id',['id' => 1],true);
```

表示查询出所有id大于1的用户信息
```php
Db::exec('UPDATE users SET name=? where id = ?',['zhangsan',1]);
```

修改id为1的用户的名字为张三

## 删除
```php
\Yao\Facade\Db::name('users')->where('id > 10')->delete();
```

删除id大于10的用户。
> 注意：你可以自行安装`medoo`，`think-orm`等数据库操作类库或者使用自带的Db类,该Db类的操作方法大部分需要的是数组类型的参数。


# 服务

服务实现基本代码如下
```
<?php

namespace App\Index\Services;

class Serve implements
{
	public function register(){}
    public function boot()
    {
        echo '1';
    }
}
```

# 容器
可以使用容器创建类并调用类的方法
## 使用容器实例化类，并实现依赖注入
```php
$obj = \Yao\App::make(ClassName::class,array $arguments = [],$singleInstance = false);
```
第一个参数传入一个完整类名，第二个参数是传递给类构造方法的参数列表数组，第三个参数为true时候表示获取一个单例，在后面请求中获取类实例的$singleInstance 为true的时候始终不会创建新对象，而是从容器中获取已经实例化并且依赖注入的对象。
> 此时$obj是一个给构造方法实现依赖注入的实例，在后面的调用实例的方法时候并不会给方法实现依赖注入


## 使用容器调用实例的方法并实现依赖注入
```php
\Yao\App::invokeMethod(['className','method'],$arguments = [],$singleInstance = false,$constructorArguments = []);
```
第一个参数为一个数组，数组的第一个元素为需要实例化的类名，第二个元素为要调用的方法名。第二个参数为给方法传递的参数列表，第三个方法表示实例化的类是不是单例的，第四个参数为实例化类过程中给构造方法传递的参数列表


# 命令操作

框架提供了不丰富的命令操作，目前支持路由列表，路由缓存，启动内置服务等操作；只需要在项目目录下打开命令窗口输入以下指令就可以方便地进行各种操作。

```shell
php yao        //所有命令的帮助
php yao serve  //会提示输入一个端口来创建服务，默认为8080
php yao route  //会提示输出列表或者路由缓存操作，根据提示输入数字即可
```

> 如果你的项目根目录没有`yao` 文件，则需要在`git`上下载相应框架版本的`yao`文件



### 联系邮箱:`bigyao@139.com`，感谢：`https://www.jetbrains.com/?from=topyao`