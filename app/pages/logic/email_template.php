<?php

$email_template = file_get_contents('app/mailer/html/general_white_template.html');
$email_content = file_get_contents('app/mailer/html/content_nova_pozorista_2.html');

$email_template = str_replace('cid:company_logo', '../public/images/mailer/company_logo_purple.png', $email_template);
$email_template = str_replace('{content}', $email_content, $email_template);
echo $email_template;
die();