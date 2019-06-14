<?php
// products details

include('app\views\includes\header.php'); ?>
<div id="content">

	<img src="<?php $this->get_data('prod_image'); ?>" alt="<?php $this->get_data('prod_name'); ?>" class="product_image">
	<h2><?php $this->get_data('prod_name'); ?></h2>

	<div class="price">Price:$<?php $this->get_data('prod_price'); ?></div>
	<div class="description">Description:<?php $this->get_data('prod_description'); ?></div>
	<div class="weight">Weight:<?php $weight = $this->get_data('prod_weight', false);
								if ($weight >= 1000) {
									echo ($weight / 1000) . 'Kg';
								} else {
									echo ($weight) . 'g';
								}
								?></div>
	<?php if (isset($_SESSION['username'])) : ?>
		 <a href="cart.php?id=' . < ? php $this->get_data('prod_id'); ?> .'" class="button">Add to cart</a>
	<?php endif; ?>

</div>


<?php include('app\views\includes\footer.php');
