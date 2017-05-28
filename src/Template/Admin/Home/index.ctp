<div class="row rapid-view">
	<div class="icard col-lg-3 col-md-6">
		<div class="icard-block">
			<h2 class="icard-title icard-title__articles"><?= $articlesTot; ?></h2>
			<h6 class="icard-subtitle mb-2 text-muted">Articles</h6>
			<i class="icon-layers"></i>
		</div>
		<div class="card-footer icard-footer__articles"></div>
	</div>
	<div class="icard col-lg-3 col-md-6">
		<div class="icard-block">
			<h2 class="icard-title icard-title__jobs"><?= $postulationsTot; ?></h2>
			<h6 class="icard-subtitle mb-2 text-muted">Jobs Postulation</h6>
			<i class="icon-drawer"></i>
		</div>
		<div class="card-footer icard-footer__jobs"></div>
	</div>
	<div class="icard col-lg-3 col-md-6">
		<div class="icard-block">
			<h2 class="icard-title icard-title__suscribers"><?= $newsletterUsersTot; ?></h2>
			<h6 class="icard-subtitle mb-2 text-muted">Newsletter Suscribers</h6>
			<i class="icon-paper-plane"></i>
		</div>
		<div class="card-footer icard-footer__suscribers"></div>
	</div>
	<div class="icard col-lg-3 col-md-6">
		<div class="icard-block">
			<h2 class="icard-title icard-title__contact"><?= $contactsTot; ?></h2>
			<h6 class="icard-subtitle mb-2 text-muted">Contact Request</h6>
			<i class="icon-envelope"></i>
		</div>
		<div class="card-footer icard-footer__contact"></div>
	</div>
</div>
<div class="row">
	<div class="icard icard-filter col-xl-6 col-lg-12 home-grid" data-ng-init="refresh('admin/todos/summaryJson/10/deadline/asc', 'todoHlist')">
		<div class="card-header row no-gutters">
	    	<div class="col-6 caption">Todo <small class="text-muted">last 10</small></div>
			<div class="col-6">
				<ul class="nav nav-tabs justify-content-end" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#todoList" data-toggle="tab" role="tab" ng-click="setFilterGridHome('filterTodo', 'pending')">Pending</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#todoList" data-toggle="tab" role="tab" ng-click="setFilterGridHome('filterTodo', '')">All Records</a>
                    </li>
                </ul>
			</div>
		</div>
		<div class="icard-block">
			<div class="tab-content" ng-cloak>
				<div class="tab-pane fade show active" role="tabpanel" id="todoList">
                    <div ng-show="loading.todoHlist">
                        <?= $this->element('admin/spinner-grid'); ?>
                    </div>
					<div class="icard-list">
						<div class="icard-item row no-gutters" ng-repeat="row in todoHlist | filter:filterTodo">
                            <div class="icard-info col-8">
                                <div class="icard-info__author">
                                    {{ row.title }} 
                                    <span class="badge badge-pill badge-success" ng-if="row.status == 'done'">Done</span>
                                    <span class="badge badge-pill badge-danger" ng-if="setTimeLineOutdated(row.deadline) == 'danger' && row.status != 'done'">Outdated</span>
                                    <span class="badge badge-pill badge-warning" ng-if="setTimeLineOutdated(row.deadline) == 'warning' && row.status != 'done'">today</span>
                                </div>
                                <p class="icard-info__desc" ng-bind-html="row.description | trust"></p>
                            </div>
                            <div class="icard-datetime col-2 text-nowrap">
                                {{ row.deadline | date:'mediumDate' }}
                            </div>
                            <div class="icard-buttons col-2">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-info" ng-disabled="row.status == 'done' || row.status == 'cancel'" ng-click="changeStatusTodoHome(row.id)">Done</button>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="icard icard-filter col-xl-6 col-lg-12 home-grid" data-ng-init="refresh('admin/contacts/summaryJson/10/', 'contactHlist')">
		<div class="card-header row no-gutters">
	    	<div class="col-6 caption">Last Contact <small class="text-muted">last 10</small></div>
			<div class="col-6">
				<ul class="nav nav-tabs justify-content-end" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#contactList" data-toggle="tab" role="tab" ng-click="setFilterGridHome('filterContact', 'today')"> Today </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contactList" data-toggle="tab" role="tab" ng-click="setFilterGridHome('filterContact', '')"> All records </a>
                    </li>
                </ul>
			</div>
		</div>
		<div class="icard-block">
			<div class="tab-content">
				<div class="tab-pane fade show active" role="tabpanel" id="contactList">
                    <div ng-show="loading.contactHlist">
                        <?= $this->element('admin/spinner-grid'); ?>
                    </div>
					<div class="icard-list">
						<div class="icard-item row no-gutters" ng-repeat="row in contactHlist | today:filterContact">
                            <div class="icard-info col-7">
                                <span class="icard-info__author">{{ row.name }}</span>
                                <p>{{ row.email }}</p>
                            </div>
                            <div class="icard-datetime col-2 text-nowrap">
                                {{ row.created | date:'mediumDate' }} @ {{ row.created | date:'h:mma' }}
                            </div>
                            <div class="icard-buttons col-3">
                                <div class="btn-group btn-group-sm" role="group">
                                    <button type="button" class="btn btn-outline-info" data-toggle="modal" data-target=".view-contact-home" 
                                    ng-click="viewContactHome($index)" title="view">View</button>
                                </div>
                            </div>
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="icard icard-filter col-12 home-grid" data-ng-init="refresh('admin/feeds/summaryJson/50/date/desc', 'feedsHlist')">
		<div class="card-header row no-gutters">
	    	<div class="col-6 caption">Feeds <small class="text-muted">last 50</small></div>
			<div class="col-6">
				<ul class="nav nav-tabs justify-content-end" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#feedsList" data-toggle="tab" role="tab" ng-click="setFilterGridHome('filterFeed', 'system')"> System </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#feedsList" data-toggle="tab" role="tab" ng-click="setFilterGridHome('filterFeed', 'activities')"> Activities </a>
                    </li>
                </ul>
			</div>
		</div>
		<div class="icard-block">
			<div class="tab-content">
				<div class="tab-pane fade show active" role="tabpanel" id="feedsList">
                    <div ng-show="loading.feedsHlist">
                        <?= $this->element('admin/spinner-grid'); ?>
                    </div>
					<div class="icard-list icard-list__simple" ng-repeat="row in feedsHlist | filter:filterFeed">
						<div class="icard-item row">
                            <div class="icard-info col-10">
                                <span class="icard-info__icon" ng-class="setClassFeed(row.action)"></span>
                                <span class="icard-info__desc">
                                    <b>{{ row.page }}</b> | {{ row.action }} | By: {{ row.user }}
                                </span>
                            </div>
                            <div class="icard-datetime col-2">
                                {{ row.date | date:'mediumDate' }} @ {{ row.date | date:'h:mma' }}
                            </div>                           
                        </div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- View Contact Home modal -->
<div class="modal fade view-contact-home" tabindex="-1" role="dialog" aria-labelledby="ViewContactHome" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Detail</strong> contact</h5>
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