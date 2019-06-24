<?php

$success = false;
$message = "POST was made";

$post_data = $_POST;
$facebook_user = $post_data['facebook_user'];

$user_insert_validation = new user();
$user_insert_validation->set_condition('recordStatus','=','O');
$user_insert_validation->add_condition('checker','!=','');
$user_insert_validation->add_condition('email','=',$facebook_user['email']);
$user_insert_validation->set_order_by('id','DESC');
$user_insert_validation = $broker->get_all_data_condition($user_insert_validation);

if(sizeof($user_insert_validation) == 0){  

    $arrContextOptions=array(
        "ssl"=>array(
            "verify_peer"=>false,
            "verify_peer_name"=>false,
        ),
    );  

	$avatar = time().'.jpg';
	file_put_contents('pictures/user/avatar/'.$avatar, file_get_contents('http://graph.facebook.com/'.$facebook_user['fb_id'].'/picture?type=large&w‌​idth=720&height=720', false, stream_context_create($arrContextOptions)));

    $user = new user();
    $user->email = $facebook_user['email'];
    $user->password = '';
    $user->avatar = $avatar;
    $user->fb_id = $facebook_user['fb_id'];
    $user->first_name = $facebook_user['first_name'];
    $user->last_name = $facebook_user['last_name'];
    $user->maker = 'system';
    $user->makerDate = date('c');
    $user->checker = 'system';
    $user->checkerDate = date('c');
    $user->jezik = 'rs';
    $user->recordStatus = 'O';
    
    $user = $broker->insert($user);
    $success = true;
    $message = "Registrovali ste se sa Facebook nalogom.";
}else{
	$user = $user_insert_validation[0];
    $success = true;
    $message = "Ulogovali ste se sa Facebook nalogom.";
}

$broker->set_session('user',$user);


echo json_encode(array("success"=>$success,"message"=>$message));
die();