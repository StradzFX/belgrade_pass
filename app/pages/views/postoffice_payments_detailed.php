<?php include_once 'app/pages/admin/views/elements/company_manage/modal-user-delete.php';?>

<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Post Office Payment Details
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Info</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-12 col-xs-4">
                  <div class="form-group">
                    <input type="hidden" name="id" value="0">
                    <label>Ime i Prezime/Naziv kompanije</label>
                      <input type="text" class="form-control" value="Marko Markovic">
                  </div>
                </div>
                <div class="col-12 col-xs-4">
                  <div class="form-group">
                    <label>Broj Kartice</label>
                      <input type="text" class="form-control" value="0022">
                  </div>
                </div>
                <div class="col-12 col-xs-4">
                  <div class="form-group">
                    <label>Uplaćeno sa računa</label>
                      <input type="text" class="form-control" value="160-2508479955-68">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-xs-4">
                  <div class="form-group">
                    <label>Svrha uplate</label>
                      <input type="text" class="form-control" value="uplata kredita">
                  </div>
                </div>
                <div class="col-12 col-xs-4">
                  <div class="form-group">
                    <label>Poziv na broj</label>
                      <input type="text" class="form-control" value="02/2019">
                  </div>
                </div>
                <div class="col-12 col-xs-4">
                  <div class="form-group">
                    <label>Odobreno</label>
                    <select class="form-control">
                      <option>--</option>
                      <option>Da</option>
                      <option>Ne</option>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-xs-4">
                  <div class="form-group">
                    <label>Za računovodstvo</label>
                    <select class="form-control">
                      <option>--</option>
                      <option>Odobri</option>
                      <option>Nepopunjeni</option>
                    </select>
                  </div>
                </div>
                <div class="col-12 col-xs-4">
                  <label>Datum uplate</label> 
                  <input type="date" class="form-control" value="2019-04-02" name="date_from" onchange="get_company_transactions()">
                </div>
              </div>
              <div class="row">
                <div class="col-12 col-xs-4">
                  <td>
                  <a href="javascript:void(0)" class="btn btn-primary">
                  <i class="fas fa-redo-alt"></i></a>
                </td>
                </div>
              </div><br>
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

<style type="text/css">
  .all_items a.action{
    display: inline-block;
    border-radius: 3px;
      
    
    text-align: center;
    color: #fff;
  }


  .all_items a.stats{
    display: inline-block;
    border-radius: 3px;
    
    text-align: center;
    
   
  }

  .all_items a.stats:hover{
    background-color: #c0eaff;
  }

  .red{
    color: gold;
  }


  .silver{
    color: gray;
  }
</style>

<script type="text/javascript">
    
</script>