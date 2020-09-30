import {
	createElement,
	Component,
	useEffect,
	useState,
	Fragment
} from '@wordpress/element'
import { Transition } from 'react-spring/renderprops'
import { Dialog, DialogOverlay, DialogContent } from './reach/dialog'
import '@reach/dialog/styles.css'
import Overlay from './Overlay'

const useExtensionReadme = extension => {
	const [showReadme, setIsShowingReadme] = useState(false)

	return [
		() => setIsShowingReadme(true),

		<Overlay
			items={showReadme}
			onDismiss={() => setIsShowingReadme(false)}
			render={() => (
				<div
					className="ct-extension-readme"
					dangerouslySetInnerHTML={{
						__html: extension.readme
					}}
				/>
			)}
		/>
	]
}

export default useExtensionReadme
