<?php
/**
  * @var \App\View\AppView $this
  */
 ?>
<div class="card data-grid-container container-fluid" data-ng-init="refresh('contacts/summaryJson')">
    <div class="card-header row no-gutters hidden-print">
        <?= $this->element('admin/header-grid', ['page' => 'contacts']); ?>
    </div>
    <div class="card-block">
        <div class="filter-container collapse" id="collapseFilters">
            <div class="card card-block">
                <h5>Filters:</h5>
                <div class="form">
                    <?= $this->Form->create("", ["class"=>"form-inline"]) ?>
                        <?= $this->Form->label('Name:'); ?>
                        <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'name', 'ng-model' => 'valFilter.name', 'required' => false]) ?>
                        <?= $this->Form->control('phone', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '20', 'id' => 'pgone', 'ng-model' => 'valFilter.phone', 'required' => false]) ?>
                        <?= $this->Form->label('Email:'); ?>
                        <?= $this->Form->control('email', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'email', 'ng-model' => 'valFilter.email', 'required' => false]) ?>
                        <?= $this->Form->label('Category:'); ?>
                        <select ng-model="valFilter.category" class="form-control form-control-sm">
                            <option value="null" class="ng-binding ng-scope data-missing">Data Missing</option>
                            <option>general info</option>
                            <option>support</option>
                            <option>careers</option>
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
                        <th ng-click="sort('name')">
                            Name <span class="icon-order" ng-show="sortKey=='name'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                       <th ng-click="sort('phone')">
                            Phone <span class="icon-order" ng-show="sortKey=='phone'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('email')">
                            Email <span class="icon-order" ng-show="sortKey=='email'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('category')">
                            Category <span class="icon-order" ng-show="sortKey=='category'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
                        </th>
                        <th ng-click="sort('comments')">
                            Comments <span class="icon-order" ng-show="sortKey=='comments'" ng-class="{'icon-order__asc':reverse,'icon-order__desc':!reverse}"></span>
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
                    <tr ng-class="{'has-error': !row.category, '': row.category}" dir-paginate="row in rows | filter:{name:valFilter.name} | filter:{phone:valFilter.phone} | filter:{email:valFilter.email} | filter:{category:valFilter.category} | orderBy:sortKey:reverse | itemsPerPage:pageSize as results" ng-cloak>
                        <td>{{ row.id }}</td>
                        <td>{{ row.name }}</td>
                        <td>{{ row.phone }}</td>
                        <td>{{ row.email }}</td>                        
                        <td ng-class="{'has-error':!row.category,'':row.category}">{{ row.category }}</td>
                        <td ng-bind-html="row.comments | trust"></td>                        
                        <td class="text-nowrap">{{ row.created | date:'mediumDate' }}</td>
                        <td class="icon-action hidden-print">
                            <div class="btn-group-sm" role="group" aria-label="Basic example">
                                <a role="button" href="#" class="btn btn-secondary view btn-outline-info" data-toggle="modal" data-target=".view-record" 
                                    ng-click="viewRecord($index)" title="View"><i class="icon-eye"></i></a>
                                <a role="button" href="#" class="btn btn-secondary edit btn-outline-primary" data-toggle="modal" data-target=".edit-record" 
                                    ng-click="editRecord('contacts/viewJson', row.id )" title="Edit"><i class="icon-note"></i></a>
                                <a role-"button" href="#" data-toggle="modal" data-target=".confirmation-delete" class="btn btn-secondary delete btn-outline-danger" 
                                    ng-click="deleteRecord('contacts/deleteJson', row.id)" title="Delete"><i class="icon-trash"></i></a>
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
                            <h5 class="card-title"><?= __('Phone') ?></h5>
                            <div class="data">
                                {{ rowsDetail.phone }}
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
                            <h5 class="card-title"><?= __('Category') ?></h5>
                            <div class="data">
                                {{ rowsDetail.category }}
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-block">
                            <h5 class="card-title"><?= __('Comments') ?></h5>
                            <div class="data" ng-bind-html="rowsDetail.comments | trust"></div>
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
                            <div class="card-block">
                                <?= $this->Form->label('Name:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedName || rowsEdit.name}']); ?>
                                <?= $this->Form->control('name', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '50', 'id' => 'name', 'ng-model' => 'rowsEdit.name', 'ng-change' => 'hasChangedName = true', 'required' => true]) ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Phone: [1-222-3334455]', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedPhone || rowsEdit.phone}']); ?>
                                <?= $this->Form->control('phone', ['label' => false, 'class' => 'form-control form-control-sm', 'maxlength' => '20', 'id' => 'phone', 'ng-model' => 'rowsEdit.phone', 'ng-change' => 'hasChangedPhone = true', 'ng-pattern' => 'phoneFormat', 'required' => true]) ?>
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
                                <?= $this->Form->label('Category:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedCategory || rowsEdit.category}']); ?>
                                <select ng-model="rowsEdit.category" class="form-control form-control-sm" ng-change="hasChangedCategory = true" required="required">
                                    <option style="display:none" value="">select a category</option>
                                    <option>general info</option>
                                    <option>support</option>
                                    <option>careers</option>
                                </select>
                            </div>
                        </div>
                       <div class="card">
                            <div class="card-block">
                                <?= $this->Form->label('Comments:', null, ['class' => 'card-title required', 'ng-class' => '{\'trans\':!!hasChangedComments || rowsEdit.comments}']); ?>
                                <div class="input">
                                    <summernote config="summerMiniOptions" ng-model="rowsEdit.comments" ng-change="hasChangedComments = true" required="required"></summernote>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="created" id="created" ng-model="rowsEdit.created" value="{{ rowsEdit.created }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <span class="mr-auto"><small>(*) requiered</small></span>
                    <button type="button" class="btn btn-success btn-sm" ng-click="saveRecord('contacts', rowsEdit.id)">Save</button>
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>