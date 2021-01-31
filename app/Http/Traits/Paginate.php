<?php

namespace App\Http\Traits;

trait Paginate{

    private function _paginate($page, $totalPage, $numberOfPages)
    {
        if ($page < 1 || $page > $totalPage) {
            return view('index/error');
        }
        $pages = [];
        for ($i = 1; $i >= 0; $i--) {
            if ($page - 1 - $i > 0) {
                $pages[$page - 1 - $i] = $page - 1 - $i;
            }
        }
        $pages[$page] = (int)$page;
        for ($i = 0; $i <= 1; $i++) {
            if ($page + 1 + $i <= $totalPage) {
                $pages[$page + 1 + $i] = $page + 1 + $i;
            }
        }
        $pages[key($pages)] = '首页';
        end($pages);
        $pages[key($pages)] = '尾页';
        $paginate = '';
        foreach ($pages as $page => $name) {
            $paginate .= '<li><a href="?p=' . $page . '">' . $name . '</a></li>';
        }
        return $paginate;
    }
}