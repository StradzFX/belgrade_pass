<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        List of cards for internal usage
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All data</h3>

              <a class="btn btn-warning pull-right" href="internal_card_reserve/">Make reservations</a>
              <a class="btn btn-success pull-right" style="margin-right: 10px;" href="internal_card_assign/">Assign new card</a>


            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
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
                        </a>
                    </td>
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

<style type="text/css">
  .table i{
    border-radius: 5px;
    border: 1px solid #3c8dbc;
    padding: 5px;
  }

  .table i:hover{
    color:#fff;
    background-color: #3c8dbc;
  }
</style>