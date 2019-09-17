<?php

/**
 * 
 */
class DeleteModule{
	
	public static function delete_all_company_transactions_module($id){

		global $broker;

		$SQL_company_transactions = "UPDATE company_transactions SET recordStatus = 'C', checker = 'deleted' WHERE training_school = '".$id."'";

		$SQL_accepted_passes = "UPDATE accepted_passes SET recordStatus = 'C', checker = 'deleted' WHERE training_school = '".$id."'";
		$broker->execute_query($SQL_company_transactions);
		$broker->execute_query($SQL_accepted_passes);
	}


	public static function recall_company_transaction_module($id){
		
		global $broker;

		$SQL_credits_to_recall = "UPDATE purchase SET checker = '', po_payment_date = '', po_payment_name = '' WHERE id = '".$id."'";

		$broker->execute_query($SQL_credits_to_recall);

	}
}

?>