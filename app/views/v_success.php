<?php 

include('app\views\includes\header.php');
?>
<div id="content">
    <h2><?php $this->get_data('page_title'); ?></h2>
    <p> Thanks! <strong><?php $this->get_data('name'); ?></strong>,We appreciate your purchase. have a good day :D </p>
    <a href=<?php echo SITE_PATH ?>>Home</a>
</div>

<?php include('app\views\includes\footer.php'); ?>