import { createElement, useEffect, useState } from '@wordpress/element'
import cls from 'classnames'
import { __ } from 'ct-i18n'
import { Select } from 'blocksy-options'

let allPostsCache = []
let allTaxonomiesCache = []

const ConditionsManager = ({ value, onChange }) => {
	const allRules = blocksy_admin.all_condition_rules
		.reduce(
			(current, { rules, title }) => [
				...current,
				...rules.map((r) => ({
					...r,
					group: title,
				})),
			],
			[]
		)
		.reduce(
			(current, { title, id, ...rest }) => [
				...current,
				{
					key: id,
					value: title,
					...rest,
				},
			],
			[]
		)

	const [allPosts, setAllPosts] = useState(allPostsCache)
	const [allTaxonomies, setAllTaxonomies] = useState(allTaxonomiesCache)

	const hasAdditions = (condition) =>
		condition.rule === 'post_ids' ||
		condition.rule === 'page_ids' ||
		condition.rule === 'taxonomy_ids'

	useEffect(() => {
		Promise.all(
			['posts', 'pages'].map((type) =>
				fetch(
					`${blocksy_admin.rest_url}wp/v2/${type}${
						blocksy_admin.rest_url.indexOf('?') > -1 ? '&' : '?'
					}_embed&per_page=100`
				).then((r) => r.json())
			)
		).then((results) => {
			let all = results.reduce((r, current) => [...r, ...current], [])

			setAllPosts(all)
			allPostsCache = all
		})

		Promise.all(
			['categories', 'tags'].map((type) =>
				fetch(
					`${blocksy_admin.rest_url}wp/v2/${type}${
						blocksy_admin.rest_url.indexOf('?') > -1 ? '&' : '?'
					}_embed&per_page=100`
				).then((r) => r.json())
			)
		).then((results) => {
			let all = results.reduce((r, current) => [...r, ...current], [])

			setAllTaxonomies(all)
			allTaxonomiesCache = all
		})
	}, [])

	return (
		<div className="ct-display-conditions">
			{value.map((condition, index) => (
				<div
					className={cls('ct-condition-group', {
						'ct-cols-3': hasAdditions(condition),
						'ct-cols-2': !hasAdditions(condition),
					})}
					key={index}>
					<Select
						option={{
							inputClassName: 'ct-condition-type',
							selectInputStart: () => (
								<span className={`ct-${condition.type}`} />
							),
							placeholder: __('Select variation', 'blc'),
							choices: {
								include: __('Include', 'blc'),
								exclude: __('Exclude', 'blc'),
							},
						}}
						value={condition.type}
						onChange={(type) => {
							onChange(
								value.map((r, i) => ({
									...(i === index
										? {
												...condition,
												type,
										  }
										: r),
								}))
							)
						}}
					/>

					<Select
						option={{
							placeholder: __('Select rule', 'blc'),
							choices: allRules,
							search: true,
						}}
						value={condition.rule}
						onChange={(rule) => {
							onChange(
								value.map((r, i) => ({
									...(i === index
										? {
												...condition,
												rule,
										  }
										: r),
								}))
							)
						}}
					/>

					{(condition.rule === 'post_ids' ||
						condition.rule === 'page_ids') && (
						<Select
							option={{
								defaultToFirstItem: false,
								placeholder:
									condition.rule === 'post_ids'
										? __('Select post', 'blc')
										: __('Select page', 'blc'),
								choices: allPosts
									.filter(({ type }) =>
										condition.rule === 'post_ids'
											? type === 'post'
											: type !== 'post'
									)
									.map((post) => ({
										key: post.id,
										value: post.title.rendered,
									})),
								search: true,
							}}
							value={(condition.payload || {}).post_id || ''}
							onChange={(post_id) => {
								onChange(
									value.map((r, i) => ({
										...(i === index
											? {
													...condition,
													payload: {
														...condition.payload,

														post_id,
													},
											  }
											: r),
									}))
								)
							}}
						/>
					)}

					{condition.rule === 'taxonomy_ids' && (
						<Select
							option={{
								defaultToFirstItem: false,
								placeholder: __('Select taxonomy', 'blc'),
								choices: allTaxonomies.map((taxonomy) => ({
									key: taxonomy.id,
									value: taxonomy.name,
								})),
								search: true,
							}}
							value={condition.payload.taxonomy_id || ''}
							onChange={(taxonomy_id) => {
								onChange(
									value.map((r, i) => ({
										...(i === index
											? {
													...condition,
													payload: {
														...condition.payload,
														taxonomy_id,
													},
											  }
											: r),
									}))
								)
							}}
						/>
					)}

					<button
						type="button"
						onClick={(e) => {
							e.preventDefault()

							let newValue = [...value]
							newValue.splice(index, 1)

							onChange(newValue)
						}}>
						×
					</button>
				</div>
			))}

			<button
				type="button"
				className="button add-condition"
				onClick={(e) => {
					e.preventDefault()

					onChange([
						...value,
						{
							type: 'include',
							rule: 'everywhere',
							payload: {},
						},
					])
				}}>
				{__('Add New Condition', 'blc')}
			</button>
		</div>
	)
}
export default ConditionsManager
