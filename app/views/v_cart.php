<?php include('app\views\includes\header.php'); ?>




<div id="content">
    <h2>Shopping Cart</h2>
    <ul class="alerts">
        <?php $this->get_alert(); ?>
    </ul>

    <form action="" method="post">
        <ul class="cart">
            <?php $this->get_data('cart_rows'); ?>
        </ul>

        <div class="buttons_row"><br><br>
            <a class="button_alt" href="?empty">Empty Cart</a>
            <input type="submit" name="update" class="button_alt" value="Update Cart">
        </div>
    </form>

    <?php $items = $this->get_data('cart_total_items', false);
    if ($items > 0) { ?>
        <form action="checkout.php" method="post">
            <div class="submit_row">
                <input type="submit" name="submit" class="button" value="Pay with Paypal">
            <?php } ?>
        </div>
    </form>
</div>

<?php include('app\views\includes\footer.php'); ?>