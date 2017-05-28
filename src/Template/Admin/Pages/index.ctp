<?php
/**
  * @var \App\View\AppView $this
  */
 ?>
<div class="card data-grid-container container-fluid" data-ng-init="refresh('pages/summaryJson')">
    <div class="card-header row no-gutters hidden-print">
        <?= $this->element('admin/header-grid', ['page' => 'pages']); ?>
    </div>
    <div class="card-block">
        <div class="filter-container collapse" id="collapseFilters">
            <div class="card card-block">
                <h5>Filters:</h5>
                <div class="form">
                    <?= $this->Form->create("", ["class"=>"form-inline"]) ?>
                        <?= $this->Form->label('Title:'); ?>
                        <?= $this->Form->control('title', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'title', 'ng-model' => 'valFilter.title', 'required' => false]) ?>
                        <?= $this->Form->label('Body:'); ?>
                        <?= $this->Form->control('body', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'body', 'ng-model' => 'valFilter.body', 'required' => false]) ?>
                        <?= $this->Form->label('Owner:'); ?>
                        <select ng-model="valFilter.owner" class="form-control form-control-sm">
                            <option value="null" class="ng-binding ng-scope data-missing">Data Missing</option>
                            <option ng-repeat="row in rows | unique: 'owner'">{{ row.owner }}</option>
                        </select>
                        <?= $this->Form->label('Status:'); ?>
                        <select ng-model="valFilter.status" class="form-control form-control-sm">
                            <option value="null" class="ng-binding ng-scope data-missing">Data Missing</option>
                            <option ng-repeat="row in rows | unique: 'status'">{{ row.status }}</option>
                        </select>
                        <?= $this->Form->button(__('Clear'), ['type' => 'reset', 'class' => 'btn btn-outline-primary btn-sm animate-show-hide', 'ng-show' => 'valFilter', 'ng-click' => 'clearGridFilter()']); ?>
                    <?= $this->Form->end() ?>
                </div>
            </div>
        </div>
        <div class="data-grid table-responsive">
            <table class="table table-striped table-bordered table-hover table-sm">
                <thead class="thead-default">
                    <tr>
                        <th ng-click="sort('id')">
                            Id <span class="icon-order" ng-show="sortKey=='id'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('title')">
                            Title <span class="icon-order" ng-show="sortKey=='title'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('body')">
                            Body <span class="icon-order" ng-show="sortKey=='body'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('owner')">
                            Owner <span class="icon-order" ng-show="sortKey=='owner'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('status')">
                            Status <span class="icon-order" ng-show="sortKey=='status'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th class="header-action hidden-print"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-show="loading">
                        <td colspan="6">
                            <?= $this->element('admin/spinner-grid'); ?>
                        </td>
                    </tr>
                    <tr ng-class="{'has-error': !row.owner || !row.status, '': row.owner || row.status}" dir-paginate="row in rows | filter:{title:valFilter.title} | filter:{body:valFilter.body} | filter:{owner:valFilter.owner} | filter:{status:valFilter.status} | orderBy:sortKey:reverse | itemsPerPage:pageSize as results" ng-cloak>
                        <td>{{ row.id }}</td>
                        <td>{{ row.title }}</td>
                        <td ng-bind-html="row.body | trust"></td>
                        <td ng-class="{'has-error':!row.owner,'':row.owner}">{{ row.owner | missingRelationship }}</td>
                        <td ng-class="{'has-error':!row.status,'':row.status}">{{ row.status | missingRelationship }}</td>
                        <td class="icon-action hidden-print">
                            <div class="btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="#" class="btn btn-secondary view btn-outline-info" data-toggle="modal" data-target=".view-record" 
                                    ng-click="viewRecord($index)" title="view"><i class="icon-eye"></i></a>
                                <a role="button" href="#" class="btn btn-secondary edit btn-outline-primary" data-toggle="modal" data-target=".edit-record" 
                                    ng-click="editRecord('pages/viewJson', row.id )" title="Edit"><i class="icon-note"></i></a>
                                <a role-"button" href="#" data-toggle="modal" data-target=".confirmation-delete" class="btn btn-secondary delete btn-outline-danger" 
                                    ng-click="deleteRecord('pages/deleteJson', row.id)" title="Delete"><i class="icon-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr class="animate-repeat" ng-if="results.length === 0" ng-cloak>
                        <td colspan="6"><strong>No results found with that criteria filter</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>  
    </div>
    <div class="card-footer hidden-print">
        <div class="row">   
            <div class="col-6">
                Total record(s): {{ rows.length }}
            </div>
            <div class="col-6">
                <dir-pagination-controls direction-links="true" boundary-links="true"></dir-pagination-controls>
            </div>
        </div>
    </div>
</div>

<!-- View modal -->
<div class="modal fade view-record" tabindex="-1" role="dialog" aria-labelledby="ViewRecord" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Detail</strong> Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="pages view">
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Id') ?></h5>
                            <div class="data">
                                {{ rowsDetail.id }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Title') ?></h5>
                            <div class="data">
                                {{ rowsDetail.title }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Body') ?></h5>
                            <div class="data" ng-bind-html="rowsDetail.body | trust"></div>
                        </div>
                    </div>
                    <div class="card" ng-class="{'has-error':!rowsDetail.owner,'':rowsDetail.owner}">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Owner') ?></h5>
                            <div class="data">
                                {{ rowsDetail.owner | missingRelationship }}
                            </div>
                        </div>
                    </div>
                    <div class="card" ng-class="{'has-error':!rowsDetail.status,'':rowsDetail.status}">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Status') ?></h5>
                            <div class="data">
                                {{ rowsDetail.status | missingRelationship }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Add/Edit modal -->
<div class="modal fade edit-record" tabindex="-1" id="EditRecordModal" role="dialog" aria-labelledby="EditRecord" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Edit</strong> Record</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= $this->element('admin/error-block'); ?>
            <?= $this->Form->create('', ['name' => 'formEditRow', 'type' => 'file']) ?>
                <div class="modal-body">
                    <div class="pages edit">
                        <div class="card" ng-show="rowsEdit.id">
                            <div class="card-block">
                                <h5 class="card-title trans"><?= __('Id') ?></h5>
                                <div class="data">
                                    {{ rowsEdit.id }}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Title:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedTitle || rowsEdit.title}']); ?>
                                <?= $this->Form->control('title', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '100', 'id' => 'title', 'ng-model' => 'rowsEdit.title', 'ng-change' => 'hasChangedTitle = true', 'ng-blur' => 'hasFocusTitle = false', 'required' => true]) ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Body:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedBody || rowsEdit.body}']); ?>
                                <div class="input">
                                    <summernote config="summerOptions" ng-model="rowsEdit.body" ng-change="hasChangedBody = true" required="required"></summernote>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block" data-ng-init="getCombobox('statusOptions', 'pages/getStatusOptions')">
                                <?= $this->Form->label('Status:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedStatus || rowsEdit.status}']); ?>
                                <select ng-model="rowsEdit.status_id" class="form-control form-control-sm" ng-change="hasChangedStatus" required="required">
                                    <option style="display:none" value="">select a type</option>
                                    <option value="{{ statusOption.id }}" ng-repeat="statusOption in statusOptions" ng-selected="rowsEdit.status==statusOption.status">{{ statusOption.status }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="mr-auto"><small>(*) requiered</small></span>
                    <button type="button" class="btn btn-success btn-sm" ng-click="saveRecord('pages', rowsEdit.id)">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>