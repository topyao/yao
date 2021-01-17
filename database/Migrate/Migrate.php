<?php


namespace Yao\Database\Migrate;


class Migrate extends \Yao\Migrate\Migrate
{
    public function createTable()
    {
        $this->table('uers')
            ->addColumn('username', 'varchar(10)')
            ->addColumn('password', 'int');
    }
}