<?php

namespace App\Http\Controllers\Index;

use App\Http\Controller;
use Yao\Http\Request;

class Index extends Controller
{
    public function index(Request $request)
    {
        echo <<<EOT
<title>Welcome !</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<div style="height: 60vh;border:1px solid #d4d4d4;margin:19vh 10vw">
    <div style="background-color: #1E90FF;line-height:3em;padding:0 1em;height: 3em;color: white;font-weight: bold">Welcome!</div>
<div style="text-align: center;display: flex;justify-content: center;"><p>我比较懒，这里还没有写</p></div>

</div>
EOT;

//        abort('可以开始了！', 200);
    }

    public function test()
    {
        dump($this->request);
    }

    public function check()
    {
        $this->validate();
        dump($this->app->get('request'));
    }
}
