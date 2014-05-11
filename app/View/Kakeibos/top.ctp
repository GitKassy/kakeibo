<?php
    //----------------------------
    // default
    //----------------------------
    $categories = array(
        '食事' => 'food',
        '日用品' => 'groceries',
        '本' => 'book',
        '趣味' => 'hobby',
        '服' => 'cloth',
        '交通費' => 'transportation',
        '光熱費' => 'konetsuhi',
        '医療' => 'medicine',
    );
?>

<?php $this->start('main_menu'); ?>
        <ul id="main_menu" class="cf">
            <li><?php print $this->Html->link('ホーム', array(
                    'controller' => 'kakeibos',
                    'action' => 'top',
                )); ?>
            </li>
            <li><?php print $this->Html->link('明細', array(
                'controller' => 'kakeibos',
                'action' => 'meisaiView',
                )); ?>
            </li>
            <li>グラフ</li>
        </ul>
<?php $this->end(); ?>

<?php $this->start('register_form'); ?>
<!--登録フォーム-->
<?php
    echo $this->Form->create('Kakeibo', array(
        'action' => 'addMeisai',
        'class' => 'cf',
    ));
    echo $this->Form->hidden('pay_date', array('value' => strftime('%F')));
    echo $this->Form->input('category', array(
       'div' => 'register_form col_1',
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
        'div' => 'register_form col_2',
        'options' => array(
            'cash' => '現金',
            'credit' => 'クレジットカード',
        ),
    ));
    echo $this->Form->input('money', array(
        'div' => 'register_form col_3',
    ));
    echo $this->Form->submit('obj_register.png', array(
        'div' => 'register_submit col_4',
    ));
    echo $this->Form->end();
?>
<?php $this->end(); ?>

<?php $this->start('top_table'); ?>
<!--一覧-->
<table id="top_table">
    <tr>
        <th colspan="2"></th>
        <th class="col_3">現金</th>
        <th class="col_4">クレジット</th>
    </tr>
    <tr>
        <th class="col_1">
            <?php echo $this->Html->image('obj_calculator.png', array('alt' => '合計')); ?>
        </th>
        <th class="col_2"><span>合計</span></th>
        <td class="meisai_data col_3"><?php print array_sum(Hash::extract($cashRecords, "Meisai.{s}.{n}.money")); ?></td>
        <td class="meisai_data col_4"><?php print array_sum(Hash::extract($creditRecords, "Meisai.{s}.{n}.money")); ?></td>
    </tr>
    <?php foreach($categories as $categoryKey => $category): ?>
    <tr>
        <th class="col_1">
            <?php echo $this->Html->image("obj_{$category}.png", array('alt' => "{$categoryKey}")); ?>
        </th>
        <th class="col_2"><span><?php print $categoryKey; ?></span></th>
        <td class="meisai_data col_3"><?php print array_sum(Hash::extract($cashRecords, "Meisai.{$categoryKey}.{n}.money")); ?></td>
        <td class="meisai_data col_4"><?php print array_sum(Hash::extract($creditRecords, "Meisai.{$categoryKey}.{n}.money")); ?></td>
    </tr>
    <?php endforeach; ?>
</table><!--top_table-->
<?php $this->end(); ?>

<?php
    echo $this->fetch('register_form');
    echo $this->fetch('main_menu');
    echo $this->fetch('top_table');
?>
