<?php

	global $broker;

	$data = $post_data['data'];

	$user_type['fizicko'] = array(
		'icon' => 'fa fa-user',
		'name' => 'Fizičko lice',
		'link' => 'users_manage'
	);

	$user_type['pravno'] = array(
		'icon' => 'fa fa-building',
		'name' => 'Pravno lice',
		'link' => 'users_manage_legal'
	);



	$user_all = new user();
	$user_all->set_condition('checker','!=','');
	$user_all->add_condition('recordStatus','=','O');
	if($data['email'] != ''){
		$user_all->add_condition('email','LIKE',"%".$data['email']."%");
	}

	if($data['card_number'] != ''){
		$user_all->add_condition('id','IN',"(SELECT user FROM user_card WHERE card_number LIKE '%".$data['card_number']."')");
	}

	if($data['name'] != ''){
		$SQL = "(naziv LIKE '%".$data['name']."%' OR CONCAT(first_name,' ',last_name) LIKE '%".$data['name']."%' OR CONCAT(last_name,' ',first_name) LIKE '%".$data['name']."%' )";
		$user_all->add_condition('','',$SQL);
	}

	if($data['user_type'] != ''){
		$user_all->add_condition('user_type','=',$data['user_type']);
	}
	$user_all->set_order_by('pozicija','DESC');
	$user_all = $broker->get_all_data_condition($user_all);

	for($i=0;$i<sizeof($user_all);$i++){
		if($user_all[$i]->user_type == 'fizicko'){
			$user_all[$i]->full_name = $user_all[$i]->first_name.' '.$user_all[$i]->last_name;
		}

		if($user_all[$i]->user_type == 'pravno'){
			$user_all[$i]->full_name = $user_all[$i]->naziv;
		}

		$user_all[$i]->user_type = $user_type[$user_all[$i]->user_type];
	}


?>
<?php if(sizeof($user_all) > 0){ ?>
<table class="table table-striped all_items">
    <tbody>
        <tr>
          <th style="width: 10px">#</th>
          <th>User type</th>
          <th>Name</th>
          <th>Email</th>
          <th style="width: 100px">Actions</th>
        </tr>
        <?php for($i=0;$i<sizeof($user_all);$i++){ ?>
        <tr>
        	<td><?php echo $i+1; ?>.</td>
        	<td><i class="<?php echo $user_all[$i]->user_type['icon']; ?>"></i> <?php echo $user_all[$i]->user_type['name']; ?></td>
        	<td><?php echo $user_all[$i]->full_name; ?></td>
        	<td><?php echo $user_all[$i]->email; ?></td>
        	<input type="hidden" name="id" value="0">
        	<td>
                <div class="btn btn-primary">
                    <a href="<?php echo $user_all[$i]->user_type['link']; ?>/<?php echo $user_all[$i]->id; ?>" class="action">
                      <i class="fas fa-edit"></i>
                    </a>
                </div>
                <div class="btn btn-primary">
                    <a href="javascript:void(0)" class="action" data-toggle="modal" data-target="#modal-user-delete">
                      <i class="fa fa-trash" title="delete">
                      </i>
                    </a>
            	</div>
            </td>
        </tr>
        <?php } ?>
  	</tbody>
</table>
<?php }else{ ?>
<div class="no-results">
	No results for this search
</div>
<?php } ?>
