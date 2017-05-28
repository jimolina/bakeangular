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

I'm working right now on the CakePHP Migrations Files in order to everybody will be able to execute the bin/bake console and set the MySql tables. But for now, you can use this script:

```bash
--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `body` text COLLATE latin1_spanish_ci NOT NULL,
  `image` varchar(100) COLLATE latin1_spanish_ci DEFAULT '',
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `phone` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `category` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `comments` text COLLATE latin1_spanish_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feeds`
--

CREATE TABLE `feeds` (
  `id` int(11) NOT NULL,
  `type` varchar(20) COLLATE latin1_spanish_ci NOT NULL,
  `page` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `user` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `action` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` int(11) NOT NULL,
  `title` varchar(255) COLLATE latin1_spanish_ci NOT NULL,
  `body` text COLLATE latin1_spanish_ci NOT NULL,
  `user_id` int(11) NOT NULL,
  `status_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `parameters`
--

CREATE TABLE `parameters` (
  `id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `value` text COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `location` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `type` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `summary` text COLLATE latin1_spanish_ci NOT NULL,
  `responsibilities` text COLLATE latin1_spanish_ci NOT NULL,
  `skills` text COLLATE latin1_spanish_ci NOT NULL,
  `experience` text COLLATE latin1_spanish_ci NOT NULL,
  `education` text COLLATE latin1_spanish_ci NOT NULL,
  `status_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `postulations`
--

CREATE TABLE `postulations` (
  `id` int(11) NOT NULL,
  `position_id` int(11) NOT NULL,
  `name` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `email` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `resume` varchar(100) COLLATE latin1_spanish_ci NOT NULL,
  `linkedin` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `status`
--

CREATE TABLE `status` (
  `id` int(11) NOT NULL,
  `status` varchar(50) COLLATE latin1_spanish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `todos`
--

CREATE TABLE `todos` (
  `id` int(11) NOT NULL,
  `title` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `description` text COLLATE latin1_spanish_ci NOT NULL,
  `deadline` datetime NOT NULL,
  `status` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `user_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `last_name` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `username` varchar(50) COLLATE latin1_spanish_ci DEFAULT NULL,
  `password` varchar(255) COLLATE latin1_spanish_ci DEFAULT NULL,
  `role` varchar(20) COLLATE latin1_spanish_ci DEFAULT NULL,
  `email` varchar(50) COLLATE latin1_spanish_ci NOT NULL,
  `status_id` int(11) NOT NULL,
  `created` datetime DEFAULT NULL,
  `modified` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_spanish_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `feeds`
--
ALTER TABLE `feeds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `parameters`
--
ALTER TABLE `parameters`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `postulations`
--
ALTER TABLE `postulations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `status`
--
ALTER TABLE `status`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `todos`
--
ALTER TABLE `todos`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;
--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `feeds`
--
ALTER TABLE `feeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;
--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `parameters`
--
ALTER TABLE `parameters`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `postulations`
--
ALTER TABLE `postulations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `status`
--
ALTER TABLE `status`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT for table `todos`
--
ALTER TABLE `todos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
```

## Layout

The app skeleton uses a subset of [Bootstrap 4 Alpha](https://github.com/twbs/bootstrap) CSS
framework by default. You can, however, replace it with any other library or
custom styles.
