'use strict';
module.exports = function (grunt) {

    // load all grunt tasks
    require('matchdep').filterDev('grunt-*').forEach(grunt.loadNpmTasks);

    grunt.initConfig({

        pkg: grunt.file.readJSON('package.json'),

        // Define watch tasks
        watch: {
            options: {
                livereload: true
            },
            sass: {
                files: ['assets/sass/**/*.scss', '!assets/sass/admin/**/*.scss'],
                tasks: ['sass:front', 'autoprefixer:front', 'notify:sass']
            },
            sass_admin: {
                files: ['assets/sass/admin/**/*.scss'],
                tasks: ['sass:admin', 'autoprefixer:admin', 'notify:sass_admin']
            },
            js: {
                files: ['assets/js/*.js'],
                tasks: ['uglify:front', 'notify:js']
            },
            js_admin: {
                files: ['assets/js/admin/*.js'],
                tasks: ['uglify:admin', 'notify:js_admin']
            },
            livereload: {
                files: ['**/*.html', '**/*.php', 'assets/images/**/*.{png,jpg,jpeg,gif,webp,svg}', '!**/*ajax*.php']
            }
        },

        // SASS
        sass: {
            options: {
                sourceMap: true
            },
            front: {
                files: {
                    'style.css': 'assets/sass/main.scss'
                }
            },
            admin: {
                files: {
                    'admin.css': 'assets/sass/admin/admin.scss'
                }
            }
        },

        // Auto prefix our CSS with vendor prefixes
        autoprefixer: {
            options: {
                map: true
            },
            front: {
                src: 'style.css'
            },
            admin: {
                src: 'admin.css'
            }
        },

        // Uglify and concatenate
        uglify: {
            options: {
                sourceMap: true
            },
            front: {
                files: {
                    'script.js': [
                        // Vendor files
                        'assets/vendor/js/modernizr.js',
                        'assets/vendor/js/fastclick.js',
                        'assets/vendor/js/placeholder.js',
                        'assets/vendor/js/jquery.cookie.js',
                        'assets/vendor/js/foundation/foundation.js',

                        // Included dynamically in header.php
                        '!assets/vendor/js/html5.js',

                        // Theme scripts
                        'assets/js/*.js'
                    ]
                }
            },
            admin: {
                files: {
                    'admin.js': [
                        'assets/js/admin/*.js'
                    ]
                }
            }
        },

        notify: {
            js: {
                options: {
                    title: '<%= pkg.name %>',
                    message: 'JS Complete'
                }
            },
            js_admin: {
                options: {
                    title: '<%= pkg.name %>',
                    message: 'JS Admin Complete'
                }
            },
            sass: {
                options: {
                    title: '<%= pkg.name %>',
                    message: 'SASS Complete'
                }
            },
            sass_admin: {
                options: {
                    title: '<%= pkg.name %>',
                    message: 'SASS Admin Complete'
                }
            }
        }

    });

    // Register our main task
    grunt.registerTask('Watch', ['watch']);
};