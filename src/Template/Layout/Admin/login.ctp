<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = 'Content Manager';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <?= $this->Html->css('http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.css') ?>
    <?= $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css') ?>
    <?= $this->Html->css('admin.css') ?>

    <?= $this->Html->script('https://code.jquery.com/jquery-3.1.1.slim.min.js') ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js') ?>
    <?= $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js') ?>


    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="container-fluid">
    <?= $this->Flash->render() ?>
    <div class="row clearfix">
        <div class="general-content col-12">
            <?= $this->fetch('content') ?>
        </div>
    </div>
    <footer>
    </footer>
</body>
</html>
