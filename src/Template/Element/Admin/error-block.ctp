<!-- Messages Errors Alerts -->
<div id="alert-error-block" class="alert alert-fix alert-danger alert-dismissible" ng-show="notificationErrors" role="alert" ng-cloak>
    {{ msnError.content }}
    <ul>
        <li ng-repeat="(title, error) in msnError.errors">
             <span ng-repeat="(type, message) in error"><b>{{ title | uppercase }}:</b> {{ message }}</span>
        </li>
    </ul>
</div>