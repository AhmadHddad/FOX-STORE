<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="resources\css\style.css">
    <title><?php $this->get_data("Page Title"); ?></title>
</head>

<body class=<?php $this->get_data('page_class'); ?>>
    <div class="wrapper">
        <div class="secondarynav">

            <?php if (isset($_SESSION['username'])) : ?>
                <strong> <?php

                            $items = $this->get_data('cart_total_items', false);

                            $price  = $this->get_data('cart_total_cost', false);
                            if ($items == 1) {
                                echo "(" . $items . ") item ";
                            } elseif ($items == 0) {
                                echo "No items ";
                            } elseif ($items > 1) {
                                echo "(" . $items . ") items ";
                            } ?>in cart <?php echo "$" . $price  ?></strong> &nbsp; | &nbsp;
                <a href="<?php SITE_NAME; ?> cart.php"> Shopping cart</a> &nbsp; | &nbsp;
                  <a href="<?php SITE_NAME; ?>?logout">Log Out</a>
            <?php endif;
        if (!isset($_SESSION['username'])) : ?>
                <a href="<?php SITE_NAME; ?> login-reg.php">Login</a>
            <?php endif; ?>
        </div>
        <h1><a id="maintitle" href="<?php echo SITE_PATH ?>"><?php echo SITE_NAME ?></a></h1>

        <ul class="nav">
            <?php $this->get_data('page_nav'); ?>

        </ul>