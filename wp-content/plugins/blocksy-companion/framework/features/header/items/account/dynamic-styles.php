<?php

if (! isset($root_selector)) {
	$root_selector = ['.ct-header-account'];
}

// Icon size
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blc_call_fn([
		'fn' => 'blocksy_assemble_selector',
		'default' => $root_selector
	], $root_selector),
	'variableName' => 'icon-size',
	'value' => blocksy_akg('accountHeaderIconSize', $atts, [
		'mobile' => 15,
		'tablet' => 15,
		'desktop' => 15,
	])
]);

// Avatar size
blocksy_output_responsive([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blc_call_fn([
		'fn' => 'blocksy_assemble_selector',
		'default' => $root_selector
	], $root_selector),
	'variableName' => 'avatar-size',
	'value' => blocksy_akg('accountHeaderAvatarSize', $atts, [
		'mobile' => 22,
		'tablet' => 22,
		'desktop' => 22,
	])
]);


// Content color
blocksy_output_colors([
	'value' => blocksy_akg('accountHeaderColor', $atts),
	'default' => [
		'default' => [ 'color' => 'var(--color)' ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'variables' => [
		'default' => [
			'selector' => blc_call_fn([
				'fn' => 'blocksy_assemble_selector',
				'default' => $root_selector
			], $root_selector),
			'variable' => 'linkInitialColor'
		],

		'hover' => [
			'selector' => blc_call_fn([
				'fn' => 'blocksy_assemble_selector',
				'default' => $root_selector
			], $root_selector),
			'variable' => 'linkHoverColor'
		],
	],
	'responsive' => true
]);

// Modal background
blocksy_output_background_css([
	'selector' => blc_call_fn([
		'fn' => 'blocksy_assemble_selector',
		'default' => $root_selector
	], blc_call_fn([
		'fn' => 'blocksy_mutate_selector',
	], [
		'selector' => [$root_selector[0]],
		'operation' => 'suffix',
		'to_add' => '#account-modal'
	])),
	'css' => $css,
	'value' => blocksy_akg('accountHeaderBackground', $atts,
		blocksy_background_default_value([
			'backgroundColor' => [
				'default' => [
					'color' => 'rgba(18, 21, 25, 0.7)'
				],
			],
		])
	)
]);


// Item margin
blocksy_output_spacing([
	'css' => $css,
	'tablet_css' => $tablet_css,
	'mobile_css' => $mobile_css,
	'selector' => blc_call_fn([
		'fn' => 'blocksy_assemble_selector',
		'default' => $root_selector
	], $root_selector),
	'important' => true,
	'value' => blocksy_default_akg(
		'accountHeaderMargin', $atts,
		blocksy_spacing_value([
			'linked' => true,
		])
	)
]);


if (isset($has_transparent_header) && $has_transparent_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('transparentAccountHeaderColor', $atts),
		'default' => [
			'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
			'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blc_call_fn([
					'fn' => 'blocksy_assemble_selector',
					'default' => $root_selector
				], blc_call_fn([
					'fn' => 'blocksy_mutate_selector',
				], [
					'selector' => blc_call_fn([
						'fn' => 'blocksy_mutate_selector'
					], [
						'selector' => $root_selector,
						'operation' => 'suffix',
						'to_add' => '.ct-header-account'
					]),
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blc_call_fn([
					'fn' => 'blocksy_assemble_selector',
					'default' => $root_selector
				], blc_call_fn([
					'fn' => 'blocksy_mutate_selector',
				], [
					'selector' => blc_call_fn([
						'fn' => 'blocksy_mutate_selector'
					], [
						'selector' => $root_selector,
						'operation' => 'suffix',
						'to_add' => '.ct-header-account'
					]),
					'to_add' => '[data-transparent-row="yes"]'
				])),
				'variable' => 'linkHoverColor'
			],
		],
		'responsive' => true
	]);
}


// sticky state
if (isset($has_sticky_header) && $has_sticky_header) {
	blocksy_output_colors([
		'value' => blocksy_akg('stickyAccountHeaderColor', $atts),
		'default' => [
			'default' => ['color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT')],
			'hover' => ['color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT')],
		],
		'css' => $css,
		'tablet_css' => $tablet_css,
		'mobile_css' => $mobile_css,

		'variables' => [
			'default' => [
				'selector' => blc_call_fn([
					'fn' => 'blocksy_assemble_selector',
					'default' => $root_selector
				], blc_call_fn([
					'fn' => 'blocksy_mutate_selector',
				], [
					'selector' => blc_call_fn([
						'fn' => 'blocksy_mutate_selector'
					], [
						'selector' => $root_selector,
						'operation' => 'suffix',
						'to_add' => '.ct-header-account'
					]),
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'linkInitialColor'
			],

			'hover' => [
				'selector' => blc_call_fn([
					'fn' => 'blocksy_assemble_selector',
					'default' => $root_selector
				], blc_call_fn([
					'fn' => 'blocksy_mutate_selector',
				], [
					'selector' => blc_call_fn([
						'fn' => 'blocksy_mutate_selector'
					], [
						'selector' => $root_selector,
						'operation' => 'suffix',
						'to_add' => '.ct-header-account'
					]),
					'to_add' => '[data-sticky*="yes"]'
				])),
				'variable' => 'linkHoverColor'
			],
		],
		'responsive' => true
	]);
}

blocksy_output_colors([
	'value' => blocksy_akg('account_close_button_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => blc_call_fn([
				'fn' => 'blocksy_assemble_selector',
				'default' => $root_selector
			], blc_call_fn([
				'fn' => 'blocksy_mutate_selector',
			], [
				'selector' => [$root_selector[0]],
				'operation' => 'suffix',
				'to_add' => '#account-modal .close-button'
			])),
			'variable' => 'closeButtonColor'
		],

		'hover' => [
			'selector' => blc_call_fn([
				'fn' => 'blocksy_assemble_selector',
				'default' => $root_selector
			], blc_call_fn([
				'fn' => 'blocksy_mutate_selector',
			], [
				'selector' => [$root_selector[0]],
				'operation' => 'suffix',
				'to_add' => '#account-modal .close-button'
			])),
			'variable' => 'closeButtonHoverColor'
		]
	],
]);

blocksy_output_colors([
	'value' => blocksy_akg('account_close_button_shape_color', $atts),
	'default' => [
		'default' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
		'hover' => [ 'color' => Blocksy_Css_Injector::get_skip_rule_keyword('DEFAULT') ],
	],
	'css' => $css,

	'variables' => [
		'default' => [
			'selector' => blc_call_fn([
				'fn' => 'blocksy_assemble_selector',
				'default' => $root_selector
			], blc_call_fn([
				'fn' => 'blocksy_mutate_selector',
			], [
				'selector' => [$root_selector[0]],
				'operation' => 'suffix',
				'to_add' => '#account-modal .close-button'
			])),
			'variable' => 'closeButtonBackground'
		],

		'hover' => [
			'selector' => blc_call_fn([
				'fn' => 'blocksy_assemble_selector',
				'default' => $root_selector
			], blc_call_fn([
				'fn' => 'blocksy_mutate_selector',
			], [
				'selector' => [$root_selector[0]],
				'operation' => 'suffix',
				'to_add' => '#account-modal .close-button'
			])),
			'variable' => 'closeButtonHoverBackground'
		]
	],
]);
