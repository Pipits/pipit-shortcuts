<?php
	if ($CurrentUser->logged_in() && $CurrentUser->has_priv('pipit_shortcuts')) {
		$this->register_app('pipit_shortcuts', 'Pipit Shortcuts', 99, 'Shortcuts Dashboard Widget', '0.1');
        $this->require_version('pipit_shortcuts', '3.0');

		spl_autoload_register(function($class_name) {
			if (strpos($class_name, 'PipitShortcuts')===0) {
				include(PERCH_PATH.'/addons/apps/pipit_shortcuts/lib/'.$class_name.'.class.php');
				return true;
			}
			return false;
		});

		include_once(__DIR__.'/fieldtypes.php');
	}
	