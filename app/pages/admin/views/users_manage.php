<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <h3 class="profile-username text-center"><i class="fa fa-user"></i> Pavle Jovanović</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Tip Korisnika</b> <a class="pull-right">Fizičko lice</a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right">pavle_car@gmail.com</a>
                </li>
                <li class="list-group-item">
                  <b>Kartica br:</b> <a class="pull-right">000022</a>
                </li>
                <li class="list-group-item">
                  <b>Preostalo kredita</b> <a class="pull-right">2150 din</a>
                </li>
                <li class="list-group-item">
                  <div class="pic-frame">
                      <img src="/belgrade_pass/pictures/000020.png">
                  </div>
                </li>
              </ul>

              <a href="#" class="btn btn-warning btn-block"><b>Promeni karticu</b></a>
              <a href="#" class="btn btn-primary btn-block"><b>Uplati kredit</b></a>
              <a href="#" class="btn btn-primary btn-block"><b>Pošalji PIN na Email</b></a>
              <a href="#" class="btn btn-danger btn-block"><b>Obriši korisnika</b></a>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Izmeni podatke</a></li>
              <li><a href="#payments" data-toggle="tab">Uplate</a></li>
              <li><a href="#charges" data-toggle="tab">Potrošnja</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <div class="row">
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="name">Ime:</label>
                      <input type="text" name="name" class="form-control" value="Pavle">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="surname">Prezime:</label>
                      <input type="text" name="surname" class="form-control" value="Jovanović">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <div class="form-group">
                      <label for="mail">Email</label>
                      <input type="text" name="mail" class="form-control" value="pavle_car@gmail.com">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="phone">Lozinka</label>
                      <input type="password" name="phone" class="form-control" value="">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="confirm_pass">Ponovi Lozinku</label>
                      <input type="password" name="phone" class="form-control" value="">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <a href="users_all/">
                      <div class="btn btn-primary pull-right">Sačuvaj</div>
                    </a>
                    <a href="users_all/">
                      <div class="btn btn-default">Nazad</div>
                    </a>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="payments">
                <div>
                  <table class="table table-hover">
                    <tbody>
                      <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Credits</th>
                        <th>Payment type</th>
                        <th>Status</th>
                        <th>Actions</th>
                      </tr>
                      <tr>
                        <td>1</td>
                        <td>11.07.2014.</td>
                        <td>750 din</td>
                        <td>Post office</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>2</td>
                        <td>11.07.2014.</td>
                        <td>1250 din</td>
                        <td>Post office</td>
                        <td><span class="label label-warning">Pending</span></td>
                        <td><a href="#" class="btn btn-primary btn-xs">Approve</a></td>
                      </tr>
                      <tr>
                        <td>3</td>
                        <td>11.07.2014.</td>
                        <td>500 din</td>
                        <td>Post office</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td></td>
                      </tr>
                      <tr>
                        <td>4</td>
                        <td>11.07.2014.</td>
                        <td>945 din</td>
                        <td>Post office</td>
                        <td><span class="label label-success">Approved</span></td>
                        <td></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="tab-pane" id="charges">
                <div class="row">
                  <div class="col col-xs-3">
                    <label>Date From:</label>
                    <input type="date" class="form-control" value="2019-04-02" name="date_from" onchange="get_report_card_usage()">
                  </div>
                  <div class="col col-xs-3">
                    <label>Date to:</label>
                    <input type="date" class="form-control" value="2019-07-02" name="date_from" onchange="get_report_card_usage()">
                  </div>
                </div><br>
                <div class="row">
                  <div class="col-12 col-xs-12">
                    <table class="table table-striped all_items">
                      <tbody>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Date</th>
                          <th>Company</th>
                          <th>Location</th>
                          <th>Total price</th>
                          <th>User payed</th>
                          <th>BP commision</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>30.06.2019 11:49:22</td>
                            <td>Dunavska priča</td>
                            <td>Kej oslobodjenja 69</td>

                            <td>365 RSD</td>
                            <td>328.50 RSD</td>
                            <td>11 RSD</td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>27.06.2019 12:57:04</td>
                            <td>Ceger </td>
                            <td>Skerlićeva 20</td>

                            <td>255 RSD</td>
                            <td>229.50 RSD</td>
                            <td>8 RSD</td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>26.06.2019 20:02:51</td>
                            <td>Kafeterija Šank</td>
                            <td>Nedeljka Gvozdenovića 22b</td>

                            <td>200 RSD</td>
                            <td>170.00 RSD</td>
                            <td>6 RSD</td>
                        </tr>
                        <tr>
                          <td colspan="4"><b class="pull-right">Total</b></td>

                          <td>820 RSD</td>
                          <td>728 RSD</td>
                          <td>25 RSD</td>
                        </tr>
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>

  <style type="text/css">
    
    .pic-frame{
       background-size: cover;
    }

    img {
    max-width: 100%;
    }

  </style>