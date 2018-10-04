module.exports = function(grunt) {

    // Configure tasks
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        watch: {
            css: {
                files: ['**/*.scss'],
                tasks: ['sass', 'autoprefixer', 'csscomb'],
                options: {
                    spawn: false,
                    livereload: true,
                }
            }
        },

        sass: {
            dist: {
                options: {
                    style: 'expanded'
                },
                files: {
                    'style.css': 'inc/sass/style.scss'
                }
            }
        },

        autoprefixer: {
            options: {
                browsers: ['> 1%', 'last 2 versions', 'Firefox ESR', 'Opera 12.1', 'ie 9']
            },
            single_file: {
                src: 'style.css',
                dest: 'style.css'
            }
        },

        csscomb: {
            options: {
                config: '.csscomb.json'
            },
            files: {
                'style.css': ['style.css'],
            }
        },

        // Generate RTL stylesheet
        cssjanus: {
            theme: {
                options: {
                    swapLtrRtlInUrl: false
                },
                files: [
                    {
                        src: 'style.css',
                        dest: 'rtl.css'
                    }
                ]
            }
        },

        // Generate POT
        makepot: {
            theme: {
                options: {
                    type: 'wp-theme'
                }
            }
        },

        // browserSync: {
        //   dev: {
        //     bsFiles: {
        //       src: [
        //         '*.css',
        //         '**/*.php',
        //       ],
        //     },
        //     options: {
        //       watchTask: true,
        //       debugInfo: true,
        //       logConnections: true,
        //       notify: true,
        //       proxy: 'theme.dev:8888',
        //       ghostMode: {
        //         scroll: true,
        //         links: true,
        //         forms: true
        //       }
        //     }
        //   }
        // },
    });

    // Sass
    grunt.loadNpmTasks('grunt-contrib-sass');

    // Watch
    grunt.loadNpmTasks('grunt-contrib-watch');

    // CSSComb
    grunt.loadNpmTasks('grunt-csscomb');

    // Autoprefixer
    grunt.loadNpmTasks('grunt-autoprefixer');

    // Replace
    grunt.loadNpmTasks('grunt-string-replace');

    // Shell
    grunt.loadNpmTasks('grunt-shell');

    // Generate POT
    grunt.loadNpmTasks('grunt-wp-i18n');

    // Generate RTL
    grunt.loadNpmTasks('grunt-cssjanus');

    // Browsersync
    //grunt.loadNpmTasks('grunt-browser-sync');

    // Register tasks
    grunt.registerTask('default', [
        'sass',
        'watch',
        'autoprefixer',
        'csscomb',
        'string-replace',
        'shell',
        //'wp-i18n',
        'cssjanus',
        //'browserSync'
    ]);

    // Build for Creative Market
    grunt.registerTask('creative', ['shell', 'string-replace' ]);

};
