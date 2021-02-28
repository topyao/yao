<?php

namespace App\Http\Traits;

trait Paginate
{

    private function _paginate($page, $totalPage, $numberOfPages)
    {
        if ($page < 1 || $page > $totalPage) {
            exit(view('index/error', ['message' => '没有结果']));
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
        $pages[1] = '首页';
        $pages[$totalPage] = '尾页';
        ksort($pages);
        $paginate = '';
        $request = $this->request->get();
        foreach ($pages as $p => $name) {
            $query = '?p=' . $p;
            if (!empty($request)) {
                $request['p'] = $p;
                $query = '?' . http_build_query($request);
            }
            $paginate .= '<li><a href="' . $query . '">' . $name . '</a></li>';
        }
        return $paginate;
    }
}