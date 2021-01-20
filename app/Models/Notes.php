<?php


namespace App\Models;


use Yao\Facade\Db;

class Notes
{
    protected $fields = [
        'title',
        'text',
        'create_time'
    ];


    private function _getData($data)
    {
        $processedData = [];
        foreach ($data as $key => $value) {
            if (in_array($key, $this->fields)) {
                $processedData[$key] = $value;
            } else {
                $processedData[$key] = '';
            }
        }
        return $processedData;
    }

    public function oneNote($id)
    {
        return Db::name('notes')->field($this->fields)->where(['id' => $id])->find()->toArray();
    }

    public function delete($id)
    {
        return Db::name('notes')->whereIn(['id' => $id])->delete();
    }

    public function insert($data)
    {
        $data = $this->_getData($data);
        return Db::name('notes')->insert($data);
    }

    public function list($fields = null)
    {
        $notes = Db::name('notes')->select()->toArray();
        return view('index/notes/list', ['notes' => $notes]);
    }

}