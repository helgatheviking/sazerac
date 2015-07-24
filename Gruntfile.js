'use strict';
module.exports = function(grunt) {

	// load all tasks
	require('load-grunt-tasks')(grunt, {scope: 'devDependencies'});

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),
		watch: {
			scripts: {
				files: ['assets/js/app/*.js'],
				tasks: ['concat', 'uglify:app'],
				options: {
				  spawn: false,
				},
			},
			sass: {
				files: ['assets/sass/**/*.scss'],
				tasks: ['sass'],
				options: {
				  spawn: false,
				  livereload: true,
				},
			},
		},
		sass: {
			default: {
				options : {
					style : 'expanded'
				},
				files: {
					'style.css':'assets/sass/style.scss'
				}
			}
		},
		postcss: {
			options: {
			map: true,
			processors: [
				require('autoprefixer-core')({browsers: 'last 2 versions'}),
			]
			},
			files: {
				'css/style.css':'css/style.css'
			}
		},
		cssmin: {
			options: {
				aggressiveMerging : false
			},
			target: {
				files: {
					'style.min.css': 'style.css'
				}
			}
		},
		concat: {
			release: {
				src: [
					'assets/js/app/**.js'
				],
				dest: 'assets/js/development.js',
			}
		},
		uglify: {
			options: {
				mangle: {
					except: ['jQuery', 'sidr', 'fastClick', 'fitVids']
				},
				drop_console: true
			},
			vendors: {
				files: {
					'assets/js/vendors/jquery.fastclick.min.js' : 'assets/js/vendors/fastclick.js',
					'assets/js/vendors/jquery.fitvids.min.js' : 'assets/js/vendors/jquery.fitvids.js',
					'assets/js/vendors/jquery.sidr.min.js' : 'assets/js/vendors/sidr.js',
				}
			},
			app: {
				files: {
					'assets/js/production.min.js' : 'assets/js/development.js',
				}
			},
		},
		// https://www.npmjs.org/package/grunt-wp-i18n
		makepot: {
			target: {
				options: {
					domainPath: 'languages/',
					potFilename: 'criticalink.pot',
					potHeaders: {
					poedit: true, // Includes common Poedit headers.
					'x-poedit-keywordslist': true // Include a list of all possible gettext functions.
				},
				type: 'wp-theme',
				updateTimestamp: false,
				processPot: function( pot, options ) {
					pot.headers['report-msgid-bugs-to'] = 'https://kathyisawesome.com/contact';
					pot.headers['language'] = 'en_US';
					return pot;
					}
				}
			}
		},
		replace: {
			styleVersion: {
				src: [
					'scss/style.scss',
					'style.css'
				],
				overwrite: true,
				replacements: [{
					from: /Version:.*$/m,
					to: 'Version: <%= pkg.version %>'
				}]
			},
			functionsVersion: {
				src: [
					'functions.php'
				],
				overwrite: true,
				replacements: [ {
					from: /^define\( 'LUMINATE_VERSION'.*$/m,
					to: 'define( \'LUMINATE_VERSION\', \'<%= pkg.version %>\' );'
				} ]
			},
		},
		rtlcss: {
			'default':{
				cwd	: '',
				dest   : '',
				src    : ['style.css', 'style.min.css']
			}
		},
		'ftpush': {
			build: {
				auth: {
					host: 'ftp.kathyisawesome.com',
					port: 21,
					authKey: 'key1'
				},
				src: '',
				dest: '/home/kathyi/public_html/wp-content/themes/sazerac/',
				exclusions: ['.ftppass', 'sftp-config.json', 'node_modules', 'bower_components'],
				simple: true
			}
		},
	});

	grunt.registerTask( 'default', [
		'sass',
		'postcss',
		'cssmin'
	]);

	grunt.registerTask( 'ftp', [
		'ftpush'
	]);


	grunt.registerTask( 'release', [
		'replace',
		'sass',
		'postcss',
		'cssmin',
		'concat:release',
		'uglify:app',
		'makepot',
		'cssjanus'
	]);

};
