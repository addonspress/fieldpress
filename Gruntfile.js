module.exports=function(grunt){
	'use strict';

	grunt.initConfig({
		
		pkg:grunt.file.readJSON('package.json'),
		
		// Setting folder templates.
		dirs: {
			js: 'assets/js/',
			css: 'assets/css',
			sass: 'assets/scss'
		},
		
		//sass
		sass:{
			options: {
	          style: 'expanded'
	        },
			dist:{
				files:{
					'assets/css/fieldpress.css' : ['assets/scss/main.scss']
				}
			}
		},

		//watch
		watch: {
			css: {
				files: ['assets/scss/**/*.scss'],
				tasks: ['sass']
			}
		},
		//concat
		concat : {
			js: { 
				src: [
					'./assets/js/*.js'
				],
				dest: './assets/js/main.js'
			}
		},

		// Uglify JS.
		uglify: {
			target: {
				options: {
					mangle: true
				},
				files: [{
					expand: true,
					cwd: '<%= dirs.js %>',
					src: ['*.js', '!*.min.js'],
					dest: '<%= dirs.js %>',
					ext: '.min.js'
				}]
			}
		},

		// Copy files to deploy.
		copy: {
			deploy: {
				src: [
					'**',
					'!.*',
					'!*.md',
					'!.*/**',
					'!Gruntfile.js',
					'!package.json',
					'!package-lock.json',
					'!node_modules/**',
					'!npm-debug.log',
					'!assets/scss/**',
					'!assets/js/**'
				],
				dest: 'deploy/<%= pkg.name %>',
				expand: true,
				dot: true
			}
		},

	});

	//load plugins

	// Load NPM tasks to be used here
	grunt.loadNpmTasks( 'grunt-contrib-copy' );
	grunt.loadNpmTasks( 'grunt-contrib-watch' );
	grunt.loadNpmTasks( 'grunt-contrib-sass' );
	grunt.loadNpmTasks( 'grunt-contrib-uglify' );
	grunt.loadNpmTasks( 'grunt-contrib-concat' );

	// Register tasks
	grunt.registerTask( 'default', [ 'sass',] );
	grunt.registerTask( 'css', [ 'sass' ] );
	grunt.registerTask( 'js', [ 'concat', 'uglify' ] );
	grunt.registerTask( 'deploy', [ 'concat', 'sass', 'uglify', 'copy:deploy' ] );
}