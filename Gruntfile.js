module.exports = function(grunt) {

	// load all grunt tasks matching the `grunt-*` pattern
	require('load-grunt-tasks')(grunt);

	grunt.initConfig({
		pkg: grunt.file.readJSON('package.json'),

		// No need for config.rb
		compass: {                  // Task
			dist: {                   // Target
				options: {              // Target options
					sassDir: 'src/scss',
					cssDir: 'src/css',    // Output to dev dir before we concat
					output: 'compact',
					javascriptsDir: 'assets/js',
					fontsDir: 'assets/fonts',
					relativeAssets: true,
					noLineComments: true,
					importPath: [         // Imports Foundation as well as Bourbon
						'bower_components/bourbon/app/assets/stylesheets',
						'bower_components/foundation/scss'
					]
				}
			}
		},

		//  Here we're going to combine foundation and our theme styles into one as well as add the WP banner

		//  The files structure will be
		//  - Normalize
		//  - Foundation
		//  - Theme
		cssmin: {
			combine: {
				files: {
					'style.css': ['src/css/app.css', 'src/css/style.css']
				}
			},
			add_banner: {
				options: {
					banner: '/*\n'+
											'Theme Name: Foundation_s\n'+
											'Theme URI: https://github.com/mrdink/foundation_s-boillerplate/\n'+
											'Description: Starter for WordPress themes using _s and Foundation\n'+
											'Author: Justin Peacock\n'+
											'Author URI: http://byjust.in/\n'+
											'Version: 5.2.1\n'+ // Using Foundation version purely for reference
											'License: GNU General Public License v2 or later\n'+
											'License URI: http://www.gnu.org/licenses/gpl-2.0.html\n'+
											'Text Domain: foundation-s\n'+
											'Domain Path: /languages/\n'+
											'Tags: boilerplate\n'+
									'*/\n'
				},
				files: {
					'style.css': ['style.css']
				}
			}
		},

		// This really isn't needed but a nice cherry on the top. Adds any missing browser prefixes you may have missed.
		autoprefixer: {
			options: {
				browsers: ['last 2 version', 'ie 9']
			},
			dist: {
				src: 'style.css',
				dest: 'style.css'
			}
		},

		//  If you need to support older browsers, this is a must with Foundation 5+ since they use rem. This generates a duplicate
		//  stylesheet but converts rem's to px's.
		pixrem: {
			options: {
				rootvalue: '16px',
				replace: true
			},
			dist: {
				src: 'style.css',
				dest: 'assets/css/rem-fallback.css'
			}
		},

		//	Grabs any files we've grabbed using bower and put them in their place
		copy: {
			main: {
				files: [
					{expand: true, flatten: true, src: ['bower_components/modernizr/modernizr.js'], dest: 'src/js/', filter: 'isFile'}
				]
			}
		},

		concat: {

			// Works along with the pixrem for IE support
			ie: {
				options: {
					separator: "\n\n"
				},
				src: [
					"bower_components/selectivizr/selectivizr.js",
					"bower_components/respond/dest/respond.min.js"
				],
				dest: "src/js/ie.js"
			},

			//	Combines all of our scripts into one file.
			//	Feel free to comment out any script you may not use to optimize.
			//	Use src/js/scripts.js to initialize/customize any scripts you're using above it.
			dist: {
				options: {
					separator: "\n\n"
				},
				src: [
					// Foundation Vendor
					"bower_components/foundation/js/vendor/fastclick.js",
					"bower_components/foundation/js/vendor/placeholder.js",
					// Foundation Core
					"bower_components/foundation/js/foundation/foundation.js",
					"bower_components/foundation/js/foundation/foundation.abide.js",
					"bower_components/foundation/js/foundation/foundation.accordion.js",
					"bower_components/foundation/js/foundation/foundation.alert.js",
					"bower_components/foundation/js/foundation/foundation.clearing.js",
					"bower_components/foundation/js/foundation/foundation.dropdown.js",
					"bower_components/foundation/js/foundation/foundation.equalizer.js",
					"bower_components/foundation/js/foundation/foundation.interchange.js",
					"bower_components/foundation/js/foundation/foundation.joyride.js",
					"bower_components/foundation/js/foundation/foundation.magellan.js",
					"bower_components/foundation/js/foundation/foundation.offcanvas.js",
					"bower_components/foundation/js/foundation/foundation.orbit.js",
					"bower_components/foundation/js/foundation/foundation.reveal.js",
					"bower_components/foundation/js/foundation/foundation.tab.js",
					"bower_components/foundation/js/foundation/foundation.tooltip.js",
					"bower_components/foundation/js/foundation/foundation.topbar.js",
					// Project
					"src/js/skip-link-focus-fix.js",
					"src/js/_init.js"

					],
				dest: "src/js/scripts.js"
			}
		},

		// Uglify dem' scripts
		uglify: {
			min: {
				files: {
					"assets/js/scripts.min.js": ["src/js/scripts.js"],
					"assets/js/ie.min.js": ["src/js/ie.js"],
					"assets/js/vendor/modernizr.min.js": ["src/js/modernizr.js"]
				}
			}
		},

		// Image optimization
		imagemin: {
			img: {
				options: {
					optimizationLevel: 7, // 7 is the default
					progressive: true
				},
				files: [{
					expand: true,
					cwd: 'src/img/',
					src: '**/*.{png,jpg,gif}',
					dest: 'assets/img/'
				}]
			},

			//	Where I put my touch icons and favicon
			ico: {
				options: {
					optimizationLevel: 7,
					progressive: true
				},
				files: [{
					expand: true,
					cwd: 'src/ico/',
					src: '**/*.{png,jpg,gif}',
					dest: 'assets/ico/'
				}]
			}
		},

		watch: {
			options: {
				livereload: true
			},
			sass: {
				files: ['scss/**/*'],
				tasks: ["compass","autoprefixer","cssmin","pixrem"]
			},
			scripts: {
				files: ['src/js/**/*'],
				tasks: ['concat','uglify']
			},
			imagemin: {
				files: ['src/img/*','src/ico/*'],
				tasks: ['imagemin']
			}
		},

		//	deploy via rsync

		//	To deploy just run `grunt deploy:staging` or `grunt deploy:production`
		deploy: {
			options: {
				src: "./",
				args: ["--verbose"],
				exclude: ['.git*', 'src', 'scss','.sass-cache', 'node_modules', 'bower_components', 'Gruntfile.js', 'package.json', 'bower.json', '.DS_Store', 'README.md'],
				recursive: true,
				syncDestIgnoreExcl: true
			},
			staging: {
				options: {
					dest: "~/public_html/yoursite.com/wp-content/themes/foundation_s",
					host: "user@host.com",
					// port: "" // If needed
				}
			},
			production: {
				options: {
					dest: "~/public_html/yoursite.com/wp-content/themes/foundation_s",
					host: "user@host.com",
					// port: "" // If needed
				}
			}
		}

	});

	// register tasks
	grunt.registerTask("build", [
		"compass",
		"autoprefixer",
		"cssmin",
		"pixrem",
		"copy",
		"concat",
		"uglify",
		"imagemin",
		"watch"
	]);

	grunt.registerTask('default', [
    'build'
  ]);

};