<div class="col-4">
    <a href="#" class="btn btn-success btn-sm pt-2" data-toggle="modal" data-target=".edit-record" ng-click="addRecord()">
        <i class="icon-plus pr-1"></i> Add New
    </a>
</div>
<div class="col-8 text-right">
    <a class="btn btn-action btn-sm" title="Filters" data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
        <i class="icon-equalizer"></i>
    </a>
    <a class="btn btn-action btn-sm" title="Refresh" href="#" ng-click="refresh('<?= $page ?>/summaryJson')">
        <i class="icon-refresh"></i>
    </a>
    <div class="btn-group btn-group__simple" role="group">
        <a id="btnGroupDrop1"  class="btn btn-action btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="icon-options-vertical"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
            <a class="dropdown-item" href="#" ng-click="print()"><i class="icon-printer"></i> Print</a>
            <a class="dropdown-item" href="<?= $page ?>/export" target="_Blank"><i class="icon-cloud-download"></i> Export to Excel</a>
        </div>
    </div>
</div>