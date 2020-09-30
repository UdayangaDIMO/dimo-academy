<?php

$current_user_id = get_current_user_id();

$avatar_html = '';


$link = get_edit_profile_url();
$account_link = blocksy_akg('account_link', $atts, 'profile');

if ($account_link === 'dashboard') {
	$link = admin_url();
}

if ($account_link === 'logout') {
	$link = wp_logout_url(blocksy_current_url());
}

if ($account_link === 'custom') {
	$link = blocksy_akg('account_custom_page', $atts, '');
}

$class = 'ct-header-account';

if ($current_user_id) {
	$class .= ' ct-logged-in';
}

$loggedin_style = blocksy_akg('loggedin_style', $atts, [
	'avatar' => true,
	'label' => false
]);

$login_style = blocksy_akg('login_style', $atts, [
	'icon' => true,
	'label' => false
]);

$loggedin_label = blocksy_akg('loggedin_label', $atts, __('Label', 'blc'));
$login_label = blocksy_akg('login_label', $atts, __('Label', 'blc'));

if ($current_user_id) {

	$avatar_html = blocksy_simple_image(
		get_avatar_url(
			$current_user_id,
			[
				'size' => 44
			]
		),
		[
			'html_atts' => is_customize_preview() && ! $loggedin_style['avatar'] ? [
				'hidden' => ''
			] : [],

			'img_atts' => [
				'width' => 22,
				'height' => 22
			]
		]
	);
}

?>

<div
	class="<?php echo $class ?>"
	<?php echo blocksy_attr_to_html($attr) ?>>

	<?php if ($current_user_id) { ?>
		<a href="<?php echo $link ?>" aria-label="<?php echo __('Account', 'blc') ?>">
			<?php if ($loggedin_style['avatar'] || is_customize_preview()) { ?>
				<?php echo $avatar_html ?>
			<?php } ?>

			<?php if ($loggedin_style['label'] || is_customize_preview()) { ?>
				<span class="ct-label" <?php echo !$loggedin_style['label'] ? 'hidden' : ''?>>
					<?php echo $loggedin_label; ?>
				</span>
			<?php } ?>
		</a>
	<?php } ?>

	<?php if (! $current_user_id) { ?>
		<a href="#account-modal">
			<?php if ($login_style['icon']) { ?>
				<svg width="15" height="15" viewBox="0 0 20 20">
					<path d="M10 0C4.5 0 0 4.5 0 10s4.5 10 10 10 10-4.5 10-10S15.5 0 10 0zm0 2c4.4 0 8 3.6 8 8 0 1.6-.5 3.1-1.3 4.3l-.8-.6C14.4 12.5 11.5 12 10 12s-4.4.5-5.9 1.7l-.8.6C2.5 13.1 2 11.6 2 10c0-4.4 3.6-8 8-8zm0 1.8C8.2 3.8 6.8 5.2 6.8 7c0 1.8 1.5 3.3 3.2 3.3s3.2-1.5 3.2-3.3c0-1.8-1.4-3.2-3.2-3.2zm0 1.9c.7 0 1.2.6 1.2 1.2 0 .7-.6 1.2-1.2 1.2S8.8 7.7 8.8 7c0-.7.5-1.3 1.2-1.3zm0 8.3c3.1 0 4.8 1.2 5.5 1.8-1.4 1.3-3.3 2.2-5.5 2.2s-4.1-.9-5.5-2.2c.7-.6 2.4-1.8 5.5-1.8zm-5.9 1.3c.1.1.2.3.4.4-.2-.1-.3-.2-.4-.4zm11.8.1c-.1.1-.2.2-.3.4.1-.2.2-.3.3-.4z"/>
				</svg>
			<?php } ?>

			<?php if ($login_style['label'] | is_customize_preview()) { ?>
				<span class="ct-label" <?php echo ! $login_style['label'] ? 'hidden' : ''?>>
					<?php echo $login_label; ?>
				</span>
			<?php } ?>
		</a>
	<?php } ?>
</div>


