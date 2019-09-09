CREATE PROCEDURE `get_purchases_by_user`(IN `user_id` INT)
    NO SQL
BEGIN

SELECT id, user_card, taken_passes, training_school AS company_id, pay_to_company, pay_to_us, makerDate
FROM accepted_passes 
WHERE user = user_id;

END