angular
	.module('adminBase')
	.factory('gridFactory', function(){
		
		var gridFactory = function() {

				var gridData = [
				{
					"type": "Condo",
					"price": 12098.98,
					"address": "234 Grups Av."
				},
				{
					"type": "House",
					"price": 42293,
					"address": "2234 GIntr. Av."
				},
				{
					"type": "Appartment",
					"price": 12243,
					"address": "1034 GIntr. Av."
				},
				{
					"type": "Condo",
					"price": 12098,
					"address": "134 Central Av."
				},
				{
					"type": "House",
					"price": 42293,
					"address": "2234 GIntr. Av."
				},
				{
					"type": "Appartment",
					"price": 12243,
					"address": "1034 GIntr. Av."
				},
				{
					"type": "Condo",
					"price": 12098,
					"address": "234 Grups Av."
				},
				{
					"type": "House",
					"price": 42293,
					"address": "2234 GIntr. Av."
				},
				{
					"type": "Appartment",
					"price": 12243,
					"address": "1034 GIntr. Av."
				},
				{
					"type": "Condo",
					"price": 12098,
					"address": "234 Grups Av."
				},
				{
					"type": "House",
					"price": 42293,
					"address": "2234 GIntr. Av."
				},
				{
					"type": "Appartment",
					"price": 12243,
					"address": "1034 GIntr. Av."
				},
				{
					"type": "House",
					"price": 92293,
					"address": "234 GIntr. Av."
				}
			];

			return gridData;

		};
		

		return {
			getdataGrid: gridFactory
		}

	});