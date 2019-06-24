<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
    Dashboard
  </h1>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
		<div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">
            	<i class="fa fa-user"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Total users</span>
              <span class="info-box-number">
              	<?php echo $total_users; ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">
            	<i class="fa fa-building"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Total partners</span>
              <span class="info-box-number">
              	<?php echo $total_companies; ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">
            	<i class="fa fa-credit-card"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Total cards</span>
              <span class="info-box-number">
              	<?php echo $total_cards; ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>

        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua">
            	<i class="fa fa-money"></i>
            </span>

            <div class="info-box-content">
              <span class="info-box-text">Total payments</span>
              <span class="info-box-number">
              	<?php echo $total_payments; ?>
              </span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
	</div>

	<div class="row">

		<div class="col col-sm-4">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Last 15 Post Office</h3>
	              <a href="post_office/" class="btn btn-success pull-right">See all</a>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <div class="table-responsive">
	                <table class="table no-margin">
	                  <thead>
	                  <tr>
	                    <th>Order ID</th>
	                    <th>Name</th>
	                    <th>Date</th>
	                  </tr>
	                  </thead>
	                  <tbody>
	                  <?php for ($i=0; $i < sizeof($post_office_list); $i++) { ?>
	                   <tr>
	                    <td>
	                    		<?php echo $post_office_list[$i]->id; ?>
	                    </td>
	                    <td>
	                    	<?php echo $post_office_list[$i]->user->email; ?>
	                    </td>
	                    <td>
	                    		<?php echo date('d.m.Y.',strtotime($post_office_list[$i]->makerDate)); ?>
	                    </td>
	                  </tr>
	                  <?php } ?>
	                  
	                  </tbody>
	                </table>
	              </div>
	              <!-- /.table-responsive -->
	            </div>
	            <!-- /.box-body -->
	          </div>
		</div>

		<div class="col col-sm-4">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Last 15 Payment Card</h3>
	              <a href="payment_cards/" class="btn btn-success pull-right">See all</a>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <div class="table-responsive">
	                <table class="table no-margin">
	                  <thead>
	                  <tr>
	                    <th>Order ID</th>
	                    <th>Name</th>
	                    <th>Date</th>
	                  </tr>
	                  </thead>
	                  <tbody>
	                  <?php for ($i=0; $i < sizeof($payment_card_list); $i++) { ?>
	                   <tr>
	                    <td>
	                    	<?php echo $payment_card_list[$i]->id; ?>
	                    </td>
	                    <td>
	                    	<?php echo $payment_card_list[$i]->user->email; ?>
	                    </td>
	                    <td>
	                    	<?php echo date('d.m.Y.',strtotime($payment_card_list[$i]->makerDate)); ?>
	                    </td>
	                  </tr>
	                  <?php } ?>
	                  
	                  </tbody>
	                </table>
	              </div>
	              <!-- /.table-responsive -->
	            </div>
	            <!-- /.box-body -->
	          </div>
		</div>

		<div class="col col-sm-4">
			<div class="box box-info">
	            <div class="box-header with-border">
	              <h3 class="box-title">Last 15 Partner payments</h3>
	              <a href="company_payments/" class="btn btn-success pull-right">See all</a>
	            </div>
	            <!-- /.box-header -->
	            <div class="box-body">
	              <div class="table-responsive">
	                <table class="table no-margin">
	                  <thead>
	                  <tr>
	                    <th>Order ID</th>
	                    <th>Company</th>
	                    <th>Card</th>
	                    <th>Date</th>
	                  </tr>
	                  </thead>
	                  <tbody>
	                  <?php for ($i=0; $i < sizeof($company_payment_list); $i++) { ?>
	                   <tr>
	                    <td>
	                    	<?php echo $company_payment_list[$i]->id; ?>
	                    </td>
	                    <td>
	                    	<?php echo $company_payment_list[$i]->company->name; ?>
	                    </td>
	                    <td>
	                    	<?php echo $company_payment_list[$i]->user_card->card_number; ?>
	                    </td>
	                    <td>
	                    	<?php echo date('d.m.Y.',strtotime($company_payment_list[$i]->makerDate)); ?>
	                    </td>
	                  </tr>
	                  <?php } ?>
	                  
	                  </tbody>
	                </table>
	              </div>
	              <!-- /.table-responsive -->
	            </div>
	            <!-- /.box-body -->
	          </div>
		</div>
		
	</div>
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->