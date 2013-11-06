<?php 
	function isOfClass($class, $pendingClass) {
		if (strpos($class, $pendingClass) !== false)
			return true;
		return false;
	}

	function isOfService($class) {
		return isOfClass($class, 'Service');
	}

	function isOfSecondHand($class) {
		return isOfClass($class, '二手物品');
	}

	function isOfActivity($class) {
		return isOfClass($class, 'activity');
	}
	
	function notOfBook($class) {
		if (strpos($class, 'Service') !== false)
			return true;
		if (strpos($class, 'activity') !== false)
			return true;
		if (strpos($class, '二手物品') !== false)
			return true;
		return false;
	}