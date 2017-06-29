# Simple Back-end Application with CakePHP3 + AngularJS

[![Build Status](https://img.shields.io/travis/cakephp/app/master.svg?style=flat-square)](https://travis-ci.org/cakephp/app)
[![License](https://img.shields.io/packagist/l/cakephp/app.svg?style=flat-square)](https://packagist.org/packages/cakephp/app)

A skeleton for creating backend applications with [CakePHP](http://cakephp.org) 3.x. & [AngularJS](https://angularjs.org/)

The idea for this ALPHA project (I don't know if in the future will be a BETA or a Final First Version), is just use it as testing and learn about CakePhp3 & AngularJS.
I don't want propouse this project as a guide, teaching or demostration of nothing, but I sure it can be very useful for someone out there.

Please be free to use, modify, improve, change it and/or whatever you want. All the pull request are welcome.

These frameworks source code can be found here: [cakephp/cakephp](https://github.com/cakephp/cakephp). & [AngularJS](https://github.com/angular/angular.js)

## Important NOTE

I'm using [Bootstrap 4 Alpha](https://github.com/twbs/bootstrap) just because I want learn and check the new css rules, code, etc. When Bootstrap 4 finaly will release it, I'll be updating this project (I think!!!).


## Installation

1. In order to use this code, you will need have instaled CakePhp3. Go to the framework repository to install it first.
2. Clone or download this repository and install/save in your localserver.

## Configuration Data Base

```bash
bin/cake migrations migrate
```
## How to use Browsersync

You will need install browsersync and gulp: 

```bash
$ npm install browser-sync gulp --save-dev
```
After that, just execute the command:

```bash
$ gulp
```

That will be execute the file gulpfile.js and then everytime you change a CSS file, the browsersync will be make the magic!

## Layout

The app skeleton uses a subset of [Bootstrap 4 Alpha](https://github.com/twbs/bootstrap) CSS
framework by default. You can, however, replace it with any other library or
custom styles.

## TODO
* ~~Execute the Migration CakePHP command to create the MySql tables~~
* ~~Integrate Browsersync component~~
* ~~IAdd a Setting config section~~I
* ~~IAdd a way to select a different color set~~I
* Add a new section for Image Galleries
