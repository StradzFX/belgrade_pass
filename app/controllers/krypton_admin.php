<?php

class KryptonAdminController{
	public static function login_user($login_data){
		$success = false;
		$message = 'Post was made';
		$user = KryptonAdminModule::get_user($login_data['username']);
		if($user){
			if($user->password == md5($login_data['password'])){
				$success = true;
				$message = 'You are logged in.';

				$_SESSION['admin'] = $user->username;
			}else{
				$message = 'Password does not match';
			}
		}else{
			$message = 'User does not exists';
		}

		return array($success,$message);
	}


	public static function logout_user(){
		unset($_SESSION['admin']);

		$success = true;
		$message = 'You are logged out';

		return array($success,$message);
	}

	public static function save_category($save_data){
		$success = false;
		$message = 'Entered into category save section, but could not save it';
		$id = null;

		$item = CategoryModule::save($save_data);
		if($item){
			$success = true;
			$message = 'Category saved';
			$id = $item->id;
		}

		return array($success,$message,$id);
	}

	public static function delete_category($delete_data){
		$success = false;
		$message = 'Entered into category delete section, but could not delete it';

		CategoryModule::delete($delete_data);

		$item = CategoryModule::get_admin_data($delete_data['id']);
		if(!$item){
			$success = true;
			$message = 'Category deleted';
		}

		return array($success,$message);
	}

	public static function save_coach($save_data){
		$success = false;
		$message = 'Entered into coach save section, but could not save it';
		$id = null;

		$item = CoachModule::save($save_data);
		if($item){
			$success = true;
			$message = 'Category saved';
			$id = $item->id;
		}

		return array($success,$message,$id);
	}

	public static function delete_coach($delete_data){
		$success = false;
		$message = 'Entered into coach delete section, but could not delete it';

		CoachModule::delete($delete_data);

		$item = CoachModule::get_admin_data($delete_data['id']);
		if(!$item){
			$success = true;
			$message = 'Coach deleted';
		}

		return array($success,$message);
	}

	public static function save_school($save_data){
		$success = false;
		$message = 'Entered into school save section, but could not save it';
		$id = null;

		$error_message = null;
		if($save_data['sport_category'] == ''){$error_message = 'Please select category of sport.';}
		if($save_data['name'] == ''){$error_message = 'Please insert name of the school.';}

		if(!$error_message){
			$item = SchoolModule::save($save_data);
			if($item){
				$success = true;
				$message = 'School saved';
				$id = $item->id;
			}
		}else{
			$message = $error_message;
		}
		

		return array($success,$message,$id);
	}

	public static function save_company_transaction($save_data){
		global $broker;

		$success = false;
		$message = 'Entered into school save section, but could not save it';
		$id = null;

		$error_message = null;
		if($save_data['training_school'] == ''){$error_message = 'Please select company.';}
		if($save_data['transaction_type'] == ''){$error_message = 'Please select transaction type.';}
		if($save_data['transaction_value'] == ''){$error_message = 'Please insert value.';}
		if($save_data['transaction_date'] == ''){$error_message = 'Please select date.';}

		if(!$error_message){

			$save_data['transaction_date'] = explode('.', $save_data['transaction_date']);
			$save_data['transaction_date'] = 
				$save_data['transaction_date'][2].'-'.
				$save_data['transaction_date'][1].'-'.
				$save_data['transaction_date'][0].'-';


			$id = $save_data['id'];
			if($save_data['id'] == 0){         
			    $company_transactions = new company_transactions();
			    $company_transactions->training_school = $save_data['training_school'];
			    $company_transactions->transaction_type = $save_data['transaction_type'];
			    $company_transactions->transaction_value = $save_data['transaction_value'];
			    $company_transactions->transaction_date = $save_data['transaction_date'];
			    $company_transactions->maker = 'system';
			    $company_transactions->makerDate = date('c');
			    $company_transactions->checker = 'system';
			    $company_transactions->checkerDate = date('c');
			    $company_transactions->jezik = 'rs';
			    $company_transactions->recordStatus = 'O';
			    
			    $company_transactions = $broker->insert($company_transactions);
			    $success = true;
			    $message = "You have inserted object.";
			}else{
				$company_transactions = $broker->get_data(new company_transactions($save_data['id']));
				$company_transactions->training_school = $save_data['training_school'];
			    $company_transactions->transaction_type = $save_data['transaction_type'];
			    $company_transactions->transaction_value = $save_data['transaction_value'];
			    $company_transactions->transaction_date = $save_data['transaction_date'];
			    $broker->update($company_transactions);
			    $success = true;
			    $message = "Object exists in database.";
			}

		}else{
			$message = $error_message;
		}
		

		return array($success,$message,$id);
	}

	public static function delete_school($delete_data){
		$success = false;
		$message = 'Entered into school delete section, but could not delete it';

		SchoolModule::delete($delete_data);

		$item = SchoolModule::get_admin_data($delete_data['id']);
		if(!$item){
			$success = true;
			$message = 'School deleted';
		}

		return array($success,$message);
	}

	public static function delete_company_transaction($delete_data){
		global $broker;
		$success = false;
		$message = 'Entered into school delete section, but could not delete it';

		$ct = $broker->get_data(new company_transactions($delete_data['id']));
		$broker->delete($ct);

		$item = $broker->get_data(new company_transactions($delete_data['id']));
		if(!$item->id){
			$success = true;
			$message = 'School deleted';
		}

		return array($success,$message);
	}


	


}