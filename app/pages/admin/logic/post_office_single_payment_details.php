<?php

global $broker;

$id = $url_params[0];
$list = new purchase($id);
$list = $broker->get_data($list);


