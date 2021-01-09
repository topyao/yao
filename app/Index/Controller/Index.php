<?php

namespace App\Index\Controller;

use Yao\{
    Facade\Db,
    Facade\File,
    Http\Request,
};


class Index
{
    public function index(Request $request)
    {
        $file = Db::name('files')->field(['file', 'filename', 'md5'])->order(['id' => 'desc'])->select()->toArray();
        foreach ($file as $k => $v) {
            $filesize = file_exists($file[$k]['file']) ? format_size(filesize($file[$k]['file'])) : 'Na';
            $file[$k]['size'] = $filesize;
            unset($file[$k]['file']);
        }

        return $file;
    }

    public function upload(Request $request)
    {
        dump($request);
    }

    public function todo()
    {
        return view('index@todo');
    }

    public function download(\Yao\Http\Request $request)
    {
        $file = Db::name('files')->where(['md5' => $request->get('hash')])->find();
        if (!empty($file)) {
            return File::download($file['filename'], $file['file']);
        } else {
            abort('文件找不到了!');
        }
    }

    public function test($id = 0)
    {
        return $id;
    }
}
