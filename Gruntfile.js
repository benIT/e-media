module.exports = function (grunt) {
    require('load-grunt-tasks')(grunt);
    grunt.initConfig({
        clean: {
            assets: ['web/assets/dist'],
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
                        cwd: 'web/assets/image',
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
                root: 'web/assets/dist/css/',
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
                        'web/assets/css/jumbotron-narrow.css',
                        'web/assets/css/custom.css',
                    ],
                }
            }
        },
        uglify: {
            options: {
                mangle: false,
                sourceMap: true,
                // sourceMapIncludeSources: true,
            },
            app: {
                files: {
                    'web/assets/dist/js/app.min.js': [
                        'web/assets/js/*js',
                    ]
                }
            },
            translation: {
                files: [{
                    expand: true,
                    cwd: 'web/assets/js/translations/',
                    src: ['*.js', '!*.min.js'],
                    dest: 'web/assets/dist/js/translations',
                    ext: '.min.js'
                }]
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
                    'bower_components/slabText/js/jquery.slabtext.js',
                    'vendor/willdurand/js-translation-bundle/Resources/public/js/translator.min.js'

                ],
                dest: 'web/assets/dist/js/vendors.min.js'
            }
        },
        watch: {
            css: {
                files: ['web/assets/css/*'],
                tasks: ['cssmin']
            },
            js: {
                files: ['web/assets/js/*.js'],
                tasks: ['uglify:app']
            },
            image: {
                files: ['web/assets/image/*'],
                tasks: ['copy']
            },
        },

    });
    grunt.registerTask('default', ["copy", "cssmin", "concat", "uglify"]);
};