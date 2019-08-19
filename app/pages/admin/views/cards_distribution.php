<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Cards distribution
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">All data</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#website" data-toggle="tab">From Website</a></li>
                  <li><a href="#internal_cards" data-toggle="tab">Internal cards</a></li>
                </ul>
                <div class="tab-content">
                  <?php /* ================ WEBSITE ================== */ ?>
                  <div class="active tab-pane" id="website">
                    <input type="hidden" name="id" value="0">
                    <div class="website_card_distribution_holder">
                      
                    </div>
                  </div>
                  <?php /* ================ INTERNAL ================== */ ?>
                  <div class=" tab-pane" id="internal_cards">
                    <input type="hidden" name="id" value="0">
                     <div class="internal_card_distribution_holder">
                       
                     </div>
                  </div>
                </div>
              </div>


              
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

<script type="text/javascript">
  function get_card_distribution_from_website(){
    var data={};
        data.id=$('[name="id"]').val();

    var call_url = 'get_card_distribution_from_website'
    var call_data ={data:data}
    var callback = function(response){
      $('.website_card_distribution_holder').html(response)
    }
    ajax_call(call_url, call_data, callback);
  }

  function get_card_distribution_internal(){
    var data={};
        data.id=$('[name="id"]').val()

    var call_url='get_card_distribution_internal'
    var call_data={data:data}
    var callback=function(response){
      $('.internal_card_distribution_holder').html(response);
    }
    ajax_call(call_url, call_data, callback);
    
  }

  $(function(){
    get_card_distribution_from_website()
  });

  $(function(){
    get_card_distribution_internal();
  });
</script>

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