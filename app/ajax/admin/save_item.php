<?php
$data = $post_data['save_data'];

switch ($data['section']) {
	case 'categories': 
		{
			list($success,$message,$id) = KryptonAdminController::save_category($data);
		}
		break;

	case 'coaches': 
		{
			list($success,$message,$id) = KryptonAdminController::save_coach($data);
		}
		break;

	case 'schools': 
		{
			list($success,$message,$id) = KryptonAdminController::save_school($data);
		}
		break;

	case 'company_transaction': 
		{
			list($success,$message,$id) = KryptonAdminController::save_company_transaction($data);
		}
		break;

	case 'admin_payment': 
		{
			list($success,$message,$id) = PaymentModule::save_admin_payment($data);
		}
		break;
	
	default:
		{
			$success = false;
			$message = 'Function for save is not implemented.';
			$id = 0;
		}
		break;
}


echo json_encode(array("success"=>$success,"message"=>$message,"id"=>$id));