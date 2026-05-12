<?php
$product_id = tutor_utils()->get_course_product_id();
$product    = wc_get_product($product_id);

$is_logged_in             = is_user_logged_in();
$enable_guest_course_cart = tutor_utils()->get_option('enable_guest_course_cart');
$required_loggedin_class  = '';
if (!$is_logged_in && !$enable_guest_course_cart) {
	$required_loggedin_class = apply_filters('tutor_enroll_required_login_class', 'tutor-open-login-modal');
}

if ($product) {
	if (tutor_utils()->is_course_added_to_cart($product_id, true)) {
		?>
		<a href="<?php echo esc_url(wc_get_cart_url()); ?>" class="btn btn-primary btn-lg btn-block">
			<i class="fas fa-shopping-cart"></i> عرض السلة
		</a>
		<?php
	} else {
		$regular_price = wc_get_price_to_display($product, array('price' => $product->get_regular_price()));
		$sale_price    = wc_get_price_to_display($product, array('price' => $product->get_sale_price()));
		$cart_url      = wc_get_cart_url() . '?add-to-cart=' . $product_id;
		?>
		<div class="tutor-course-sidebar-card-pricing tutor-d-flex tutor-align-end tutor-justify-between">
			<div>
				<span class="tutor-fs-4 tutor-fw-bold tutor-color-black">
					<?php echo wc_price($sale_price ? $sale_price : $regular_price); ?>
				</span>
				<?php if ($regular_price && $sale_price && $sale_price !== $regular_price) : ?>
					<del class="tutor-fs-7 tutor-color-muted tutor-ml-8">
						<?php echo wc_price($regular_price); ?>
					</del>
				<?php endif; ?>
			</div>
		</div>
		<a href="<?php echo esc_url($cart_url); ?>" class="btn btn-primary btn-lg btn-block tutor-mt-24 <?php echo esc_attr($required_loggedin_class); ?>">
			<i class="fas fa-shopping-cart"></i> أضف إلى السلة
		</a>
		<?php
	}
} else {
	?>
	<p class="tutor-alert-warning">
		الرجاء التأكد من أن المنتج مرتبط بالدورة
	</p>
	<?php
}
