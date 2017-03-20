module.exports = function(grunt) {

	grunt.initConfig({
		
		pkg: grunt.file.readJSON('package.json'),
		
		watch : {
			
			scripts : {
				
				files: [
                    'js/source/**.js',
                ],
    			tasks: ['concat','uglify'],
				
			},
			
			css : {
				
				files: [
                    'css/source/**.scss'
                ],
    			tasks: ['concat','sass'],
				
			},
			
			cpy : {
				
				files: ['css/*.css'],
    			tasks: ['copy'],
				
			}
			
		}, /* END - WATCH */
		
		copy : {
			
			main : {
				
				files : [
					
					{
						expand: true, 
						src: [
								'node_modules/jquery/dist/jquery.min.js',
								'node_modules/angular/angular.min.js',
								'node_modules/jquery-mask-plugin/dist/jquery.mask.min.js',
								'node_modules/bootstrap/dist/js/bootstrap.min.js',
								'node_modules/sweetalert/dist/sweetalert.min.js',
								'node_modules/angular-route/angular-route.min.js',
								'node_modules/angular-animate/angular-animate.min.js',
                                'node_modules/jquery-validation/dist/jquery.validate.js',
                                'node_modules/multiple-select/multiple-select.js',
                                'node_modules/datatables.net/js/jquery.dataTables.js',
                                'node_modules/perfect-scrollbar/dist/js/min/perfect-scrollbar.jquery.min.js',
                                'node_modules/react/dist/react.min.js',
                                'node_modules/react/dist/react-with-addons.min.js'
							], 
						dest: '../public/js/vendor/', 
						filter: 'isFile',
						flatten: true
					},
					
				]
				
			},
			
			css : {
				
				files : [
					
					{
						expand: true, 
						src: [
								'css/*.css',
                                'node_modules/multiple-select/multiple-select/multiple-select.css',
                                'node_modules/perfect-scrollbar/dist/css/perfect-scrollbar.min.css'
							], 
						dest: '../public/css/vendor/', 
						filter: 'isFile',
						flatten: true
					},
					
				]
				
			}
			
		}, /* END - COPY */
		
		concat : {
			
			'public-custom' : {
				src : ['js/source/**.js'],
				dest : 'js/base-concat-final.js'
			},
			
			'public-scss' : {
				src : ['css/source/*.scss'],
				dest : 'css/base.scss'
			},
            
						
		}, /* END - CONCAT */
		
		uglify: {
			
			'public-custom' : {
				
				files : {
					'../public/js/base.min.js' : ['js/base-concat-final.js']					
				}
				
			}
								
		}, /* END - UGLIFY */

		sass : {
			
			css : {
				
				options : {
					
					style : 'compressed',
					
				},
				
				files : {
					
					'../public/css/vendor/sweetalert.min.css' : 'node_modules/sweetalert/dev/sweetalert.scss',
					'../public/css/base.min.css' : 'css/base.scss'
					
				}
				
			}
			
		} /* END - SASS */
		
		
	});

	/* Load the plugin */
	grunt.loadNpmTasks('grunt-contrib-watch');
	grunt.loadNpmTasks('grunt-contrib-concat');
	grunt.loadNpmTasks('grunt-contrib-uglify');
	grunt.loadNpmTasks('grunt-contrib-copy');
	grunt.loadNpmTasks('grunt-contrib-sass');
	
	/* Default task(s) */
	grunt.registerTask('default', ['copy','concat','uglify','sass']);

};