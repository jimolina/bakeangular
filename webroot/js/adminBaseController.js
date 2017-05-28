	angular
	.module('adminBase')
	.controller('generalController', function($scope, $timeout, dataSummary, dataRecord, saveRecord, recordDelete, doneStatusTodo){
		$scope.pageSize = 20;
		$scope.currentPage = 1;
		$scope.loading = true;
		$scope.notification = false;
		$scope.emailFormat = /^[a-z]+[a-z0-9._]+@[a-z]+\.[a-z.]{2,5}$/;
		$scope.phoneFormat = /^\+?\d{1,2}[- ]?\d{3}[- ]?\d{7}$/;
		$scope.msn = '';
		$scope.msnError = '';
		$scope.filterTodo = 'pending';
		$scope.filterContact = 'today';
		$scope.filterFeed = 'system';
		
		$scope.summerOptions = {
		    height: 300,
		    airMode: false,
		    toolbar: [
	            ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
	            ['alignment', ['ul', 'ol', 'paragraph', 'lineheight']],
	            ['table', ['table']],
	            ['insert', ['link','picture','video','hr']],
	            ['view', ['codeview']],
	            ['help', ['help']]
	        ]
	  	};

		$scope.summerMiniOptions = {
		    height: 70,
		    airMode: false,
		    toolbar: [
	            ['style', ['bold', 'italic', 'underline', 'superscript', 'subscript', 'strikethrough', 'clear']],
	            ['insert', ['link']],
	            ['help', ['help']]
	        ]
		};

		$scope.formats = ['MM/dd/yyyy', 'dd-MMMM-yyyy', 'yyyy/MM/dd', 'dd.MM.yyyy', 'shortDate'];
		$scope.format = $scope.formats[0];
		$scope.altInputFormats = ['M!/d!/yyyy'];

		$scope.open1 = function() {
			$scope.popup1.opened = true;
		};

		$scope.open2 = function() {
			$scope.popup2.opened = true;
		};

		$scope.popup1 = {
	    	opened: false
	  	};

		$scope.popup2 = {
	    	opened: false
	  	};

		$scope.print = function() {
			window.print();
		}

		//******** Home Grids Actions ********
		
	  	$scope.setFilterGridHome = function(field, value) {
			$scope[field] = value;
	  	}

	  	$scope.setClassFeed = function(value) {
			var value = value.split(':')[0],
				action = '',
				style = '';

			switch(value.toLowerCase()) {
			    case 'send':
			        value = 'envelope-open';
			        break;
			    case 'create':
			    	value = 'plus';
			        break;
			    case 'update':
			        value = 'note';
			        break; 
		        case 'delete':
			        value = 'trash';
			        break;
		        case 'db':
			        value = 'cloud-upload';
			        break;
			    default:
			        value = 'info';
			}

			style = 'icon-' + value;

			return style;
	  	}

		$scope.setTimeLineOutdated = function(date) {
			var rowDate = new Date(date),
				rowDate = rowDate.setHours(0, 0, 0, 0),
				today = new Date(),
				today = today.setHours(0, 0, 0, 0),
				outdated = '';

			if (rowDate < today) {
				outdated = 'danger';
			} else if (rowDate == today) {
				outdated = 'warning';
			} 

			return outdated;
		}

		$scope.changeStatusTodoHome = function(recordId) {
	   		doneStatusTodo.changeStatus('admin/todos/doneStatusTodo', recordId).then(function(data){
				$scope.refresh('admin/todos/summaryJson/10/deadline/asc', 'todoHlist')
			}, function ( response ) {
				$scope.msn.type = 'danger';
				$scope.msn.content = 'The data could not be saved. Please, try again.';
				timeNotification = 10000;

				$scope.notification = true;

				$timeout(function () { 
					$scope.notification = false;
				}, timeNotification);  
			}).finally(function() {
				// called no matter success or failure
			});
	   	}

		$scope.viewContactHome = function(id) {
			console.log("HERE2: ", $scope.contactHlist[id]);
			$scope.rowsDetail = $scope.contactHlist[id];
		}

		//******** General Grids Actions ********
	
		$scope.getCombobox = function(field, page) {
			dataSummary.getAll(page).then(function(data){
				$scope[field] = data.data.listOptions;
			}, function ( response ) {
				// TODO: handle the error somehow
			}).finally(function() {
				// called no matter success or failure
				$scope.loading = false;
			});
		}
			
	    $scope.sort = function(keyname){
	    	$scope.sortKey = keyname;
	    	$scope.reverse = !$scope.reverse;
	    }

		$scope.setDateEdit = function(page){
			var page = page.split('/');

			if ((page[0] === 'articles') || (page[0] === 'users')) {
				if ($scope.rowsEdit.created !== null) {
					$scope.rowsEdit.created = new Date($scope.rowsEdit.created);
				}

				if ($scope.rowsEdit.modified !== null) {
					$scope.rowsEdit.modified = new Date($scope.rowsEdit.modified);
				}
			} else if (page[0] === 'todos') {
				if ($scope.rowsEdit.deadline !== null) {
					$scope.rowsEdit.deadline = new Date($scope.rowsEdit.deadline);
				}
			}
		}

		$scope.resetFormNew = function() {
	      	$scope.rowsEdit = {};
	      	angular.element('input.file').val('');
	   		$scope.myFile = '';
	   		$scope.msnError = '';
			$scope.notificationErrors = false;
	    }

	    $scope.clearGridFilter = function() {
	    	$scope.valFilter = {};
	    }

		$scope.refresh = function(page, scopeContainer=false) {
			dataSummary.getAll(page).then(function(data){
				if (scopeContainer == false) {
					$scope.rows = data.data.grid;
				} else {
					$scope[scopeContainer] = data.data.grid;
				}
				angular.element('option.data-missing').attr('value', '');
			}, function ( response ) {
				// TODO: handle the error somehow
			}).finally(function() {
				// called no matter success or failure
				if (scopeContainer == false) {
					$scope.loading = false;
				} else {
					$scope.loading[scopeContainer] = false;
				}
			});
		}

	   	$scope.viewRecord = function(id) {
			$scope.rowsDetail = $scope.rows[id];
	   	}

		$scope.editRecord = function(page, recordId) {
	      	angular.element('input.file').val('');
	   		$scope.myFile = '';
			$scope.msnError = '';
			$scope.notificationErrors = false;

			dataRecord.getDetail(page, recordId).then(function(data){
				$scope.rowsEdit = data.data.dataDetail[0];
				$scope.setDateEdit(page);
				// $scope.setStatusEdit(page);
			});
	   	}

		$scope.export = function(page) {
			dataSummary.getAll(page).then(function(data){
				

			}, function ( response ) {
				// TODO: handle the error somehow
			}).finally(function() {
				// called no matter success or failure
				$scope.loading = false;
			});
		}

		$scope.fileSelected = function (element) {
		    $scope.myFile = element.files[0];
		};

		$scope.saveRecord = function(page, recordId) {
			var pageReload = page + '/summaryJson',
				timeNotification = 3000;

			if ($scope.formEditRow.$valid) {

				saveRecord.save(page, recordId, $scope.rowsEdit, $scope.myFile).then(function(data){

					if (data.data.msn.type === 'success') {
						angular.element('#EditRecordModal').modal('hide');

						$scope.msnError = '';
						$scope.notificationErrors = false;

						$scope.msn = data.data.msn;
						$scope.notification = true;
						$timeout(function () { 
							$scope.notification = false;
						}, timeNotification);

						$scope.refresh(pageReload);
					} else {
						timeNotification = 10000;

						$scope.msnError = data.data.msn;
						$scope.notificationErrors = true;
					}
				}, function ( response ) {
					$scope.msn.type = 'danger';
					$scope.msn.content = 'The data could not be saved. Please, check all the fields and try again.';
					timeNotification = 10000;

					$scope.notification = true;

					$timeout(function () { 
						$scope.notification = false;
					}, timeNotification);  
				}).finally(function() {
					// called no matter success or failure
				});
	    	}
		}

		$scope.savePassword = function(page, recordId) {
			if ($scope.formEditPassword.$valid) {

				saveRecord.save(page, recordId, $scope.rowsEdit, $scope.myFile).then(function(data){
					$scope.msn = data.data.msn;

					$scope.notification = true;

					$timeout(function () { 
						$scope.notification = false;
					}, 3000);  
				}, function ( response ) {
					$scope.msn.type = 'danger';
					$scope.msn.content = 'The Password could not be saved. Please, check the field and try again.';

					$scope.notification = true;

					$timeout(function () { 
						$scope.notification = false;
					}, 10000);  
				}).finally(function() {
					// called no matter success or failure
					angular.element('#EditPasswordModal').modal('hide');
				});
	    	}
		}

		$scope.deleteRecord = function(page, recordId) {
			var page = page.split('/');

			angular.element('#ConfirmationDelete #delConfirm').attr('ng-page',page[0]);
			angular.element('#ConfirmationDelete #delConfirm').attr('ng-record',recordId);
		}

		$scope.deleteRecordConfirm = function() {
			var pageDelete = angular.element('#ConfirmationDelete #delConfirm').attr('ng-page') + '/deleteJson',
				pageReload = angular.element('#ConfirmationDelete #delConfirm').attr('ng-page') + '/summaryJson',
				recordId = angular.element('#ConfirmationDelete #delConfirm').attr('ng-record');

			recordDelete.recordDel(pageDelete, recordId).then(function(data){
				$scope.msn = data.data.msn;
				$scope.notification = true;

				$timeout(function () { 
					$scope.notification = false;
				}, 3000);

				if (data.data.msn.type === 'success') {
					$scope.refresh(pageReload);
				}
			});
		}
	})
	.filter('trust', function($sce) { 
		return $sce.trustAsHtml; 
	})
	.filter('missingRelationship', function() {
		return function(data) {
			var txt = (data !== null) ? data : 'Data Missing';

			return txt;
		}
	})
	.filter('thumbnail', function() {
		return function(data) {
			var img = '';

			if ((data !== '') && (data !== null)) {
				var url = '../upload/img/' + data;
				var request = new XMLHttpRequest();
				request.open('HEAD', url, false);
				request.send();
				console.log("HERE: ", request.status)

				if(request.status == 200) {
					img = '<img src="../upload/img/' + data + '" class="img-thumbnail">';
				} else {
					img ='Image Missing';
				}
			} else {
				var img = '';
			}

			return img;
		}
	})
	.filter('unique', function() {
		return function(collection, keyname) {
			var output = [], 
				key = '',
				keys = [];

			angular.forEach(collection, function(item) {
				key = item[keyname];

				if(keys.indexOf(key) === -1) {
					if (key !== null) {
						keys.push(key); 
						output.push(item);
				  	}
				}
			});

			return output;
		};
	})
	.filter('today', function() {
		return function(collection, param) {
			var output = [],
				today = new Date(),
				today = today.setHours(0, 0, 0, 0)
				created = '';

			angular.forEach(collection, function(item) {
				created = new Date(item.created);
				created = created.setHours(0, 0, 0, 0);

				if (param == 'today') {
					if(today == created) {
						output.push(item);
					}	
				} else {
					output.push(item);
				}	
			});

			return output;
		};
	});
