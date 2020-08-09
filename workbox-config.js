module.exports = {
	globDirectory: '../public_html/grid/',
	globPatterns: ['**/*.{js,css,png,jpg}','offline.html'],
	swSrc: '../public_html/grid/sw-base.js',
	swDest: '../public_html/grid/service-worker.js',
};