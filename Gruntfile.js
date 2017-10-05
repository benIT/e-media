module.exports = function (grunt) {
    require('load-grunt-tasks')(grunt);
    grunt.initConfig({
        clean: {
            assets: ['web/assets'],
        },
        copy: {
            fonts: {
                files: [
                    {
                        expand: true,
                        cwd: 'bower_components/OswaldFont/fonts/ttf',
                        dest: 'web/assets/dist/fonts',
                        src: ['Oswald-Regular.ttf', 'Oswald-Bold.ttf']
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/bootstrap/fonts',
                        dest: 'web/assets/dist/fonts',
                        src: ['**']
                    }],
            },
            image: {
                files: [
                    {
                        expand: true,
                        cwd: 'app/Resources/assets/image',
                        dest: 'web/assets/dist/image',
                        src: ['**']
                    },
                    {
                        expand: true,
                        cwd: 'bower_components/chosen/',
                        dest: 'web/assets/dist/css',
                        src: ['chosen-sprite.png']
                    }
                ]
            },
        },
        cssmin: {
            options: {
                report: 'gzip',
                keepSpecialComments: 0,
                sourceMap: true,
                outputSourceFiles: true
            },
            target: {
                files: {
                    'web/assets/dist/css/vendors.min.css': [
                        'bower_components/bootstrap/dist/css/bootstrap.min.css',
                        'bower_components/chosen/chosen.min.css',
                        'bower_components/slabText/css/slabtext.css',
                        'bower_components/video.js/dist/video-js.css',
                    ],
                    'web/assets/dist/css/app.min.css': [
                        'app/Resources/assets/css/jumbotron-narrow.css',
                        'app/Resources/assets/css/custom.css',
                    ],
                }
            }
        },
        uglify: {
            options: {
                mangle: false,
                sourceMap: true,
                sourceMapIncludeSources: true,
            },
            app: {
                files: {
                    'web/assets/dist/js/app.min.js': [
                        'app/Resources/assets/js/*',
                    ]
                }
            }
        },
        concat: {
            options: {
                separator: grunt.util.linefeed + grunt.util.linefeed,
            },
            vendors: {
                src: [
                    'bower_components/jquery/dist/jquery.min.js',
                    'bower_components/bootstrap/dist/js/bootstrap.min.js',
                    'bower_components/chosen/chosen.jquery.min.js',
                    'bower_components/video.js/dist/video.js',
                    'bower_components/slabText/js/jquery.slabtext.js'

                ],
                dest: 'web/assets/dist/js/vendors.min.js'
            }
        },
        watch: {
            css: {
                files: ['app/Resources/assets/css/*'],
                tasks: ['cssmin']
            },
            js: {
                files: ['app/Resources/assets/js/*.js'],
                tasks: ['uglify']
            },
            image: {
                files: ['app/Resources/assets/image/*'],
                tasks: ['copy']
            },
        },

    });
    grunt.registerTask('default', ["copy", "cssmin", "uglify", "concat"]);
};