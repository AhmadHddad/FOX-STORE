<?php
include('app\views\includes\header.php');
?>

<?php
if (!isset($_SESSION['username'])) : ?>
<script>
     let con=confirm('you must log in first, do you want to log in ?');
    con == true ? window.location.replace('/fox/login-reg.php') : window.location.replace('/fox');
    </script>



<style></style>
    <ul class="alerts">

        <?php $this->get_alert(); ?>
    </ul>

<div style="text-align: center"><a  class="loganchor" href="#">Log in ?</a></div>

<?php endif;


if (isset($_SESSION['username'])) :

    ?>
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

    <?php include('app\views\includes\footer.php');
endif ?>