<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Report | Unused cards
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Result</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-striped all_items">
                <tbody><tr>
                  <th>Card Number</th>
                  <th>User</th>
                  <th>Active packages</th>
                </tr>
                <?php for ($i=0; $i < sizeof($user_card_all); $i++) { ?>
                  <tr>
                    <td><?php echo $user_card_all[$i]->card_number; ?></td>
                    <td><?php echo $user_card_all[$i]->user->email; ?> (<?php echo $user_card_all[$i]->user->first_name; ?> <?php echo $user_card_all[$i]->user->last_name; ?>)</td>
                    <td><?php echo $user_card_all[$i]->active_packages; ?></td>
                  </tr>
                <?php } ?>
                
              </tbody></table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    <div>
    </section>
    <!-- /.content -->
</div>