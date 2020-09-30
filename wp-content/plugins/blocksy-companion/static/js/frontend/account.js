import ctEvents from 'ct-events'

const activateScreen = (
	el,
	{
		// login | register | forgot
		screen = 'login'
	}
) => {
	if (el.querySelector('ul') && el.querySelector(`ul .ct-${screen}`)) {
		el.querySelector('ul .active').classList.remove('active')
		el.querySelector(`ul .ct-${screen}`).classList.add('active')
	}

	el.querySelector('[class*="-form"].active').classList.remove('active')
	el.querySelector(`.ct-${screen}-form`).classList.add('active')
}

const handleAccountModal = el => {
	if (!el) {
		return
	}

	;['login', 'register', 'forgot-password'].map(screen => {
		Array.from(el.querySelectorAll(`.ct-${screen}`)).map(itemEl => {
			itemEl.addEventListener('click', e => {
				e.preventDefault()

				activateScreen(el, { screen })
			})
		})
	})
}

export const mountAccount = () => {
	Array.from(document.querySelectorAll('.ct-header-account > a[href]')).map(
		el => {
			if (el.hasSearchEventListener) {
				return
			}

			el.hasSearchEventListener = true

			el.addEventListener('click', e => {
				activateScreen(document.querySelector(el.hash), {
					screen: 'login'
				})

				ctEvents.trigger('ct:overlay:handle-click', {
					e,
					href: el.hash,
					options: {
						isModal: true
					}
				})
			})

			if (el.hash) {
				handleAccountModal(document.querySelector(el.hash))
			}
		}
	)
}
