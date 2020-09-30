import './variables'
import '../../../cookies-consent/static/js/ct-events'
import ctEvents from 'ct-events'

import {
	checkAndReplace,
	responsiveClassesFor
} from '../../../cookies-consent/static/js/sync/helpers'

checkAndReplace({
	id: 'has_floating_bar',
	strategy: 'append',

	parent_selector: 'body',
	selector: '.ct-floating-bar',
	fragment_id: 'blocksy-woo-floating-cart',

	whenInserted: () => ctEvents.trigger('blocksy:woo:floating-cart:init')
})
