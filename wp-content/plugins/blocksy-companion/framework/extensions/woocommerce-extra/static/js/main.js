import $ from 'jquery'
import { markImagesAsLoaded } from '../../../cookies-consent/static/js/lazy-load-helpers'
import { onDocumentLoaded } from '../../../cookies-consent/static/js/helpers'
import { mountFloatingCart } from './floating-cart'
import ctEvents from 'ct-events'
import { getCurrentScreen } from 'blocksy-frontend'

const store = {}

const cachedFetch = url =>
	store[url]
		? new Promise(resolve => {
				resolve(store[url])
				store[url] = store[url].clone()
		  })
		: new Promise(resolve =>
				fetch(url).then(response => {
					resolve(response)
					store[url] = response.clone()
				})
		  )

ctEvents.on('blocksy:woo:floating-cart:init', () => {
	mountFloatingCart()
})

const openQuickViewFor = ({ e, el }) => {
	if (e.target.matches('.add_to_cart_button')) {
		return
	}

	if (e.target.matches('.added_to_cart')) {
		return
	}

	e.preventDefault()

	let productId = Array.from(el.classList)
		.find(className => className.indexOf('post-') === 0)
		.split('-')[1]

	let href = `#quick-view-${productId}`

	if (document.querySelector(href)) {
		ctEvents.trigger('ct:overlay:handle-click', {
			e,
			href,
			options: {
				clickOutside: true
			}
		})
		return
	}

	const loadingHtml = `
		<div id="quick-view-${productId}" data-behaviour="modal" class="ct-panel quick-view-modal">
			<span data-loader="circles">
				<span></span>
				<span></span>
				<span></span>
			</span>
		</div>
    `

	const div = document.createElement('div')

	div.innerHTML = loadingHtml

	document.body.appendChild(div.firstElementChild)

	setTimeout(() => {
		ctEvents.trigger('ct:overlay:handle-click', {
			e,
			href,
			options: {
				skipScrollLock: true,
				scrollContainer:
					getCurrentScreen && getCurrentScreen() === 'mobile'
						? document.querySelector(href).firstElementChild
								.lastElementChild.lastElementChild
						: null,
				clickOutside: true,
				focus: false
			}
		})
	}, 100)

	cachedFetch(
		`${ct_localizations.ajax_url}?action=blocsky_get_woo_quick_view&product_id=${productId}`
	).then(r => {
		if (r.status === 200) {
			r.json().then(({ success, data }) => {
				if (!success) return

				const div = document.createElement('div')

				div.innerHTML = data.quickview

				markImagesAsLoaded(div)

				if (document.querySelector(href)) {
					document.querySelector(href).innerHTML =
						div.firstElementChild.innerHTML
				}

				const wc_single_product_params = {
					i18n_required_rating_text: 'Please select a rating',
					review_rating_required: 'yes',
					flexslider: {
						rtl: false,
						animation: 'slide',
						smoothHeight: true,
						directionNav: false,
						controlNav: 'thumbnails',
						slideshow: false,
						animationSpeed: 500,
						animationLoop: false,
						allowOneSlide: false
					},
					zoom_enabled: '',
					zoom_options: [],
					photoswipe_enabled: '1',
					photoswipe_options: {
						shareEl: false,
						closeOnScroll: false,
						history: false,
						hideAnimationDuration: 0,
						showAnimationDuration: 0
					},
					flexslider_enabled: '1'
				}
				;[
					...document.querySelectorAll(`${href} .variations_form`)
				].map(el => $(el).wc_variation_form())

				ctEvents.trigger('ct:custom-select:init')
				ctEvents.trigger('ct:custom-select-allow:init')

				ctEvents.trigger('ct:add-to-cart:update')

				setTimeout(() => {
					if ($) {
						$.wcpaInit && $.wcpaInit()
					}
				}, 50)

				setTimeout(() => {
					ctEvents.trigger('ct:overlay:handle-click', {
						e,
						href,
						options: {
							scrollContainer:
								getCurrentScreen &&
								getCurrentScreen() === 'mobile'
									? document.querySelector(href)
											.firstElementChild.lastElementChild
											.lastElementChild
									: null,
							clickOutside: true,
							focus: false,
							forceOpen: true
						}
					})
					setTimeout(() => ctEvents.trigger('ct:flexy:update'))
				}, 100)
			})
		}
	})
}

const mount = () => {
	mountFloatingCart()
	;[
		...document.querySelectorAll(
			'.ct-open-quick-view, [data-quick-view="image"] .ct-image-container'
		)
	].map(el => {
		if (el.hasQuickViewInit) return
		el.hasQuickViewInit = true

		el.addEventListener('click', e => {
			openQuickViewFor({ e, el: el.closest('.product') })
		})
	})
	;[...document.querySelectorAll('[data-quick-view="card"] > *')].map(el => {
		if (el.hasQuickViewInit) return
		el.hasQuickViewInit = true

		el.addEventListener('click', e => {
			openQuickViewFor({ e, el })
		})
	})
}

onDocumentLoaded(() => {
	mount()
	ctEvents.on('ct:quick-view:update', () => mount())
	ctEvents.on('ct:infinite-scroll:load', () => mount())
	ctEvents.on('blocksy:frontend:init', () => mount())

	ctEvents.on('ct:modal:closed', modalContainer => {
		if (!modalContainer.closest('.quick-view-modal')) {
			return
		}

		if (modalContainer.querySelector('.flexy-container')) {
			const flexyEl = modalContainer.querySelector('.flexy-container')
				.parentNode

			flexyEl.flexy && flexyEl.flexy.destroy && flexyEl.flexy.destroy()
		}

		setTimeout(() => {
			modalContainer.remove()
		})
	})
})
