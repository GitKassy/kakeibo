<?php

    echo $this->Form->create('Meisai');
    echo $this->Form->input('category',array(
        'options' => array(
            '食事'
            ,'日用品'
            ,'本'
            ,'趣味'
            ,'服'
        )
    ));
    echo $this->Form->input('money');
    echo $this->Form->input('method', array(
        'options' => array('現金', 'クレジットカード')
    ));
    echo $this->Form->end('送信');
?>
