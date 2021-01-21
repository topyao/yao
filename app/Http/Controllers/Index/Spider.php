<?php

namespace App\Http\Controllers\Index;

use Yao\Facade\Request;

class Spider
{

    protected $url;
    protected $keywords;
    protected $type;
    protected $rule;
    protected $notice = [];
    protected $return;


    public function index()
    {
        if (Request::isMethod('get')) {
            return view('index/spider');
        }

        $this->url = urldecode(Request::post('url'));
        $this->keywords = explode(',', Request::post('keywords'));
        $this->type = Request::post('type');
        $this->rule = Request::post('rule');
        $this->_spider();
        return !empty($this->notice) ? ['notice' => $this->notice, 'return' => $this->return] : [];
    }


    private function _spider()
    {
        $ch = curl_init();
        $options = [
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
        ];
        curl_setopt_array($ch, $options);
        foreach ($this->keywords as $keyword) {
            $url = str_replace(['{k}', '&amp;'], [$keyword, '&'], $this->url);
            curl_setopt($ch, CURLOPT_URL, $url);
            $this->return = curl_exec($ch);
            if ('except' == $this->type) {
                $pattern = '#' . $this->rule . '#iU';
                if (preg_match($pattern, $this->return, $matches)) {
                    if (empty($matches)) {
                        $this->notice[] = 'Warning:"' . $url . '",matched';
                    } else {
                        $this->notice[] = "{$url}中没有找到关键词{$keyword}!";
                    }
                }
            } else if ('contain' == $this->type) {
                $pattern = '#' . str_replace('{k}', $keyword, $this->rule) . '#iU';
                if (preg_match($pattern, $this->return, $matches)) {
                    if (empty($matches)) {
                        $this->notice[] = "{$url}中没有找到关键词{$keyword}!";
                    } else {
                        $this->notice[] = 'Warning:"' . $url . '",matched';
                    }
                }
            }
        }
        curl_close($ch);
    }
}
