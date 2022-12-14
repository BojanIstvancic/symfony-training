# Cheatsheet

```php
// LIST ALL COMMANDS
symfony console list doctrine
// SERVER
symfony server:start
symfony server:stop

// all available routes 
symfony console debug:router

// remove force movies folder
-rm -rf movies 

// CONTROLLER
symfony console make:controller RouteDataController 
// created in controller/RouteDataController.php
// here we query data using the repository
// there are built in methods and also methods that can be custom defined

// DATABASE

DATABASE_URL="mysql://root:passwordIfYouHave@127.0.0.1:3306/movies?serverVersion=8&charset=utf8mb4" //env - update database url to mysql
symfony console doctrine:database:create // create

// ENTITY - table 
symfony console make:entity Movies

// src/Entity/Movie.php
// src/Repository/MovieRepository.php
// then add property names (column names)
name/type/length/ifIsNullable
title/string/255/no
year/integer/no
description/string/255/yes
imagePath/string/255/no

// ctrl+c when we are done to interupt further creation

// RELATIONSHIPS
// ManyToOne - many students are working on one project, one project has many students
//  (students, projects, student_projects - pivot table [student_id, project_id ])
// OneToMany - one country can have multiple states, one state is located in only one country
// OneToOne - one person has one hearth, one hearth has one person
// ManyToMany - many movies have many actors

// update Movies entity
symfony console make:entity   
// add new proprty
actors/ManyToMany/Actor/yes/enter (not movies)

// now we need to migrate the entities to the tables
// MIGRATE
symfony console make:migration
// migration created in migrations folder (we can check the code)
symfony console doctrine:migrations:migratef
// make migration
yes then enter

// ADD DATA
// add movies data
// create MovieFixtures.php file inside DataFixtures folder
// create Actor.php file inside DataFixtures folder

symfony console doctrine:fixtures:load // perform this command to add the data inside the movies table

App\DataFixtures\AppFixtures

// DEPENDANCIES
  composer require twig // twig - views
  composer require symfony/orm-pack // pack so we can use doctrine
  composer require --dev symfony/maker-bundle // snippets (--dev - just for development)
  composer require --dev doctrine/doctrine-fixtures-bundle // add dummy data for testing 

  composer require symfony/webpack-encore-bundle // webpack helper - compile assets
  // adds package.json, webpack.config.js and assets folder
  // npm install
  // npm run dev - after we make some changes in assets folder to compile the changes
  // npm run watch -the same as above but better

  composer require symfony/asset // use assets generated by webpack-encore-bundle

  // base.html.twig -> update
  /*
    {% block stylesheets %}
      {{ encore_entry_link_tags('app') }}
    {% endblock %}

    to this

    {% block stylesheets %}
			<link rel="stylesheet" href="{{asset('build/app.css')}}">
		{% endblock %}
    */

    // add entry in assets/app.js or in webpack.config.js
    // add method2  in twig templates - method1 is already added
    /* 
    {% block javascripts %}
			{{ encore_entry_script_tags('app') }}
			{{ encore_entry_script_tags('method2') }} // here
		{% endblock %}
    */

    // npm install -D tailwindcss postcss-loader purgecss-webpack-plugin glob-all path - add tailwind
    // npx tailwindcss init -p
    update postcss.config.js
    /*
    let tailwindcss = require("tailwindcss");

    module.exports = {
      plugins: [
        tailwindcss("./tailwind.config.js"),
        require("postcss-import"),
        require("autoprefixer"),
      ],
    };
    */
    update webpack.config.js  // add these things 
    /*   
    .enablePostCssLoader((options) => {
      options.postcssOptions = {
        config: "./postcss.config.js",
      };
    })
  */

  update app.js // add these things

  /*
  @tailwind base;
  @tailwind components;
  @tailwind utilities;*
  */

  update tailwind.config.js
  // module.exports = {
  //   content: [
    // "./assets/**/*.{vue,js,ts,jsx,tsx}",
    // "./templates/**/*.{html,twig}",
  //   ],
  //   theme: {
  //     extend: {},
  //   },
  //   plugins: [],
  // };

  // npx tailwindcss -i ./assets/styles/app.css -o ./public/build/app.css --watch // compile tailwind


  // add image to twig file 
  // 1st option, not the best
  // add image to public/images/ folder (create images folder if doesn't exist)
  // 	<img src="{{asset('images/image1.jpg')}}" alt="image-1"/> - add image in twig file

  // 2nd option
  // npm install file-loader --save-dev - add file loader
  // add assets/images - folder, move image from public to this folder
  /*
  update webpack config

    .copyFiles({
      from: "./assets/images/",
      to: "images/[path][name].[hash:8].[ext]",
      pattern: /\.(png|jpeg|jpg)$/,
  });
  */
  // run npm run dev - to build the files
  // <img src="{{asset('build/images/image1.d45c4dc8.jpg')}}" alt="image-1"/> - update image src
  composer require symfony/form // use symfony forms (create.twig)
  symfony console make:form MovieFormType Movie // create a form and associate the model with it(MOVIE)
  //  created: src/Form/MovieFormType.php  - form is created here
  //  src/Form/MovieFormType.php - update formField types 
  // pull the form in create.html.twig

   composer require symfony/mime
```
