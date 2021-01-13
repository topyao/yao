<?php

namespace App\Index\Controller;

use Yao\{Facade\Db, Facade\File, Http\Request};

class Index
{
    public function index(Request $request)
    {
        return view('index@index');
        $file = Db::name('files')
            ->field(['file', 'filename', 'md5'])
            ->order(['id' => 'desc'])
            ->select()
            ->toArray();
        foreach ($file as $k => $v) {
            $filesize = file_exists($file[$k]['file'])
                ? format_size(filesize($file[$k]['file']))
                : 'Na';
            $file[$k]['size'] = $filesize;
            unset($file[$k]['file']);
        }

        return $file;
    }

    public function upload()
    {
    }

    public function todo(Request $request)
    {
        dump($request->get());
    }

    public function download(Request $request)
    {
        $file = Db::name('files')->where(['md5' => $request->get('hash')])->find();
        return File::download($file['filename'], $file['file']);
    }

    public function test()
    {

    }
}
