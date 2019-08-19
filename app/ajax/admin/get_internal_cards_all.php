<?php
global $broker;
$data=$post_data['data'];
$list = CardModule::list_created_internal_reservation_cards();
?>

<table class="table table-striped">
                <tbody><tr>
                  <th style="width: 10px">#</th>
                  <th>Card number</th>
                  <th>User</th>
                  <th>Actions</th>
                </tr>
                <?php for ($i=0; $i < sizeof($list); $i++) { ?>
                  <tr>
                    <td><?php echo $i+1; ?>.</td>
                    <td><?php echo $list[$i]->card_number; ?></td>
                    <td><?php echo $list[$i]->user->email; ?></td>
                    <td>
                        <a href="admin_payments_create/?preselected_card=<?php echo $list[$i]->card_number; ?>">
                          <div class="btn btn-primary">
                            <i class="fa fa-money" title="Admin payment"></i>
                          </div>
                          <a href="card_info">
                            <div class="btn btn-primary">
                                <i class="fa fa-info-circle"></i>
                            </div>
                          </a>
                          
                        </a>
                    </td>
                  </tr>
                <?php } ?>
                
              </tbody></table>