// const purgecss = require('@fullhuman/postcss-purgecss')
// const cssnano = require('cssnano')

// module.exports = {
//   plugins: [
//     require('tailwindcss'),
//     process.env.NODE_ENV === 'production' ? require('autoprefixer') : null,
//     process.env.NODE_ENV === 'production'
//       ? cssnano({ preset: 'default' })
//       : null,
//     purgecss({
//       content: ['./layouts/**/*.html', './src/**/*.vue', './src/**/*.jsx'],
//       defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
//     })
//   ]
// }

// postcss.config.js
const purgecss = require('@fullhuman/postcss-purgecss');
const cssnano = require('cssnano');

module.exports = {
    plugins: [
        require('tailwindcss')('./tailwindcss.config.js'),
        require('autoprefixer'),
        cssnano({
            preset: 'default'
        }),
        purgecss({
            content: ['./resources/views/**/*.html'],
            defaultExtractor: content => content.match(/[\w-/:]+(?<!:)/g) || []
        })
    ]
}