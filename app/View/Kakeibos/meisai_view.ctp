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
<!--明細-->
<table id="meisai_table">
    <tr>
        <th colspan="2"></th>
        <th>現金</th>
        <th>クレジット</th>
    </tr>
    <tr>
        <th><?php $this->Html->image("obj_calculator.png", array('alt' => "合計")); ?></th>
        <th>合計</th>
        <td class="meisai_data"><?php print array_sum(Hash::extract($cashRecords, "Meisai.{s}.{n}.money")); ?></th>
        <td class="meisai_data"><?php print array_sum(Hash::extract($creditRecords, "Meisai.{s}.{n}.money")); ?></td>
    </tr>
</table><!--meisai_table-->

<table id="meisai_table">
    <tr>
        <th>Date</th>
        <th colspan="2">Category</th>
        <th>支払金額</th>
        <th>支払方法</th>
        <th>編集</th>
    </tr>
    <?php foreach($records as $record): ?>
        <tr>
            <td class=""><?php print date('Y-m-d', strtotime($record['Kakeibo']['pay_date'])); ?></td>
            <td class="col_2"><?php echo $this->Html->image("obj_{$categories[$record['Kakeibo']['category']]}.png", array('alt' => "")); ?></td>
            <td class="col_3"><?php print $record['Kakeibo']['category']; ?></td>
            <td class="meisai_data"><?php print $record['Kakeibo']['money']; ?></td>
            <td><?php print $record['Kakeibo']['method']; ?></td>
            <td class="col_6">
                <?php echo $this->Html->link(
                    $this->Html->image('obj_register.png', array('alt' => '編集')),
                    array(
                        'controller' => 'Kakeibos',
                        'action' => 'editMeisai',
                        $record['Kakeibo']['id']
                    ),
                    array('escape' => false)); ?>
                <?php echo $this->Form->postLink(
                    $this->Html->image('obj_delete.png', array('alt' => '削除')), 
                    array(
                        'controller' => 'Kakeibos',
                        'action' => 'deleteMeisai',
                        $record['Kakeibo']['id']
                    ),
                    array('escape' => false, 'confirm' => '削除しますか')); ?>
                    
            </td>
        </tr>
    <?php endforeach; ?>
</table><!--meisai_table-->
