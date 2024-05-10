const gulp        = require( 'gulp' );
const sass        = require( 'gulp-sass' )( require( 'sass' ) );
const sourcemaps  = require( 'gulp-sourcemaps' );
const cleanCSS    = require( 'gulp-clean-css' );
const browserSync = require( 'browser-sync' ).create();
const file_system = require( 'fs' );
const uglify      = require( 'gulp-uglify' );
const pump        = require( 'pump' );
const wp_pot      = require( 'gulp-wp-pot' );

// const update_assets_version = function () {
// 	file_system.writeFile( './assets/last_update', ( new Date() ).toISOString().replace( /[^0-9]/g, '' ), function ( error ) {
// 		if ( error ) {
// 			return console.log( error );
// 		}
//
// 		console.log( "The file was saved!" );
// 	} );
// };

// gulp.task( 'make_pot', function ( done ) {
// 	gulp.src( './**/*.php' )
// 	.pipe( wp_pot( {
// 		domain         : 'test-plugin',
// 		package        : 'Test plugin',
// 		headers        : {
// 			poedit                  : true,
// 			'x-poedit-keywordslist' : true
// 		},
// 		lastTranslator : 'Ysh <y.sheshenov@gmail.com>'
// 	} ) )
// 	.pipe( gulp.dest( './languages/template.pot' ) );
//
// 	done();
// } );

gulp.task( 'styles', function ( done ) {
	gulp.src( [ './assets/admin/src/css/**/*.scss' ] )
	.pipe( sourcemaps.init() )
	.pipe( sass().on( 'error', sass.logError ) )
	.pipe( cleanCSS( { compatibility : 'ie8' } ) )
	.pipe( sourcemaps.write( './maps' ) )
	.pipe( gulp.dest( './assets/admin/dist/css/' ) )
	.pipe( browserSync.stream() );
	done();
} );

gulp.task( 'styles_admin', function ( done ) {
	gulp.src( [ './assets/front/src/css/**/*.scss' ] )
		.pipe( sourcemaps.init() )
		.pipe( sass().on( 'error', sass.logError ) )
		.pipe( cleanCSS( { compatibility : 'ie8' } ) )
		.pipe( sourcemaps.write( './maps' ) )
		.pipe( gulp.dest( './assets/front/dist/css/' ) )
		.pipe( browserSync.stream() );
	done();
} );

gulp.task( 'compress_js', function ( done ) {
	pump( [
		gulp.src( './assets/front/src/js/**/*.js' ),
		uglify( {
			mangle : {
				eval : true
			}
		} ),
		gulp.dest( './assets/front/dist/js/' )
	], done );

} );


gulp.task( 'compress_js_admin', function ( done ) {
	pump( [
		gulp.src( './assets/admin/src/js/**/*.js' ),
		uglify( {
			mangle : {
				eval : true
			}
		} ),
		gulp.dest( './assets/admin/dist/js/' )
	], done );

} );

const start_watch_assets = function () {
	gulp.watch( [
		'assets/admin/src/css/**/*.scss',
		'assets/front/src/css/**/*.scss',
	], gulp.series( ['styles','styles_admin'] ) );

	gulp.watch( [
		'assets/front/src/js/**/*.js', 'assets/admin/src/js/**/*.js'
	], gulp.series( 'compress_js', 'compress_js_admin' ) );

};

gulp.task( 'watch_assets', gulp.series( 'styles', 'styles_admin', 'compress_js', 'compress_js_admin', function ( done ) {
	start_watch_assets();
	done();
} ) );

gulp.task( 'serve', gulp.series( 'styles', 'compress_js', function ( done ) {
	browserSync.init( {
		proxy : "localhost"
	} );

	start_watch_assets();
	done();
} ) );
