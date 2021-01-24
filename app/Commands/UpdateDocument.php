<?php


namespace App\Commands;


use Yao\Console\Command;

class UpdateDocument extends Command
{
    public function out()
    {
        return $this->run();
    }

    public function run()
    {
        $lock = __DIR__ . DIRECTORY_SEPARATOR . 'lock';

        if (!file_exists($lock)) {
            touch($lock);
        } else {
            exit('脚本正在执行!');
        }

        passthru('git pull https://github.com/topyao/yao.git /home');

        $data = file_get_contents('https://github.com/topyao/yao/blob/master/README.md');

        if (false == $data) {
            exit('文档获取失败！');
        } else {
            \Yao\Facade\Db::name('notes')
                ->where(['id' => 125])
                ->update(['text' => $data]);
        }

    }


}