<?php

namespace App\Http\Controllers\Index;

use App\Models\Notes;
use Yao\{Http\Request};
use Yao\Facade\Db;

class Index
{

    public function __construct()
    {
        $this->notesModel = new Notes();
    }

    public function index($page = 1)
    {
        $notes = $this->notesModel->list(['id', 'title', 'text'], $page, 15);
        $hots = $this->notesModel->hots();
        return view('index/index', compact(['notes', 'hots']));
//        $file = Db::name('files')
//            ->field(['file', 'filename', 'md5'])
//            ->order(['id' => 'desc'])
//            ->select()
//            ->toArray();
//        foreach ($file as $k => $v) {
//            $filesize = file_exists($file[$k]['file'])
//                ? format_size(filesize($file[$k]['file']))
//                : 'Na';
//            $file[$k]['size'] = $filesize;
//            unset($file[$k]['file']);
//        }

//        return $file;
    }


    public function upload()
    {
    }

    public function todo()
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
