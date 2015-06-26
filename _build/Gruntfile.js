module.exports = function(grunt) {
 
    // Project configuration.
    grunt.initConfig({
 
        //Read the package.json (optional)
        pkg: grunt.file.readJSON('package.json'),
 
        // Metadata.
        meta: {
            basePath: '../',
            srcPath: '../Smof/',
            deployPath: '../Smof/Assets/'
        },
 
        banner: '/*! <%= pkg.name %> - v<%= pkg.version %> - ' +
                '<%= grunt.template.today("yyyy-mm-dd") %>\n' +
                '* Copyright (c) <%= grunt.template.today("yyyy") %> ',
		/*
		sass: {                              // Task
			dist: {                            // Target
			  options: {                       // Target options
				style: 'expanded'
			  },
			  files: {                         // Dictionary of files
				'main.css': 'main.scss',       // 'destination': 'source'
				'widgets.css': 'widgets.scss'
			  }
			}
		}
		*/
 
        // Task configuration.
        concat: {
            options: {
                stripBanners: true
            },
            js: {
                src: [
					'<%= meta.srcPath %>Assets/Js/smof.js', 
					'<%= meta.srcPath %>Fields/*/*.js'
				],
                dest: '<%= meta.deployPath %>Scripts/smof_all.js'
            },
			css: {
                src: [
					'<%= meta.srcPath %>Assets/Css/style.css', 
					'<%= meta.srcPath %>Fields/*/*.css'
				],
                dest: '<%= meta.deployPath %>Css/style_all.css'
            }
        }
    });
 
    // These plugins provide necessary tasks.
    grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-newer');
	/*
	grunt.loadNpmTasks('grunt-contrib-sass');
	*/
 
    // Default task
    grunt.registerTask('default', ['newer:concat']);
 
};