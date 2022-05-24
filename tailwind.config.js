module.exports = {
	content: [
		"./resources/**/*.blade.php",
		"./resources/**/*.js",
		"./resources/**/*.vue",
	],

	theme: {
		extend: {
			keyframes: {
				loading: {
					'from': {
						transform: 'translateX(100%)'
					},
					
					'to': {
						transform: 'translateX(-100%)'
					}
				},
			},

			animation: {
				loading: 'loading .4s ease infinite alternate'
			}
		}
	},
	
	plugins: [require('@tailwindcss/forms')]
}
