/* eslint-disable no-tabs */
/**
 * UpGulp - Gulp tasks runtime configuration script
 *
 * @package     UpGulp
 * @since       1.0.2
 * @author      hellofromTonya
 * @link        https://KnowTheCode.io
 * @license     GNU-2.0+
 */

module.exports = function( moduleRoot ) {
  /** **********************************
   * Module Settings
   *
   * ACTION:
   * You need to change these settings
   * to fit your project.
   ***********************************/
let moduleSettings = {
  package: 'CollapsibleContent',
  domain: 'WPSandbox.dev',
  // If this is for a theme, set to `true`; else, set to `false`.
  isTheme: false,
  i18n: {
    textdomain: 'collapsible_content',
    languageFilename: 'CollapsibleContent.pot',
    bugReport: 'https://github.com/JeffCleverley/CollapsibleContent/issues',
    lastTranslator: 'Jeff Cleverley <jeff@jeffcleverley.com>',
    team: 'Team <jeff@jeffcleverley.com>',
  },
};


  /************************************
	 * Folder Structure
	 ***********************************/

	/**
   * Assets folder - path to the location of all the assets,
   * i.e. images, Sass, scripts, styles, etc.
   *
   * @type {String}
   */
  let assetsDir = moduleRoot + 'assets/';

	/**
   * gulp folder - path to where the gulp utils and
   * tasks are located.
   *
   * @type {String}
   */
  let gulpDir = assetsDir + 'gulp/';

	/**
   * Distribution folder - path to where the final build, distribution
   * files will be located.
   *
   * @type {String}
   */
  let distDir = assetsDir + 'dist/';

	/**
   * Assets folder - path to where the raw files are located.
   *
   * @type {Object}
   */
  let assetDirs = {
    css: assetsDir + 'css/',
    fonts: assetsDir + 'fonts/',
    icons: assetsDir + 'icons/',
    images: assetsDir + 'images/',
    sass: assetsDir + 'sass/',
    scripts: assetsDir + 'js/'
  };

	/**
   * Paths
   *
   * @type {Object}
   */
  let paths = {
    css: ['./*.css', '!*.min.css'],
    icons: assetDirs.images + 'svg-icons/*.svg',
    images: [assetDirs.images + '*', '!' + assetDirs.images + '*.svg'],
    sass: assetDirs.sass + '**/*.scss',
    concatScripts: assetDirs.scripts + '*.js',
    scripts: [assetDirs.scripts + '*.js', '!' + assetDirs.scripts + '*.min.js'],
    sprites: assetDirs.images + 'sprites/*.png'
  };

	/**
   * Distribution folder - path to where the final build, distribution
   * files will be located.
   *
   * @type {Object}
   */
  let distDirs = {
    root: moduleRoot,
    css: distDir + 'css/',
    finalCSS: moduleSettings.isTheme ? moduleRoot : distDir + 'css/',
    scripts: distDir + 'js/'
  };

	let distFilenames = {
    concatScripts: 'jquery.plugin.js',
  };

	/************************************
	 * Theme Settings
	 ***********************************/

	let stylesSettings = {
		clean: {
			src : [ distDirs.css + "*.*", moduleRoot + "style.css", moduleRoot + "style.min.css" ]
		},
		postcss: {
			src: [ assetDirs.sass + '*.scss' ],
			dest: distDirs.css,
			autoprefixer: {
				browsers: [
					'last 2 versions',
					'ie 9',
					'ios 6',
					'android 4'
				]
			}
		},
		cssnano: {
			src: distDirs.css + "*.css",
			dest: distDirs.css,
		},
		cssfinalize: {
			// Fix for Issue #1 - v1.0.3 11.July.2017
			run: moduleSettings.isTheme ? true : false,
			src: [ distDirs.css + "style.css", distDirs.css + "style.min.css" ],
			dest: distDirs.finalCSS,
		}
	};

	let scriptsSettings = {
		clean: {
			src : [ distDirs.scripts + "*.*" ]
		},
		concat: {
			src: paths.concatScripts,
			dest: distDirs.scripts,
			concatSrc: distFilenames.concatScripts,
		},
		uglify: {
			src: distDirs.scripts + '*.js',
			dest: distDirs.scripts,
		}
	};
	
	let i18nSettings = {
		clean: {
			src : [ moduleRoot + "languages/" + moduleSettings.i18n.languageFilename ]
		},
		pot: {
			src: paths.php,
			wppot: {
				domain: moduleSettings.i18n.textdomain,
				destFile: moduleSettings.i18n.languageFilename,
				package: moduleSettings.package,
				bugReport: moduleSettings.i18n.bugReport,
				lastTranslator: moduleSettings.i18n.lastTranslator,
				team: moduleSettings.i18n.team
			},
			dest: moduleRoot + "languages/"
		}
	}
	
	let iconsSettings = {
		clean: {
			src : [ assetDirs.images + "svg-icons.svg" ]
		},
		svg: {
			src: paths.icons,
			desc: assetDirs.images
		}
	}

	let spriteSettings = {
		clean: {
			src : [ assetDirs.images + "sprites.png" ]
		},
		spritesmith: {
			src: paths.sprites,
			dest: assetDirs.images
		}
	}

	let imageminSettings = {
		src: paths.images,
		dest: assetDirs.images
	}

	let watchSettings = {
		browserSync:	{
			open: false,             // Open project in a new tab?
			injectChanges: true,     // Auto inject changes instead of full reload
			proxy: moduleSettings.domain,  // Use http://domainname.tld:3000 to use BrowserSync
			watchOptions: {
				debounceDelay: 1000  // Wait 1 second before injecting
			}
		}
	}


	/************************************
	 * Do not touch below this line.
	 *
	 * The following code assembles up the
	 * configuration object that is returned
	 * to gulpfile.js.
	 ***********************************/

	return {
		moduleRoot: moduleRoot,
		assetsDir: assetsDir,
		assetDirs: assetDirs,
		dist: distDirs,
		distDir: distDir,
		gulpDir: gulpDir,
		paths: paths,

		i18n: i18nSettings,
		icons: iconsSettings,
		images: imageminSettings,
		scripts: scriptsSettings,
		sprites: spriteSettings,
		styles: stylesSettings,
		watch: watchSettings
	};
};