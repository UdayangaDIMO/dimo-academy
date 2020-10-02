<?php
if (! defined('WP_DEBUG')) {
	die( 'Direct access forbidden.' );
}
add_action( 'wp_enqueue_scripts', function () {
	wp_enqueue_style( 'parent-style', get_template_directory_uri() . '/style.css' );
});


//SMPT Setup
function my_phpmailer_setup( PHPMailer $phpmailer ) {
// 	$phpmailer->Host = 'smtp-relay.gmail.com';
// 	$phpmailer->Port = 587;
// 	$phpmailer->SMTPAuth = true;
// 	$phpmailer->Username = 'username';
// 	$phpmailer->Password = 'password';
	
	$phpmailer->isSMTP();
	
	//Reference: https://github.com/PHPMailer/PHPMailer
}