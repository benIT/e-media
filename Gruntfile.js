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
                        cwd: 'node_modules/OswaldFont/fonts/ttf',
                        dest: 'web/assets/dist/fonts',
                        src: ['Oswald-Regular.ttf', 'Oswald-Bold.ttf']
                    },
                    {
                        expand: true,
                        cwd: 'node_modules/bootstrap/fonts',
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
                        cwd: 'node_modules/chosen-js/',
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
                        'node_modules/bootstrap/dist/css/bootstrap.min.css',
                        'node_modules/chosen-js/chosen.min.css',
                        'node_modules/slabText/css/slabtext.css',
                        'node_modules/videosjs-assets/dist/video-js.min.css',
                        'node_modules/videojs-qualityselector/dist/videojs-qualityselector.css'
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
                    'node_modules/jquery/dist/jquery.min.js',
                    'node_modules/bootstrap/dist/js/bootstrap.min.js',
                    'node_modules/chosen-js/chosen.jquery.min.js',
                    'node_modules/videosjs-assets/dist/video.min.js',
                    'node_modules/slabText/js/jquery.slabtext.js',
                    'vendor/willdurand/js-translation-bundle/Resources/public/js/translator.min.js',
                    'node_modules/videojs-contrib-hls/dist/videojs-contrib-hls.min.js',
                    'node_modules/videojs-qualityselector/dist/videojs-qualityselector.js',
                ],
                dest: 'web/assets/dist/js/vendors.min.js'
            }
        },
        watch: {
            css: {
                files: ['web/assets/css/*.css'],
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