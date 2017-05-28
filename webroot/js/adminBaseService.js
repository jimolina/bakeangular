angular
	.module('adminBase')
	.service('dataSummary', function($http) {

		var dataSummary = {};

	    dataSummary.getAll = function(section) {
	       return $http.get(section);
	    };

	    return dataSummary;
	})
	.service('dataRecord', function($http) {

		var dataRecord = {};

	    dataRecord.getDetail = function(section, recordId) {
	       return $http.get(section+'/'+recordId);
	    };

	    return dataRecord;
	})
	.service('doneStatusTodo', function($http) {

		var doneStatusTodo = {};

	    doneStatusTodo.changeStatus = function(section, recordId) {
	       return $http.get(section+'/'+recordId);
	    };

	    return doneStatusTodo;
	})
	.service('saveRecord', function($http) {

		var saveRecord = {};

	    saveRecord.save = function(section, recordId, dataRow, file) {
	    	var urlSend = (recordId) ? section + '/saveJson/' + recordId : section + '/addJson/',
        		fd = new FormData();

			angular.forEach(dataRow, function(value, key){
           		fd.append(key, value);
			});
			
           	fd.append('file', file);

			return 	$http({
				url: urlSend,
				method: 'POST',
				transformRequest: angular.identity,
				headers: { 'Content-Type': undefined },
                data: fd
			})
	    };

	    return saveRecord;
    })
	.service('recordDelete', function($http) {
		
		var recordDelete = {};

	    recordDelete.recordDel = function(section, recordId) {
	       return $http.post(section+'/'+recordId);
	    };

	    return recordDelete;
	});
