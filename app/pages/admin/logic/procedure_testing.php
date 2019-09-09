<?php

global $broker;

$SQL = "CALL get_purchases_by_user(44)";
$list = $broker->execute_sql_get_array($SQL);
