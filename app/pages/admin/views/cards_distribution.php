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
                  <li><a href="#partners" data-toggle="tab">From Partner</a></li>
                  <li><a href="#internal_cards" data-toggle="tab">Internal cards</a></li>
                </ul>
                <div class="tab-content">
                  <?php /* ================ WEBSITE ================== */ ?>
                  <div class="active tab-pane" id="website">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Card number</th>
                          <th>Date issued</th>
                          <th>Customer Name</th>
                          <th>Customer Phone</th>
                          <th>Customer Email</th>
                          <th>Address</th>
                          <th>Customer received</th>
                        </tr>
                        <?php for ($i=0; $i < sizeof($website_list); $i++) { ?>
                          <tr>
                            <td><?php echo $i+1; ?>.</td>
                            <td><?php echo $website_list[$i]->card_number; ?></td>
                            <td><?php echo $website_list[$i]->date_issued; ?></td>
                            <td><?php echo $website_list[$i]->full_name; ?></td>
                            <td><?php echo $website_list[$i]->phone; ?></td>
                            <td><?php echo $website_list[$i]->email; ?></td>
                            <td><?php echo $website_list[$i]->address; ?></td>
                            <td>
                                <?php echo $website_list[$i]->customer_received; ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>

                  <?php /* ================ PARTNERS ================== */ ?>
                  <div class=" tab-pane" id="partners">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Card number</th>
                          <th>Date issued</th>
                          <th>Customer Name</th>
                          <th>Customer Phone</th>
                          <th>Customer Email</th>
                          <th>Partner</th>
                          <th>Customer received</th>
                        </tr>
                        <?php for ($i=0; $i < sizeof($partner_list); $i++) { ?>
                          <tr>
                            <td><?php echo $i+1; ?>.</td>
                            <td><?php echo $partner_list[$i]->card_number; ?></td>
                            <td><?php echo $partner_list[$i]->date_issued; ?></td>
                            <td><?php echo $partner_list[$i]->full_name; ?></td>
                            <td><?php echo $partner_list[$i]->phone; ?></td>
                            <td><?php echo $partner_list[$i]->email; ?></td>
                            <td><?php echo $partner_list[$i]->partner->full_name; ?></td>
                            <td>
                                <?php echo $partner_list[$i]->customer_received; ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
                  </div>

                  <?php /* ================ INTERNAL ================== */ ?>
                  <div class=" tab-pane" id="internal_cards">
                    <table class="table table-striped">
                      <tbody>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Card number</th>
                          <th>Date issued</th>
                          <th>Customer Name</th>
                          <th>Customer Phone</th>
                          <th>Customer Email</th>
                          <th>Address</th>
                          <th>Customer received</th>
                        </tr>
                        <?php for ($i=0; $i < sizeof($internal_cards_list); $i++) { ?>
                          <tr>
                            <td><?php echo $i+1; ?>.</td>
                            <td><?php echo $internal_cards_list[$i]->card_number; ?></td>
                            <td><?php echo $internal_cards_list[$i]->date_issued; ?></td>
                            <td><?php echo $internal_cards_list[$i]->full_name; ?></td>
                            <td><?php echo $internal_cards_list[$i]->phone; ?></td>
                            <td><?php echo $internal_cards_list[$i]->email; ?></td>
                            <td><?php echo $internal_cards_list[$i]->address; ?></td>
                            <td>
                                <?php echo $internal_cards_list[$i]->customer_received; ?>
                            </td>
                          </tr>
                        <?php } ?>
                      </tbody>
                    </table>
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