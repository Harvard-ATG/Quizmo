<?php
switch(@$_SERVER['WEBROOTS_ENV']){
	case 'development':
		return 'dev';
	break;
	case 'staging':
		return 'stage';
	break;
	case 'testing':
		return 'test';
	break;
	case 'production':
		return 'prod';
	break;
	default:
		error_log("ERROR: Undefined environment: ".@$_SERVER['WEBROOTS_ENV']);
		error_log("ERROR: Defaulting to dev");
		return 'dev';
	break;
		
}
?>