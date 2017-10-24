module.exports = function (grunt) {
    require('load-grunt-tasks')(grunt);
    // Project configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),
        concurrent:
        {
            target:
            {
                tasks: ["watch:sass", "watch:csssplit", "watch:uglify"],
                options:{
                    logConcurrentOutput: true
                }
            }
        },
        watch:
        {
            sass:
            {
                files: 'css/**/*',
                tasks: ['sass'],
            },

            uglify:
            {
                files: ['javascript/*'],
                tasks: ['uglify']
            }
        },

        sass: {
            dist: {
                options: {
                    style: 'compressed'
                },
                files: {
                    '../css/main.min.css': 'css/main.scss'
                }
              
            }
        },
        uglify: {
            options: {
                mangle: false,
                compress: false
            },
            target: {
                files: {
                    '../scripts/main.min.js': [
                        'javascript/main.js',
                    ],

                    '../scripts/plugins.min.js': [
                        'javascript/vendor/jquery/jquery-3.2.1.min.js',
                        'javascript/vendor/bootstrap/bootstrap/transition.js',
                        'javascript/vendor/bootstrap/bootstrap/alert.js',
                        'javascript/vendor/bootstrap/bootstrap/button.js',
                        'javascript/vendor/bootstrap/bootstrap/carousel.js',
                        'javascript/vendor/bootstrap/bootstrap/collapse.js',
                        'javascript/vendor/bootstrap/bootstrap/dropdown.js',
                        'javascript/vendor/bootstrap/bootstrap/modal.js',
                        'javascript/vendor/bootstrap/bootstrap/tooltip.js',
                        'javascript/vendor/bootstrap/bootstrap/popover.js',
                        'javascript/vendor/bootstrap/bootstrap/scrollspy.js',
                        'javascript/vendor/bootstrap/bootstrap/tab.js',
                        'javascript/vendor/bootstrap/bootstrap/affix.js',
                    ]
                }
            }
        }

    });

    grunt.registerTask("default", ['sass']);

};
