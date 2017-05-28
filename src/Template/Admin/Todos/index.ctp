<?php
/**
  * @var \App\View\AppView $this
  */
 ?>
<div class="card data-grid-container container-fluid" data-ng-init="refresh('todos/summaryJson')">
    <div class="card-header row no-gutters hidden-print">
        <?= $this->element('admin/header-grid', ['page' => 'todos']); ?>
    </div>
    <div class="card-block">
        <div class="filter-container collapse" id="collapseFilters">
            <div class="card card-block">
                <h5>Filters:</h5>
                <div class="form">
                    <?= $this->Form->create("", ["class"=>"form-inline"]) ?>
                        <?= $this->Form->label('Title:'); ?>
                        <?= $this->Form->control('title', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'title', 'ng-model' => 'valFilter.title', 'required' => false]) ?>
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
                        <th ng-click="sort('description')">
                            Description <span class="icon-order" ng-show="sortKey=='description'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('deadline')">
                            Deadline <span class="icon-order" ng-show="sortKey=='deadline'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
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
                    <tr dir-paginate="row in rows | filter:{title:valFilter.title} | filter:{status:valFilter.status} | orderBy:sortKey:reverse | itemsPerPage:pageSize as results" ng-cloak>
                        <td>{{ row.id }}</td>
                        <td>{{ row.title }}</td>
                        <td ng-bind-html="row.description | trust"></td>
                        <td>{{ row.deadline | date:'mediumDate' }}</td>
                        <td>{{ row.status }}</td>
                        <td class="icon-action hidden-print">
                            <div class="btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="#" class="btn btn-secondary view btn-outline-info" data-toggle="modal" data-target=".view-record" 
                                    ng-click="viewRecord($index)" title="view"><i class="icon-eye"></i></a>
                                <a role="button" href="#" class="btn btn-secondary edit btn-outline-primary" data-toggle="modal" data-target=".edit-record" 
                                    ng-click="editRecord('todos/viewJson', row.id )" title="Edit"><i class="icon-note"></i></a>
                                <a role-"button" href="#" data-toggle="modal" data-target=".confirmation-delete" class="btn btn-secondary delete btn-outline-danger" 
                                    ng-click="deleteRecord('todos/deleteJson', row.id)" title="Delete"><i class="icon-trash"></i></a>
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
                <div class="todos view">
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
                            <h5 class="card-title"><?= __('Description') ?></h5>
                            <div class="data" ng-bind-html="rowsDetail.description | trust"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Deadline') ?></h5>
                            <div class="data">
                                {{ rowsDetail.deadline | date:'mediumDate' }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Status') ?></h5>
                            <div class="data">
                                {{ rowsDetail.status }}
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
            <?= $this->Form->create('', ['name' => 'formEditRow']) ?>
                <div class="modal-body">
                    <div class="todos edit">
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
                                <?= $this->Form->control('title', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'title', 'ng-model' => 'rowsEdit.title', 'ng-change' => 'hasChangedTitle = true', 'required' => true]) ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Description:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedDescription || rowsEdit.description}']); ?>
                                <div class="input">
                                    <summernote config="summerMiniOptions" ng-model="rowsEdit.description" ng-change="hasChangedDescription = true" required="required"></summernote>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Deadline:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedDeadline || rowsEdit.deadline}']); ?>
                                <p class="input-group mb-0 calendar-group">
                                    <input type="text" class="form-control" uib-datepicker-popup="{{format}}" ng-model="rowsEdit.deadline" is-open="popup1.opened" datepicker-options="dateOptions" ng-required="true" close-text="Close" ng-change="hasChangedDeadline = true" alt-input-formats="altInputFormats" id="t.created" />
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-outline-primary btn-sm btn-calendar" ng-click="open1()"><i class="icon-calendar"></i></button>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Status:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedStatus || rowsEdit.status}']); ?>
                                <select class="form-control form-control-sm" ng-model="rowsEdit.status" ng-init="!!rowsEdit.status || 'pending'"  ng-change="hasChangedStatus" required="required">
                                    <!-- <option style="display:none" value="">select a status</option> -->
                                    <option>pending</option>
                                    <option>done</option>
                                    <option>canceled</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="mr-auto"><small>(*) requiered</small></span>
                    <button type="button" class="btn btn-success btn-sm" ng-click="saveRecord('todos', rowsEdit.id)">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>