<?php
/**
  * @var \App\View\AppView $this
  */
 ?>
<div class="card data-grid-container container-fluid" data-ng-init="refresh('postulations/summaryJson')">
    <div class="card-header row no-gutters hidden-print">
        <?= $this->element('admin/header-grid', ['page' => 'postulations']); ?>
    </div>
    <div class="card-block">
        <div class="filter-container collapse" id="collapseFilters">
            <div class="card card-block">
                <h5>Filters:</h5>
                <div class="form">
                    <?= $this->Form->create("", ["class"=>"form-inline"]) ?>
                        <?= $this->Form->label('Name:'); ?>
                        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'name', 'ng-model' => 'valFilter.name', 'required' => false]) ?>
                        <?= $this->Form->label('Email:'); ?>
                        <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'email', 'ng-model' => 'valFilter.email', 'required' => false]) ?>
                        <?= $this->Form->label('Position:'); ?>
                        <select ng-model="valFilter.position" class="form-control form-control-sm">
                            <option value="null" class="ng-binding ng-scope data-missing">Data Missing</option>
                            <option ng-repeat="row in rows | unique: 'position'">{{ row.position }}</option>
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
                        <th ng-click="sort('position')">
                            Position <span class="icon-order" ng-show="sortKey=='position'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                       <th ng-click="sort('name')">
                            Name <span class="icon-order" ng-show="sortKey=='name'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('email')">
                            Email <span class="icon-order" ng-show="sortKey=='email'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('resume')">
                            Resume <span class="icon-order" ng-show="sortKey=='resume'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('linkedin')">
                            LinkedIn <span class="icon-order" ng-show="sortKey=='linkedin'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('created')">
                            Created <span class="icon-order" ng-show="sortKey=='created'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th class="header-action hidden-print"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-show="loading">
                        <td colspan="8">
                            <?= $this->element('admin/spinner-grid'); ?>
                        </td>
                    </tr>
                    <tr ng-class="{'has-error': !row.position || row.fileError, '': row.position || !row.fileError}" dir-paginate="row in rows | filter:{name:valFilter.name} | filter:{email:valFilter.email} | filter:{position:valFilter.position} | orderBy:sortKey:reverse | itemsPerPage:pageSize as results" ng-cloak>
                        <td>{{ row.id }}</td>
                        <td ng-class="{'has-error':!row.position,'':row.position}">{{ row.position }}</td>
                        <td>{{ row.name }}</td>
                        <td>{{ row.email }}</td>
                        <td ng-class="{'has-error':row.fileError, '':!row.fileError}">
                            <a href="../upload/resumes/{{ row.resume }}" ng-if="!row.fileError && row.resume" target="_Blank">{{ row.resume }}</a>
                            <span ng-show="row.fileError">File Missing<br>[{{ row.resume }}]</span>
                        </td>
                        <td><a href="{{ row.linkedin }}" target="_Blank">{{ row.linkedin }}</a></td>
                        <td class="text-nowrap">{{ row.created | date:'mediumDate' }}</td>
                        <td class="icon-action hidden-print">
                            <div class="btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="#" class="btn btn-secondary view btn-outline-info" data-toggle="modal" data-target=".view-record" 
                                    ng-click="viewRecord($index)" title="View"><i class="icon-eye"></i></a>
                                <a role="button" href="#" class="btn btn-secondary edit btn-outline-primary" data-toggle="modal" data-target=".edit-record" 
                                    ng-click="editRecord('postulations/viewJson', row.id )" title="Edit"><i class="icon-note"></i></a>
                                <a role-"button" href="#" data-toggle="modal" data-target=".confirmation-delete" class="btn btn-secondary delete btn-outline-danger" 
                                    ng-click="deleteRecord('postulations/deleteJson', row.id)" title="Delete"><i class="icon-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr class="animate-repeat" ng-if="results.length === 0" ng-cloak>
                        <td colspan="8"><strong>No results found with that criteria filter</strong></td>
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
                <div class="postulations view">
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Id') ?></h5>
                            <div class="data">
                                {{ rowsDetail.id }}
                            </div>
                        </div>
                    </div>
                    <div class="card" ng-class="{'has-error':!rowsDetail.position,'':rowsDetail.position}">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Position') ?></h5>
                            <div class="data">
                                {{ rowsDetail.position }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Name') ?></h5>
                            <div class="data">
                                {{ rowsDetail.name }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Email') ?></h5>
                            <div class="data">
                                {{ rowsDetail.email }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Resume') ?></h5>
                            <div class="data">
                                <a href="../upload/resumes/{{ rowsDetail.resume }}" ng-if="!rowsDetail.fileError && rowsDetail.resume">{{ rowsDetail.resume }}</a>
                                <span ng-show="rowsDetail.fileError">File Missing<br>[{{ rowsDetail.resume }}]</span>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('LinkedIn') ?></h5>
                            <div class="data">{{ rowsDetail.linkedin }}</div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Created') ?></h5>
                            <div class="data">
                                {{ rowsDetail.created | date:'mediumDate' }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Modified') ?></h5>
                            <div class="data">
                                {{ rowsDetail.modified | date:'mediumDate' }}
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
                    <div class="postulations edit">
                        <div class="card" ng-show="rowsEdit.id">
                            <div class="card-block">
                                <h5 class="card-title trans"><?= __('Id') ?></h5>
                                <div class="data">
                                    {{ rowsEdit.id }}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block" data-ng-init="getCombobox('positionsOptions', 'postulations/getPositionOptions')">
                                <?= $this->Form->label('Positions:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':rowsEdit.position}']); ?>
                                <select ng-model="rowsEdit.position_id" class="form-control form-control-sm" ng-change="hasChangedPositions = true" required="required">
                                    <option style="display:none" value="">select a position</option>
                                    <option value="{{ positionsOption.id }}" ng-repeat="positionsOption in positionsOptions" ng-selected="rowsEdit.position_id==positionsOption.id">{{ positionsOption.title }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Name:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedName || rowsEdit.name}']); ?>
                                <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'name', 'ng-model' => 'rowsEdit.name', 'ng-change' => 'hasChangedName = true', 'required' => true]) ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Email:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedEmail || rowsEdit.email}']); ?>
                                <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'email', 'ng-model' => 'rowsEdit.email', 'ng-change' => 'hasChangedEmail = true', 'autocomplete' => 'off', 'ng-pattern' => 'emailFormat', 'required' => true]) ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Resume:', null, ['class' => 'card-title', 'ng-class' => '{\'trans\':rowsEdit.resume}']); ?>
                                <div class="mb-2">
                                    <a href="../upload/resumes/{{ rowsEdit.resume }}" ng-if="!rowsEdit.fileError && rowsEdit.resume">{{ rowsEdit.resume }}</a>
                                    <span ng-show="rowsEdit.fileError">File Missing<br>[{{ rowsEdit.resume }}]</span>
                                </div>
                                <input type="file" class="form-control form-control-sm file" onchange="angular.element(this).scope().fileSelected(this)" >
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Linkedin:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedLinkedin || rowsEdit.linkedin}']); ?>
                                <?= $this->Form->control('linkedin', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'name', 'ng-model' => 'rowsEdit.linkedin', 'ng-change' => 'hasChangedLinkedin = true', 'required' => true]) ?>
                            </div>
                        </div>
                        <input type="hidden" name="created" id="created" ng-model="rowsEdit.created" value="{{ rowsEdit.created }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="mr-auto"><small>(*) requiered</small></span>
                    <button type="button" class="btn btn-success btn-sm" ng-click="saveRecord('postulations', rowsEdit.id)">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>