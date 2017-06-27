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

    <?= $this->Html->css('https://cdnjs.cloudflare.com/ajax/libs/simple-line-icons/2.4.1/css/simple-line-icons.css') ?>
    <?= $this->Html->css('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css') ?>
    <?= $this->Html->css('../bower_components/summernote/dist/summernote.css') ?>
    <?= $this->Html->css('admin.css') ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body class="container-fluid" ng-app="adminBase" ng-controller="generalController">
    <nav class="top-bar row hidden-print" data-topbar role="navigation">
        <div class="col-6">
            <h1 class="title">Admin Base</h1>
        </div>
        <div class="col-6">
            <ul class="nav justify-content-end align-middle">
                <li class="nav-item">
                    Welcome back <?= $loginUserName; ?> | 
                    <a href="<?php echo $this->Url->build(array('controller'=>'users','action'=>'logout')) ?>">
                        <i class="icon-logout"></i> Logout
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="clearfix"></div>
    <?= $this->Flash->render() ?>
    <div class="page-wrapper">
        <div class="menu-sidebar hidden-print">
            <?php
                echo $this->element('admin/menu');
            ?>
        </div>
        <div class="content-wrapper" id="<?= strtolower($this->request->controller) ?>">
            <div class="content container-fluid">
                <div class="content-title">
                    <p class="visible-print-block"><?= $titlePage; ?></p>
                    <h3 class="hidden-print"><?= $titlePage; ?>
                        <small class="text-muted"><?= $descriptionPage; ?></small>
                    </h3>
                </div>
                <div class="breadcrumb hidden-print">
                    <?= $this->AdminBreadcrumb->breadcrumb() ?>
                </div>
                <?= $this->fetch('content') ?>
            </div>
        </div>
        <!-- Messages Alerts -->
        <div id="alert-block" class="alert alert-{{ msn.type }} alert-dismissible  animate-show animate-hide" ng-show="notification" ng-if="msn.content" role="alert" ng-cloak>
            {{ msn.content }}
        </div>
        <!-- End Messages Alerts -->
        <!-- Confirmation Modal -->
        <div class="modal fade confirmation-delete" tabindex="-1" role="dialog" aria-labelledby="ConfirmationDelete" id="ConfirmationDelete" aria-hidden="true">
            <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-body">
                        Are you sure you want to delete this record?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-success btn-sm" data-dismiss="modal" ng-click="deleteRecordConfirm()" ng-page="" ng-record="" id="delConfirm">Yes</button>
                        <button type="button" class="btn btn-outline-danger btn-sm" data-dismiss="modal">No</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Confirmation Modal -->
    </div>
    <div class="page-footer hidden-print">
        2016 © Theme by <a href="http://josemolinaresume.com" target="_Blank">Jose Molina</a> licensed under <a href="https://en.wikipedia.org/wiki/MIT_License" target="_Blank">MIT License</a> for YOUR COMPANY NAME
    </div>
</body>
    <?= $this->Html->script('https://code.jquery.com/jquery-3.1.1.slim.min.js') ?>
    <?= $this->Html->script('https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js') ?>
    <?= $this->Html->script('https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js') ?>
    <?= $this->Html->script('https://ajax.googleapis.com/ajax/libs/angularjs/1.6.3/angular.min.js') ?>
    <?= $this->Html->script('vendor/dirPagination.js') ?>
    <?= $this->Html->script('vendor/ui-bootstrap-tpls-2.5.0.min.js') ?>
    <?= $this->Html->script('../bower_components/summernote/dist/summernote.min.js') ?>
    <?= $this->Html->script('../bower_components/angular-summernote/dist/angular-summernote.min.js') ?>
    <?= $this->Html->script('adminBase.js') ?>
    <?= $this->Html->script('adminBaseController.js') ?>
    <?= $this->Html->script('adminBaseFactory.js') ?>
    <?= $this->Html->script('adminBaseService.js') ?>
    <script id="__bs_script__">//<![CDATA[
        document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.18.12'><\/script>".replace("HOST", location.hostname));
    //]]></script>
</html>
