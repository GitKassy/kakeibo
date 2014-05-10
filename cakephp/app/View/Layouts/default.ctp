<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>kassy's account book</title>
    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('kakeibo');
        echo $this->Html->css('normalize');
    ?>
</head>
<body>
<div id="wrapper">
    <header>
        <h1>kassy's account book</h1>
    </header>

   <div id="content" class="cf">
       <?php echo $this->fetch('content'); ?>

       <!--実装時は削除する-->
       <?php //echo $this->element('sql_dump'); ?>
   </div><!--content-->

    <div id="footer">
        <div id="copyright">Copyright&copy;kassy</div>
    </div>
<div><!--wrapper-->
</body>
</html>
