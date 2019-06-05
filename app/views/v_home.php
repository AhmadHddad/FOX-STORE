<?php include('includes\header.php'); ?>

<div id="content">
    <h2>
        All Products
    </h2>
    <ul class="alerts">
        <?php $this->get_alert(); ?>
    </ul>
     

    <ul class="products">
        <?php echo $this->get_data("prod_table"); ?>


    </ul>


</div>

<?php include('includes\footer.php');
