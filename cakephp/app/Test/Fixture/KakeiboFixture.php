<?php

class KakeiboFixture extends CakeTestFixture
{
    public $useDbConfig = 'test';
    public $table = 'meisai';
    public $fields = array(
        "id" => array('type' => 'integer', 'null' => false, 'key' => 'primary'),
        "pay_date" => array('type' => 'date', 'null' => false),
        "category" => array('type' => 'string', 'null' => false),
        "money" => array('type' => 'string', 'null' => false),
        "method" => array('type' => 'string', 'null' => false),
        "created" => 'datetime', 
        "modified" => 'datetime',
        "indexes" => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
        "tableParameters" => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'InnoDB')
    );

    public $records = array();
    public function __construct(){
        parent::__construct();
        for($i=1; $i<=5; $i++){
            $this->records[$i-1] = array(
                "id" => $i,
                "pay_date" => "2014-0{$i}-01",
                "category" => '食事',
                "money" => 100*$i,
                "method" => 'cash',
                "created" => '2014-04-01',
                "modified" => '2014-04-01',
            );
        }
        $this->records[5] = array(
            "id" => 6,
            "pay_date" => "2014-04-01",
            "category" => '交通費',
            "money" => 600,
            "method" => 'credit',
            "created" => '2014-04-01',
            "modified" => '2014-04-01',
        );
        $this->records[6] = array(
            "id" => 7,
            "pay_date" => "2014-04-01",
            "category" => '交通費',
            "money" => 700,
            "method" => 'cash',
            "created" => '2014-04-01',
            "modified" => '2014-04-01',
        );
        $this->records[7] = array(
            "id" => 8,
            "pay_date" => "2014-05-01",
            "category" => '交通費',
            "money" => 700,
            "method" => 'credit',
            "created" => '2014-04-01',
            "modified" => '2014-04-01',
        );
        $this->records[8] = array(
            "id" => 9,
            "pay_date" => "2014-04-01",
            "category" => '服',
            "money" => 700,
            "method" => 'credit',
            "created" => '2014-04-01',
            "modified" => '2014-04-01',
        );
    }
}
