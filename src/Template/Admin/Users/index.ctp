<?php
/**
  * @var \App\View\AppView $this
  */
 ?>
<div class="card data-grid-container container-fluid" data-ng-init="refresh('users/summaryJson')">
    <div class="card-header row no-gutters hidden-print">
        <?= $this->element('admin/header-grid', ['page' => 'users']); ?>
    </div>
    <div class="card-block">
        <div class="filter-container collapse" id="collapseFilters">
            <div class="card card-block">
                <h5>Filters:</h5>
                <div class="form">
                    <?= $this->Form->create("", ["class"=>"form-inline"]) ?>
                        <?= $this->Form->label('First Name:'); ?>
                        <?= $this->Form->control('first_name', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'firstName', 'ng-model' => 'valFilter.first_name', 'required' => false]) ?>
                        <?= $this->Form->label('Last Name:'); ?>
                        <?= $this->Form->control('last_name', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'lastName', 'ng-model' => 'valFilter.last_name', 'required' => false]) ?>
                        <?= $this->Form->label('Email:'); ?>
                        <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'email', 'ng-model' => 'valFilter.email', 'required' => false]) ?>
                        <?= $this->Form->label('Role:'); ?>
                        <select ng-model="valFilter.role" class="form-control form-control-sm">
                            <option value="null" class="ng-binding ng-scope data-missing">Data Missing</option>
                            <option ng-repeat="row in rows | unique: 'role'">{{ row.role }}</option>
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
                        <th ng-click="sort('first_name')">
                            First Name <span class="icon-order" ng-show="sortKey=='first_name'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('last_name')">
                            Last Name <span class="icon-order" ng-show="sortKey=='last_name'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('username')">
                            User Name <span class="icon-order" ng-show="sortKey=='username'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('email')">
                            Email <span class="icon-order" ng-show="sortKey=='email'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('role')">
                            Role <span class="icon-order" ng-show="sortKey=='role'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('status')">
                            Status <span class="icon-order" ng-show="sortKey=='status'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
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
                    <tr ng-class="{'has-error': !row.role || !row.status, '': row.role || row.status}" dir-paginate="row in rows | filter:{first_name:valFilter.first_name} | filter:{last_name:valFilter.last_name} | filter:{email:valFilter.email} | filter:{role:valFilter.role} | filter:{status:valFilter.status} | orderBy:sortKey:reverse | itemsPerPage:pageSize as results" ng-cloak>
                        <td>{{ row.id }}</td>
                        <td>{{ row.first_name }}</td>
                        <td>{{ row.last_name }}</td>
                        <td>{{ row.username }}</td>
                        <td>{{ row.email }}</td>
                        <td>{{ row.role }}</td>
                        <td ng-class="{'has-error':!row.status,'':row.status}">{{ row.status | missingRelationship }}</td>
                        <td class="icon-action hidden-print">
                            <div class="btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="#" class="btn btn-secondary view btn-outline-info" data-toggle="modal" data-target=".view-record" 
                                    ng-click="viewRecord($index)" title="View"><i class="icon-eye"></i></a>
                                <a role="button" href="#" class="btn btn-secondary edit btn-outline-primary" data-toggle="modal" data-target=".edit-record" 
                                    ng-click="editRecord('users/viewJson', row.id )" title="Edit"><i class="icon-note"></i></a>
                                <a role="button" href="#" class="btn btn-secondary edit btn-outline-primary" data-toggle="modal" data-target=".edit-password" 
                                    ng-click="editRecord('users/viewJson', row.id )" title="Change Password"><i class="icon-key"></i></a>
                                <a role-"button" href="#" data-toggle="modal" data-target=".confirmation-delete" class="btn btn-secondary delete btn-outline-danger" 
                                    ng-click="deleteRecord('users/deleteJson', row.id)" title="Delete"><i class="icon-trash"></i></a>
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
                <div class="users view">
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
                            <h5 class="card-title"><?= __('First Name') ?></h5>
                            <div class="data">
                                {{ rowsDetail.first_name }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Last Name') ?></h5>
                            <div class="data">
                                {{ rowsDetail.last_name }}
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
                    <div class="card" ng-class="{'has-error':!rowsDetail.role,'':rowsDetail.role}">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Role') ?></h5>
                            <div class="data">
                                {{ rowsDetail.role }}
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

<!-- Edit Password modal -->
<div class="modal fade edit-password" tabindex="-1" id="EditPasswordModal" role="dialog" aria-labelledby="EditPassword" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Edit</strong> Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <?= $this->element('admin/error-block'); ?>
            <?= $this->Form->create('', ['name' => 'formEditPassword']) ?>
                <div class="modal-body">
                    <div class="users edit">
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Password:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedPassword || rowsEdit.password}']); ?>
                                <?= $this->Form->password('password', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '15', 'id' => 'password', 'ng-model' => 'rowsEdit.password', 'ng-change' => 'hasChangedPassword = true', 'autocomplete' => 'off', 'ng-minlength' => '6', 'required' => true]) ?>
                                <span class="error-txt" ng-show="!formEditPassword.password.$valid">Required | MinLength = 6</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="mr-auto"><small>(*) requiered</small></span>
                    <button type="button" class="btn btn-success btn-sm" ng-click="savePassword('users', rowsEdit.id)">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            <?= $this->Form->end() ?>
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
            <?= $this->Form->create('', ['name' => 'formEditRow', 'type' => 'file']) ?>
                <div class="modal-body">
                    <div class="users edit">
                        <h5 ng-show="!rowsEdit.id">Login credentials</h5>
                        <div class="card" ng-show="!rowsEdit.id" ng-if="!rowsEdit.id">
                            <div class="card-block">
                                <?= $this->Form->label('User Name:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedUName || rowsEdit.username}']); ?>
                                <?= $this->Form->control('username', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'username', 'ng-model' => 'rowsEdit.username', 'ng-change' => 'hasChangedUName = true', 'autocomplete' => 'off', 'ng-minlength' => '4', 'required' => true]) ?>
                                <span class="error-txt" ng-show="!formEditRow.username.$valid">Required | MinLength = 4</span>
                            </div>
                        </div>
                        <div class="card" ng-show="!rowsEdit.id" ng-if="!rowsEdit.id">
                            <div class="card-block">
                                <?= $this->Form->label('Password:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedPassword || rowsEdit.password}']); ?>
                                <?= $this->Form->password('password', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '15', 'id' => 'password', 'ng-model' => 'rowsEdit.password', 'ng-change' => 'hasChangedPassword = true', 'autocomplete' => 'off', 'ng-minlength' => '6', 'required' => true]) ?>
                                <span class="error-txt" ng-show="!formEditRow.password.$valid">Required | MinLength = 6</span>
                            </div>
                        </div>
                        <h5 class="mt-4" ng-show="!rowsEdit.id">General data</h5>
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
                                <?= $this->Form->label('First Name:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedFName || rowsEdit.first_name}']); ?>
                                <?= $this->Form->control('first_name', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'firstName', 'ng-model' => 'rowsEdit.first_name', 'ng-change' => 'hasChangedFName = true', 'required' => true]) ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Last Name:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedLName || rowsEdit.last_name}']); ?>
                                <?= $this->Form->control('last_name', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'lastName', 'ng-model' => 'rowsEdit.last_name', 'ng-change' => 'hasChangedLName = true', 'required' => true]) ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Email:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedEmail || rowsEdit.email}']); ?>
                                <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'email', 'ng-model' => 'rowsEdit.email', 'ng-change' => 'hasChangedLName = true', 'autocomplete' => 'off', 'ng-pattern' => 'emailFormat', 'required' => true]) ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Role:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedRole || rowsEdit.role}']); ?>
                                <select ng-model="rowsEdit.role" class="form-control form-control-sm" ng-change="hasChangedRole = true" required="required">
                                    <option style="display:none" value="">select a role</option>
                                    <option>admin</option>
                                    <option>author</option>
                                    <option>newsletter</option>
                                </select>
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
                    <button type="button" class="btn btn-success btn-sm" ng-click="saveRecord('users', rowsEdit.id)">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>