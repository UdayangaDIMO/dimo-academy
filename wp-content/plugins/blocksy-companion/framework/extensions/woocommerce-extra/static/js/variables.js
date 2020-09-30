import { handleVariablesFor } from 'customizer-sync-helpers'
import { handleResponsiveSwitch } from './helpers'

handleVariablesFor({
	floatingBarFontColor: {
		selector: '.ct-floating-bar',
		variable: 'color',
		type: 'color'
	},

	floatingBarBackground: {
		selector: '.ct-floating-bar',
		variable: 'backgroundColor',
		type: 'color'
	},

	floatingBarShadow: {
		selector: '.ct-floating-bar',
		type: 'box-shadow',
		variable: 'boxShadow',
		responsive: true
	},

	floatingBarVisibility: handleResponsiveSwitch({
		on: 'flex',
		selector: '.ct-floating-bar'
	})
})
