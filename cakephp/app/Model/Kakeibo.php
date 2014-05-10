<?php

App::uses('KakeiboBehavior', 'Model/Behavior');

class Kakeibo extends AppModel
{
    /**
     *使用するテーブル
     */
    public $useTable = "meisai";
    
    /**
     *使用するビヘイビア
     */
    public $actsAs = array('Kakeibo');

    public $validate = array(
        'category' => array(
            'rule' => 'notEmpty'
        )
        ,'money' => array(
            'rule' => array('numeric','notEmpty')
        )
        ,'method' => array(
            'rule' => 'notEmpty'
        )
    );
}
