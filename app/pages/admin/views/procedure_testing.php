<?php include_once 'app/pages/admin/views/elements/company_manage/modal-user-delete.php';?>

<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        User List
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">PROCEDURE TESTING</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
     				<table class="table">
     						<tr>
	     						<th>ID</th>
	     						<th>USER CARD</th>
	     						<th>TAKEN PASSES</th>
	     					</tr>
     					<?php for ($i=0; $i < sizeof($list); $i++) { ?> 
	     					<tr>
	     						<td><?php echo $list[$i]['id']; ?></td>
	     						<td><?php echo $list[$i]['user_card']; ?></td>
	     						<td><?php echo $list[$i]['taken_passes']; ?></td>
	     					</tr>
     					<?php } ?>
     					
     				</table>
	        </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
  
        <!-- /.col -->
 
      <!-- /.row -->
    <div>
    </section>
    <!-- /.content -->
</div>
