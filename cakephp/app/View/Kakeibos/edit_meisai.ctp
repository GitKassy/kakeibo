<!--編集フォーム-->
<?php
    echo $this->Form->create('Kakeibo', array(
        'action' => 'addMeisai',
        'class' => 'cf',
    ));
    echo $this->Form->hidden('id');
    echo $this->Form->input('category', array(
       'div' => 'register_form',
       'options' => array(
            '食事' => '食事',
            '日用品' => '日用品',
            '本' => '本',
            '趣味' => '趣味',
            '服' => '服',
            '交通費' => '交通費',
            '光熱費' => '光熱費',
            '医療' => '医療',
        ),
    ));
    echo $this->Form->input('method', array(
        'div' => 'register_form',
        'options' => array(
        'cash' => '現金'
        ,'credit' => 'クレジットカード')
    ));
    echo $this->Form->input('money', array(
        'div' => 'register_form',
    ));
    echo $this->Form->submit('/img/obj_register.png', array(
        'div' => 'register_submit',
    ));
    echo $this->Form->end();
?>
