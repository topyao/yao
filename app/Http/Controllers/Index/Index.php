<?php

namespace App\Http\Controllers\Index;

use Yao\{Http\Request};
use Yao\Facade\Db;

class Index
{
    public function index(Request $request)
    {
        return view('index/index');
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
        return view('index/todo');
    }

    public function download(Request $request)
    {
        $file = Db::name('files')->where(['md5' => $request->get('hash')])->find();
        return File::download($file['filename'], $file['file']);
    }

    public function document()
    {
        return view('index/document');
    }


    public function login()
    {
        return view('index/login');
    }
}
