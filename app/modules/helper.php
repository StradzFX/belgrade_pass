<?php 

class HelperModule{
	public static function translate_card_number_format($card_number){
		$card_number = (int)$card_number;
		if($card_number < 100000){
			if($card_number < 10000){
				if($card_number < 1000){
					if($card_number < 100){
						if($card_number < 10){
							$card_number = '00000'.$card_number;
						}else{
							$card_number = '0000'.$card_number;
						}
					}else{
						$card_number = '000'.$card_number;
					}
				}else{
					$card_number = '00'.$card_number;
				}
			}else{
				$card_number = '0'.$card_number;
			}
		}
		return $card_number;
	}
}