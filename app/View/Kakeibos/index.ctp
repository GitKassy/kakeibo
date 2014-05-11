<?php if(!empty($errors)): ?>
<p><?php print $errors[0]; ?></p>
<?php endif; ?>

<?php

    echo $this->Form->create('Kakeibo', array(
        'action' => 'login',
        'class' => 'cf'
    ));
    echo $this->Form->input('user', array());
    echo $this->Form->input('password', array());
    echo $this->Form->submit('ログイン', array());
    echo $this->Form->end();

?>
