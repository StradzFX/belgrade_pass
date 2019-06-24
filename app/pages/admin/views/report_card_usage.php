<script
  src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"
  integrity="sha256-VazP97ZCwtekAsvgPBSUwPFKdrwD3unUfSGVYrahUqU="
  crossorigin="anonymous"></script>


<div class="content-wrapper" style="min-height: 960px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Reports | Card Usage
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Filters</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col col-sm-2">
                  Date From:<br/>
                  <input type="date" class="form-control" value="<?php echo $filter_date_from; ?>" name="date_from" onchange="get_report_card_usage()">
                </div>

                <div class="col col-sm-2">
                  Date To:<br/>
                  <input type="date" class="form-control" value="<?php echo $filter_date_to; ?>" name="date_from" onchange="get_report_card_usage()">
                </div>

                <div class="col col-sm-2">
                  Company:<br/>
                  <select name="company" class="form-control" onchange="get_report_card_usage()">
                    <option value="">Select company</option>
                    <?php for ($i=0; $i < sizeof($company_list); $i++) { ?>
                      <option value="<?php echo $company_list[$i]->id; ?>" <?php if($preselected_company == $company_list[$i]->id){ ?>selected="selected"<?php } ?>><?php echo $company_list[$i]->name; ?></option>
                    <?php } ?>
                  </select>
                  </div>

                <div class="col col-sm-2">
                    User Email or Full Name:<br/>
                    <input type="text" class="form-control" value="" name="user_search" onkeyup="get_report_card_usage()">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Result</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body no-padding result_holder">
              
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
  .all_items a{
    display: inline-block;
    border-radius: 3px;
    background-color: #bbbfc1;
    width: 20px;
    text-align: center;
    color: #000;
  }
  .red{
    color: gold;
  }


  .silver{
    color: gray;
  }
</style>

<script type="text/javascript">
    function get_report_card_usage(){
      var data = get_page_filters();

      var call_url = "get_report_card_usage";  
      var call_data = { 
        data:data 
      }  
      var callback = function(response){  
        $('.result_holder').html(response);
      }  
      ajax_call(call_url, call_data, callback); 
    }


    function get_page_filters(){
      var filters = {};
          filters.date_from = $('[name="date_from"]').val();
          filters.date_to = $('[name="date_to"]').val();
          filters.company = $('[name="company"]').val();
          filters.user_search = $('[name="user_search"]').val();

          return filters;
    }

    $(function(){
      get_report_card_usage();
    });
</script>