<?php


use Psr\Container\ContainerInterface;
use Yao\App;
use Yao\Config;
use Yao\Env;
use Yao\File;
use Yao\Traits\SingleInstance;

class Container implements ContainerInterface
{

    use SingleInstance;

    /**
     * 依赖注入的类实例
     * @var array
     */
    protected array $instances = [];
    /**
     * 当前实例化并调用方法的类名
     * @var $instance
     */
//    protected static $abstract;
    /**
     * 绑定的类名
     * @var array|string[]
     */
    protected array $bind = [
        'request' => \Yao\Http\Request::class,
        'validate' => \App\Http\Validate::class,
        'file' => File::class,
        'env' => Env::class,
        'config' => Config::class,
        'app' => App::class,
        'view' => Render::class,
        'route' => \Yao\Route::class
    ];

    public function get($abstract)
    {
        if ($this->has($abstract)) {
            return $this->instances[$abstract];
        }
        throw new \Exception('没有找到');
    }

    public function has($abstract)
    {
        return isset($this->instances[$abstract]);
    }


    /**
     * 获取绑定类名
     * @param $name
     * @return mixed|string
     */
    protected function _getBindClass(string $name): string
    {
        return $this->bind[strtolower($name)] ?? $name;
    }

    /**
     * 获取类对象，支持依赖注入
     * @param $abstract
     * 需要实例化的类
     * @param array $arguments
     * 给构造方法传递的参数
     * @param false $singleInstance
     * 为true表示单例
     * @return mixed
     * @throws \ReflectionException
     */
    public function make(string $abstract, array $arguments = [], bool $singleInstance = false)
    {
        $abstract = $this->_getBindClass($abstract);
        if (!isset($this->instances[$abstract]) || !$singleInstance) {
            $reflectionClass = new \ReflectionClass($abstract);
            if (null === ($constructor = $reflectionClass->getConstructor())) {
                $this->instances[$abstract] = new $abstract(...$arguments);
            } else if ($constructor->isPublic()) {
                $parameters = $constructor->getParameters();
                $injectClass = $this->_getInjectObject($parameters);
                $this->instances[$abstract] = new $abstract(...[...$arguments, ...$injectClass]);
            }
        }
        return $this->instances[$abstract];
    }


    /**
     * 调用类的方法
     * @param array $callable
     * 可调用的类和方法数组['className','methodName']
     * @param array $arguments
     * 给方法传递的参数
     * @param false $singleInstance
     * true表示单例
     * @param array $constructorParameters
     * 给构造方法传递的参数
     * @return mixed
     */
    public function invokeMethod(array $callable, array $arguments = [], bool $singleInstance = false, array $constructorParameters = [])
    {
        [$class, $method] = [$this->_getBindClass($callable[0]), $callable[1]];
        $this->make($class, $constructorParameters, $singleInstance);
        $parameters = (new \ReflectionClass($class))->getMethod($method)->getParameters();
        $injectClass = $this->_getInjectObject($parameters);
        return call_user_func_array([$this->instances[$class], $method], [...$arguments, ...$injectClass]);
    }


    /**
     * 通过参数列表获取注入对象数组
     * @param $parameters
     * @return array
     */
    protected function _getInjectObject(array $parameters)
    {
        $injectClass = [];
        foreach ($parameters as $parameter) {
            if (!is_null($class = $parameter->getClass())) {
                $className = $class->getName();
                $injectClass[] = new $className();
            }
        }
        return $injectClass;
    }


}