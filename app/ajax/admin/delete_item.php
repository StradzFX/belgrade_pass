<?php
$data = $post_data['delete_data'];

switch ($data['section']) {
	case 'categories': 
		{
			list($success,$message,$id) = KryptonAdminController::delete_category($data);
		}
		break;

	case 'coaches': 
		{
			list($success,$message,$id) = KryptonAdminController::delete_coach($data);
		}
		break;

	case 'schools': 
		{
			list($success,$message,$id) = KryptonAdminController::delete_school($data);
		}
		break;
	case 'company_transaction': 
		{
			list($success,$message,$id) = KryptonAdminController::delete_company_transaction($data);
		}
		break;
	
	default:
		{
			$success = false;
			$message = 'Function for delete is not implemented.';
		}
		break;
}


echo json_encode(array("success"=>$success,"message"=>$message));