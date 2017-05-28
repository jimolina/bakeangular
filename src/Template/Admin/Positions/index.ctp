<?php
/**
  * @var \App\View\AppView $this
  */
 ?>
<div class="card data-grid-container container-fluid" data-ng-init="refresh('positions/summaryJson')">
    <div class="card-header row no-gutters hidden-print">
        <?= $this->element('admin/header-grid', ['page' => 'positions']); ?>
    </div>
    <div class="card-block">
        <div class="filter-container collapse" id="collapseFilters">
            <div class="card card-block">
                <h5>Filters:</h5>
                <div class="form">
                    <?= $this->Form->create("", ["class"=>"form-inline"]) ?>
                        <?= $this->Form->label('Title:'); ?>
                        <?= $this->Form->control('title', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'title', 'ng-model' => 'valFilter.title', 'required' => false]) ?>
                        <?= $this->Form->label('Location:'); ?>
                        <?= $this->Form->control('location', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'location', 'ng-model' => 'valFilter.location', 'required' => false]) ?>
                        <?= $this->Form->label('Type:'); ?>
                        <select ng-model="valFilter.type" class="form-control form-control-sm">
                            <option value="null" class="ng-binding ng-scope data-missing">Data Missing</option>
                            <option ng-repeat="row in rows | unique: 'type'">{{ row.type }}</option>
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
                        <th ng-click="sort('location')">
                            Location <span class="icon-order" ng-show="sortKey=='location'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('type')">
                            Type <span class="icon-order" ng-show="sortKey=='type'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('summary')">
                            Summary <span class="icon-order" ng-show="sortKey=='summary'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('status')">
                            Status <span class="icon-order" ng-show="sortKey=='status'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th class="header-action hidden-print"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-show="loading">
                        <td colspan="7">
                            <?= $this->element('admin/spinner-grid'); ?>
                        </td>
                    </tr>
                    <tr ng-class="{'has-error': !row.type || !row.status, '': row.type || row.status}" dir-paginate="row in rows | filter:{title:valFilter.title} | filter:{location:valFilter.location} | filter:{type:valFilter.type} | filter:{status:valFilter.status} | orderBy:sortKey:reverse | itemsPerPage:pageSize as results" ng-cloak>
                        <td>{{ row.id }}</td>
                        <td>{{ row.title }}</td>
                        <td>{{ row.location }}</td>
                        <td ng-class="{'has-error':!row.type,'':row.type}">{{ row.type | missingRelationship }}</td>
                        <td ng-bind-html="row.summary | trust"></td>
                        <td ng-class="{'has-error':!row.status,'':row.status}">{{ row.status | missingRelationship }}</td>
                        <td class="icon-action hidden-print">
                            <div class="btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="#" class="btn btn-secondary view btn-outline-info" data-toggle="modal" data-target=".view-record" 
                                    ng-click="viewRecord($index)" title="View"><i class="icon-eye"></i></a>
                                <a role="button" href="#" class="btn btn-secondary edit btn-outline-primary" data-toggle="modal" data-target=".edit-record" 
                                    ng-click="editRecord('positions/viewJson', row.id )" title="Edit"><i class="icon-note"></i></a>
                                <a role-"button" href="#" data-toggle="modal" data-target=".confirmation-delete" class="btn btn-secondary delete btn-outline-danger" 
                                    ng-click="deleteRecord('positions/deleteJson', row.id)" title="Delete"><i class="icon-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <tr class="animate-repeat" ng-if="results.length === 0" ng-cloak>
                        <td colspan="7"><strong>No results found with that criteria filter</strong></td>
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
                <div class="positions view">
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
                            <h5 class="card-title"><?= __('title') ?></h5>
                            <div class="data">
                                {{ rowsDetail.title }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Location') ?></h5>
                            <div class="data">
                                {{ rowsDetail.location }}
                            </div>
                        </div>
                    </div>
                    <div class="card" ng-class="{'has-error':!rowsDetail.type,'':rowsDetail.type}">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Type') ?></h5>
                            <div class="data">
                                {{ rowsDetail.type | missingRelationship }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Summary') ?></h5>
                            <div class="data" ng-bind-html="rowsDetail.summary | trust"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('responsibilities') ?></h5>
                            <div class="data" ng-bind-html="rowsDetail.responsibilities | trust"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Skills') ?></h5>
                            <div class="data" ng-bind-html="rowsDetail.skills | trust"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Experience') ?></h5>
                            <div class="data" ng-bind-html="rowsDetail.experience | trust"></div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Education') ?></h5>
                            <div class="data" ng-bind-html="rowsDetail.education | trust"></div>
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
                    <div class="positions edit">
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
                                <?= $this->Form->label('Location:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedLocation || rowsEdit.location}']); ?>
                                <?= $this->Form->control('location', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'location', 'ng-model' => 'rowsEdit.location', 'ng-change' => 'hasChangedLocation = true', 'required' => true]) ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Type:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedType || rowsEdit.type}']); ?>
                                <select ng-model="rowsEdit.type" class="form-control form-control-sm" ng-change="hasChangedType = true" required="required">
                                    <option style="display:none" value="">select a type</option>
                                    <option>Full Time</option>
                                    <option>Part Time</option>
                                    <option>Contract</option>
                                    <option>Contract - to Hire</option>
                                </select>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Summary:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedSummary || rowsEdit.summary}']); ?>
                                <div class="input">
                                    <summernote config="summerOptions" ng-model="rowsEdit.summary" ng-change="hasChangedSummary = true" required="required"></summernote>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Responsibilities:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedResponsibilities || rowsEdit.responsibilities}']); ?>
                                <div class="input">
                                    <summernote config="summerOptions" ng-model="rowsEdit.responsibilities" ng-change="hasChangedResponsibilities = true" required="required"></summernote>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Skills:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedSkills || rowsEdit.skills}']); ?>
                                <div class="input">
                                    <summernote config="summerOptions" ng-model="rowsEdit.skills" ng-change="hasChangedSkills = true" required="required"></summernote>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Experience:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedExperience || rowsEdit.experience}']); ?>
                                <div class="input">
                                    <summernote config="summerOptions" ng-model="rowsEdit.experience" ng-change="hasChangedExperience = true" required="required"></summernote>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Education:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedEducation || rowsEdit.education}']); ?>
                                <div class="input">
                                    <summernote config="summerOptions" ng-model="rowsEdit.education" ng-change="hasChangedEducation = true" required="required"></summernote>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block" data-ng-init="getCombobox('statusOptions', 'users/getStatusOptions')">
                                <?= $this->Form->label('Status:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedStatus || rowsEdit.status}']); ?>
                                <select ng-model="rowsEdit.status_id" class="form-control form-control-sm" ng-change="hasChangedStatus = true" required="required">
                                    <option style="display:none" value="">select a status</option>
                                    <option value="{{ statusOption.id }}" ng-repeat="statusOption in statusOptions" ng-selected="rowsEdit.status==statusOption.status">{{ statusOption.status }}</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="created" id="created" ng-model="rowsEdit.created" value="{{ rowsEdit.created }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="mr-auto"><small>(*) requiered</small></span>
                    <button type="button" class="btn btn-success btn-sm" ng-click="saveRecord('positions', rowsEdit.id)">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>