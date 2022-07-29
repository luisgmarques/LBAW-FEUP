var gulp = require("gulp");
var php = require("gulp-connect-php");
var sass = require("gulp-sass");
var autoprefixer = require("autoprefixer");
var csspresetenv = require("postcss-preset-env");
var postcss = require("gulp-postcss");
var browserSync = require("browser-sync");
var pgsql = require("gulp-pgsql");

sass.compiler = require("node-sass");

// Auto-prefixer
gulp.task("css", function() {
  var plugins = [csspresetenv(), autoprefixer({ cascade: false })];

  return gulp
    .src(["public/css/*.css"])
    .pipe(postcss(plugins))
    .pipe(gulp.dest("public/css"))
    .pipe(browserSync.stream());
});

// Compile sass into CSS & auto-inject into browsers
gulp.task("sass", function() {
  return gulp
    .src([
      "node_modules/bootstrap/scss/bootstrap.scss",
      "resources/assets/sass/*.scss",
    ])
    .pipe(sass().on("error", sass.logError))
    .pipe(gulp.dest("public/css/"))
    .pipe(browserSync.stream());
});

// Move the javascript files into our /src/js folder
gulp.task("js", function() {
  return gulp
    .src([
      "node_modules/bootstrap/dist/js/bootstrap.min.js",
      "resources/assets/js",
    ])
    .pipe(gulp.dest("public/js"))
    .pipe(browserSync.stream());
});

gulp.task("pgsql", function(done) {
  gulp
    .src(["db/**/*.pgsql"])
    .pipe(
      pgsql("psql://postgres@localhost/postgres")
        .on("error", pgsql.log)
        .on("notice", pgsql.log)
    )
    .on("finish", done);
});

// Static Server + watching scss/html files
gulp.task(
  "server",
  gulp.series("sass", "css", "pgsql", function() {
    php.server(
      {
        base: "./public/",
      },
      function() {
        browserSync.init({
          proxy: "127.0.0.1:8000",
          notify: true,
        });
      }
    );

    gulp.watch(
      ["node_modules/bootstrap/scss/bootstrap.scss", "resources/assets/sass"],
      gulp.series("sass", "css")
    ); 
    //gulp.watch(['db/**/*.pgsql'])
    //.on('change', function(file) {
    //  return gulp.src(file.path)
    //    .pipe(pgsql('psql://postgres@localhost/postgres')
    //    .on('error', pgsql.log)
    //      .on('notice', pgsql.log)
    //    );
    //});
    gulp.watch("./resources/").on("change", function() {
      browserSync.reload();
    }); 
  })
);

gulp.task("default", gulp.series("js", "server"));
