angular
	.module('adminBase')
	.filter('startFrom', function() {

		return function(data, start) {

			// var filtered = [];
			// return function(listings, start) {
				return data.slice(start);
			// }

			// if ((title) || (body)) {
			// 	angular.forEach(listings, function(listing) {
			// 		if ((title) && (body)) {
			// 			if ((listing.title === title) && (listing.body === body)) {

			// 				filtered.push(listing);
			// 			}
			// 		} else if ((title) && (!body) ) {
			// 			if (listing.title === title) {

			// 				filtered.push(listing);
			// 			}
			// 		}
			// 	});
			// } else {
			// 	angular.forEach(listings, function(listing) {
			// 		filtered.push(listing);
			// 	});
			// }

			// return filtered;
		}
	});