<?php

class User extends AppModel{
    public $validate = array(
        'username' => array(
            'required' => array(
                'rule' => array('notEmpty')
                ,'message' => 'ユーザー名を入力してください'
            )
        )
        ,'password' => array(
            'required' => array(
                'rule' => array('notEmpty')
                ,'message' => 'パスワードを入力してください'
            )
        )
        ,'role' => array(
                'rule' => array('inList', array('admin', 'author') )
                ,'message' => 'Please enter a valid role'
                ,'allowEmpty' => false
        )
    );

}
