angular.module('angular-bs-tooltip', [])
.directive('tooltip', ()=> ({
	restrict: 'A',
	scope: {
		tooltip: '@?',
		tooltipPosition: '@?',
		tooltipContainer: '@?',
		tooltipTrigger: '@?',
		tooltipHtml: '<',
		tooltipShow: '<',
		tooltipTether: '<',
	},
	controller: function($scope, $element, $interval) {
		$scope.isVisible = false;

		/**
		* Rebuild the tooltip
		*/
		$scope.rebuild = ()=> {
			var elem = $($element);
			var isVisible = $scope.isVisible; // Local copy of the tooltip before we destroy it (or forced with tooltipShow)
			if (elem.hasClass('ng-tooltip')) elem.tooltip('destroy');

			$scope.rebuildTether();

			elem
				.on('shown.bs.tooltip', ()=> $scope.isVisible = true)
				.on('hidden.bs.tooltip', ()=> $scope.isVisible = false)
				.tooltip({
					title: $scope.tooltip,
					placement: $scope.tooltipPosition || 'top',
					container: $scope.tooltipContainer == 'element' ? false : 'body',
					trigger: ($scope.tooltipShow === true || $scope.tooltipShow === false) ? 'manual' : $scope.tooltipTrigger || 'hover',
					html: !! $scope.tooltipHtml,
					animation: false,
				})
				.addClass('ng-tooltip');

			if (
				$scope.tooltipShow === true ||
				($scope.tooltipShow !== false && isVisible)
			) elem.tooltip('show'); // Reshow the tooltip if we WERE using it before AND we dont have a forced hide
		};

		// Tethering {{{
		$scope.tether; // Tether object if we're using Tether mode
		$scope.tetherTimer;

		$scope.rebuildTether = ()=> {
			if ($scope.tooltipTether) { // Try to tether this tooltip
				var elem = $($element)

				elem.one('shown.bs.tooltip', ()=> { // Wait until the tooltip is visible then tether to it
					console.log('Shown!');
					$scope.tether = new Tether({
						element: elem.data('bs.tooltip').$tip[0],
						target: elem[0],
						attachment:
							$scope.tooltipPosition == 'top' ? 'bottom middle' :
							$scope.tooltipPosition == 'left' ? 'center right' :
							$scope.tooltipPosition == 'right' ? 'center left' :
							'top middle'
						,
						targetAttachment:
							$scope.tooltipPosition == 'top' ? 'top middle' :
							$scope.tooltipPosition == 'left' ? 'center left' :
							$scope.tooltipPosition == 'right' ? 'center right' :
							'bottom middle'
					});

					// If its a number
					if ($scope.tooltipTether === true || isFinite($scope.tooltipTether))
						$scope.tetherTimer = $interval($scope.tether.position, $scope.tooltipTether === true ? 100 : $scope.tooltipTether);
				});

			} else if ($scope.tether) { // Destorying existing tether
				$scope.tether.destroy();
				$scope.tether = undefined;
				$interval.cancel($scope.tetherTimer);
			}
		};
		// }}}

		// Setup a watcher to rebuild if any visual properties change
		$scope.$watchGroup(['tooltip', 'tooltipPosition', 'tooltipContainer', 'tooltipTrigger', 'tooltipHtml', 'tooltipShow', 'tooltipTether'], $scope.rebuild);

		// Respond to upstream events {{{
		$scope.$on('bs.tooltip.reposition', ()=> {
			if ($scope.tether) { // Using Tether - ask it to reposition
				$scope.tether.position();
			} else { // Not using tether - destroy and rebuild
				$scope.rebuild();
			}
		});
		// }}}
	},
}));