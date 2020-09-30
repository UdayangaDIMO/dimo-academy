import ctEvents from 'ct-events'
import {
	updateAndSaveEl,
	handleBackgroundOptionFor,
	assembleSelector,
	mutateSelector,
	getRootSelectorFor,
} from 'blocksy-customizer-sync'
import { markImagesAsLoaded } from '../../../../extensions/cookies-consent/static/js/lazy-load-helpers'

/*
				selector: assembleSelector(
					mutateSelector({
						selector: getRootSelectorFor({ itemId }),
						operation: 'suffix',
						to_add: '.ct-button',
					})
				),
*/

ctEvents.on(
	'ct:header:sync:collect-variable-descriptors',
	(variableDescriptors) => {
		variableDescriptors['account'] = ({ itemId }) => ({
			accountHeaderIconSize: {
				selector: assembleSelector(getRootSelectorFor({ itemId })),

				variable: 'icon-size',
				responsive: true,
				unit: 'px',
			},

			accountHeaderAvatarSize: {
				selector: assembleSelector(getRootSelectorFor({ itemId })),
				variable: 'avatar-size',
				responsive: true,
				unit: 'px',
			},

			...handleBackgroundOptionFor({
				id: 'accountHeaderBackground',
				selector: '#account-modal',

				selector: assembleSelector(
					mutateSelector({
						selector: [getRootSelectorFor({ itemId })[0]],
						operation: 'suffix',
						to_add: '#account-modal',
					})
				),
			}),

			accountHeaderMargin: {
				selector: assembleSelector(getRootSelectorFor({ itemId })),
				type: 'spacing',
				variable: 'margin',
				responsive: true,
				important: true,
			},

			// default state
			accountHeaderColor: [
				{
					selector: assembleSelector(getRootSelectorFor({ itemId })),
					variable: 'linkInitialColor',
					type: 'color:default',
					responsive: true,
				},

				{
					selector: assembleSelector(getRootSelectorFor({ itemId })),
					variable: 'linkHoverColor',
					type: 'color:hover',
					responsive: true,
				},
			],

			// transparent state
			transparentAccountHeaderColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'linkInitialColor',
					type: 'color:default',
					responsive: true,
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-transparent-row="yes"]',
						})
					),

					variable: 'linkHoverColor',
					type: 'color:hover',
					responsive: true,
				},
			],

			// sticky state
			stickyAccountHeaderColor: [
				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'linkInitialColor',
					type: 'color:default',
					responsive: true,
				},

				{
					selector: assembleSelector(
						mutateSelector({
							selector: getRootSelectorFor({ itemId }),
							operation: 'between',
							to_add: '[data-sticky*="yes"]',
						})
					),
					variable: 'linkHoverColor',
					type: 'color:hover',
					responsive: true,
				},
			],
		})
	}
)

ctEvents.on(
	'ct:header:sync:item:account',
	({ values: { loggedin_style, loggedin_label }, optionId, optionValue }) => {
		const selector = '[data-id="account"]'

		if (optionId === 'loggedin_style' || optionId === 'loggedin_label') {
			updateAndSaveEl(selector, (el) => {
				;[...el.querySelectorAll('.ct-label')].map((label) => {
					label.removeAttribute('hidden')

					if (!loggedin_style.label) {
						label.hidden = true
					}

					label.innerHTML = loggedin_label
				})
				;[...el.querySelectorAll('.ct-image-container')].map((img) => {
					img.removeAttribute('hidden')

					if (!loggedin_style.avatar) {
						img.hidden = true
					}

					markImagesAsLoaded(img.parentNode)
				})
			})
		}
	}
)
