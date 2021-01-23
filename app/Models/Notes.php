<?php


namespace App\Models;


use Yao\Facade\Db;

class Notes
{
    protected $fields = [
        'title',
        'text',
        'tags',
        'create_time',
        'hits'
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
        $note = Db::name('notes')->field($this->fields)->where(['id' => $id])->find()->toArray();
        Db::name('notes')->where(['id' => $id])->update(['hits' => $note['hits'] + 1]);
        return $note;
    }


    public function hots($limit = 8)
    {
        return Db::name('notes')
            ->field(['title', 'id'])
            ->order(['hits' => 'desc'])
            ->limit($limit)
            ->select()
            ->toArray();
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

    public function update($id, $data)
    {
        return Db::name('notes')->where(['id' => $id])->update($data);
    }

    public function list($fields, $page, $limit)
    {
        return Db::name('notes')
            ->field([...$fields,'EXTRACT(DAY FROM create_time) AS days'])
            ->order(['update_time' => 'DESC', 'days' => 'DESC'])
            ->limit(($page - 1) * $limit, $limit)
            ->select()
            ->toArray();
    }

}