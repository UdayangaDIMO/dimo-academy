<?php

if (! function_exists('is_woocommerce')) {
	return;
}

// Floating bar
blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('floatingBarFontColor'),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-floating-bar',
			'variable' => 'color'
		],
	],
]);

blc_call_fn(['fn' => 'blocksy_output_colors'], [
	'value' => get_theme_mod('floatingBarBackground'),
	'default' => [
		'default' => [ 'color' => '#ffffff' ],
	],
	'css' => $css,
	'variables' => [
		'default' => [
			'selector' => '.ct-floating-bar',
			'variable' => 'backgroundColor'
		],
	],
]);

blc_call_fn(['fn' => 'blocksy_output_box_shadow'], [
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-floating-bar',
	'value' => get_theme_mod(
		'floatingBarShadow',
		blc_call_fn(['fn' => 'blocksy_box_shadow_value'], [
			'enable' => true,
			'h_offset' => 0,
			'v_offset' => 10,
			'blur' => 20,
			'spread' => 0,
			'inset' => false,
			'color' => [
				'color' => 'rgba(44,62,80,0.15)',
			],
		])
	),
	'responsive' => true
]);

blc_call_fn(['fn' => 'blocksy_output_responsive_switch'], [
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => '.ct-floating-bar',
	'on' => 'flex',
	'off' => 'none',
	'value' => get_theme_mod('floatingBarVisibility', [
		'desktop' => true,
		'tablet' => true,
		'mobile' => false,
	])
]);
