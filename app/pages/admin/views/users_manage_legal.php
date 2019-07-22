<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Company Profile
      </h1>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile"> 
              <h3 class="profile-username text-center"><i class="fa fa-building"></i> Prasad & Sons</h3>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>PIB</b> <a class="pull-right">123456</a>
                </li>
                <li class="list-group-item">
                  <b>Matični broj</b> <a class="pull-right">246810121416</a>
                </li>
                <li class="list-group-item">
                  <b>Email</b> <a class="pull-right">prasad@gmail.com</a>
                </li>
                <li class="list-group-item">
                  <b>Adress</b> <a class="pull-right">Gorje pruge bb</a>
                </li>
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->

          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Izmeni podatke</a></li>
              <li><a href="#cards_all" data-toggle="tab">Kartice</a></li>
              <li><a href="#bills" data-toggle="tab">Računi</a></li>
              <li><a href="#settings" data-toggle="tab">Transakcije</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                <div class="row">
                  <div class="col-12 col-xs-12">
                    <div class="form-group">
                      <label for="company_name">Naziv preduzeća:</label>
                      <input type="text" name="company_name" class="form-control" value="Prasad & Sons">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <div class="form-group">
                      <label for="adress">Adresa:</label>
                      <input type="text" name="adress" class="form-control" value="Gornje pruge bb">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="pib">PIB:</label>
                      <input type="text" name="pib" class="form-control" value="123456">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="presonal_nr">Matični:</label>
                      <input type="text" name="presonal_nr" class="form-control" value="246810121416">
                    </div>
                  </div>
                  <div class="col-12 col-xs-12">
                    <div class="form-group">
                      <label for="email">Email:</label>
                      <input type="text" name="phone" class="form-control" value="prasad@gmail.com">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="pass">Lozinka:</label>
                      <input type="password" name="pass" class="form-control">
                    </div>
                  </div>
                  <div class="col-12 col-xs-6">
                    <div class="form-group">
                      <label for="confirm_pass">Ponovi Lozinku:</label>
                      <input type="password" name="confirm_pass" class="form-control">
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
              <div class="tab-pane" id="cards_all">
                <div class="row">
                  <div class="col-12 col-xs-3">
                    <div class="form-group">
                      <label>Search by card number:</label>
                        <input type="text" class="form-control" value="example 000022">
                    </div>
                  </div>
                    <div class="col-12 col-xs-3">
                      <div class="form-group">
                        <label>Search by user name:</label>
                        <input type="text" name="name" class="form-control">
                      </div>
                    </div>
                    <div class="col-12 col-xs-3">
                      <div class="form-group">
                        <label>Search by email:</label>
                          <input type="text" class="form-control" value="Email">
                      </div>
                    </div>
                  </div><br>
                <div class="row">
                  <div class="col-12 col-xs-12">
                    <table class="table table-hover">
                      <tr>
                          <th>ID</th>
                          <th>Broj Kartice</th>
                          <th>Ime i prezime</th>
                          <th>Email</th>
                          <th>Kredit</th>
                          <th>Akcije</th>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>000022</td>
                          <td>Pavle Jovanović</td>
                          <td>pavle_car@gmail.com</td>
                          <td>2255 din</td>
                          <td>
                            <button type="button" class="btn btn-primary btn-xs">Zameni Karticu</button>
                            <button type="button" class="btn btn-primary btn-xs">Potrošnja</button>
                            <button type="button" class="btn btn-primary btn-xs">Uplate</button>
                          </td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>000220</td>
                          <td>Strahinja Krstić</td>
                          <td>prasad@gmail.com</td>
                          <td>2375 din</td>
                          <td>
                            <button type="button" class="btn btn-primary btn-xs">Zameni Karticu</button>
                            <button type="button" class="btn btn-primary btn-xs">Potrošnja</button>
                            <button type="button" class="btn btn-primary btn-xs">Uplate</button>
                          </td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>000022</td>
                          <td>Nikola Jovanović</td>
                          <td>pavle_car@gmail.com</td>
                          <td>2255 din</td>
                          <td>
                            <button type="button" class="btn btn-primary btn-xs">Zameni Karticu</button>
                            <button type="button" class="btn btn-primary btn-xs">Potrošnja</button>
                            <button type="button" class="btn btn-primary btn-xs">Uplate</button>
                          </td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>000022</td>
                          <td>Pavle Jovanović</td>
                          <td>pavle_car@gmail.com</td>
                          <td>2255 din</td>
                          <td>
                            <button type="button" class="btn btn-primary btn-xs">Zameni Karticu</button>
                            <button type="button" class="btn btn-primary btn-xs">Potrošnja</button>
                            <button type="button" class="btn btn-primary btn-xs">Uplate</button>
                          </td>
                        </tr>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="bills">
                <div class="row">
                  <div class="col-12 col-xs-3">
                    <div class="form-group">
                      <label>Search by email:</label>
                        <input type="text" class="form-control" value="Email">
                    </div>
                  </div>
                  <div class="col-12 col-xs-3">
                    <div class="form-group">
                      <label>Search card number:</label>
                        <input type="text" class="form-control" value="br kartice 000022">
                    </div>
                  </div>
                    <div class="col-12 col-xs-3">
                      <div class="form-group">
                        <label>Transaction number</label>
                        <input type="text" name="transactio_number" class="form-control">
                      </div>
                    </div>
                </div><br>
                <div class="row">
                  <div class="col-12 col-xs-12">
                    <table class="table table-hover">
                      <tbody>
                        <tr>
                          <th>ID</th>
                          <th>Datum</th>
                          <th>Broj Fakture</th>
                          <th>Iznos</th>
                          <th>Štampaj</th>
                          <th>Status</th>
                          <th>Akcija</th>
                        </tr>
                        <tr>
                          <td>1</td>
                          <td>20.08.2019.</td>
                          <td>00001/2019</td>
                          <td>550 din</td>
                          <td><a href="#" class="btn btn-primary btn-xs"><i class="fa fa-copy"></i></a></td>
                          <td><span class="label label-success">Approved</span></td>
                          <td>
                          </td>
                        </tr>
                        <tr>
                          <td>2</td>
                          <td>10.04.2019.</td>
                          <td>00001/2019</td>
                          <td>250 din</td>
                          <td><a href="#" class="btn btn-primary btn-xs"><i class="fa fa-copy"></i></a></td>
                          <td><span class="label label-warning">Pending</span></td>
                          <td>
                            <button type="button" class="btn btn-primary btn-xs">Approve</button>
                          </td>
                        </tr>
                        <tr>
                          <td>3</td>
                          <td>20.07.2019.</td>
                          <td>00001/2019</td>
                          <td>50 din</td>
                          <td><a href="#" class="btn btn-primary btn-xs"><i class="fa fa-copy"></i></a></td>
                          <td><span class="label label-success">Approved</span></td>
                          <td>
                          </td>
                        </tr>
                        <tr>
                          <td>4</td>
                          <td>11.07.2019.</td>
                          <td>00001/2019</td>
                          <td>1750 din</td>
                          <td><a href="#" class="btn btn-primary btn-xs"><i class="fa fa-copy"></i></a></td>
                          <td><span class="label label-success">Approved</span></td>
                          <td>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <div class="tab-pane" id="settings">
                <div class="row">
                  <div class="col-12 col-xs-3">
                    <label>Date From:</label> 
                    <input type="date" class="form-control" value="2019-04-02" name="date_from" >
                  </div>
                  <div class="col-12 col-xs-3">
                    <label>Date to:</label>
                    <input type="date" class="form-control">
                  </div>
                  <div class="col-12 col-xs-3">
                    <label for="card_number">Search by card number</label>
                    <input type="text" name="card_number" class="form-control" value="example 000022">
                  </div>
                  <div class="col-12 col-xs-3">
                      <div class="form-group">
                        <label>Payments</label>
                        <select  class="form-control">
                          <option>Sve</option>
                          <option>Uplate</option>
                          <option>Potrošnja</option>
                        </select>
                      </div>
                    </div>
                </div><br>
                <div class="row">
                  <div class="col-12 col-xs-12">
                    <table class="table table-hover">
                      <tbody>
                        <tr>
                          <th style="width: 10px">#</th>
                          <th>Date</th>
                          <th>Company</th>
                          <th>Location</th>
                          <th>Total price</th>
                          <th>User payed</th>
                          <th>BP commision</th>
                          <th>Card Number</th>
                        </tr>
                        <tr>
                            <td>1.</td>
                            <td>30.06.2019 11:49:22</td>
                            <td>Dunavska priča</td>
                            <td>Kej oslobodjenja 69</td>
                            <td>365 RSD</td>
                            <td>328.50 RSD</td>
                            <td>11 RSD</td>
                            <td>000001</td>
                        </tr>
                        <tr>
                            <td>2.</td>
                            <td>27.06.2019 12:57:04</td>
                            <td>Ceger </td>
                            <td>Skerlićeva 20</td>
                            <td>255 RSD</td>
                            <td>229.50 RSD</td>
                            <td>8 RSD</td>
                            <td>000015</td>
                        </tr>
                        <tr>
                            <td>3.</td>
                            <td>26.06.2019 20:02:51</td>
                            <td>Kafeterija Šank</td>
                            <td>Nedeljka Gvozdenovića 22b</td>
                            <td>200 RSD</td>
                            <td>170.00 RSD</td>
                            <td>6 RSD</td>
                            <td>000022</td>
                        </tr>
                        <tr>
                          <td colspan="4"><b class="pull-right">Total</b></td>
                          <td>820 RSD</td>
                          <td>728 RSD</td>
                          <td>25 RSD</td>
                          <td></td>
                          <td></td>
                          <td></td>
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

   <!--<tbody>
        <tr>
          <th>ID</th>
          <th>Date</th>
          <th>Status</th>
          <th>Iznos</th>
        </tr>
        <tr>
          <td>1</td>
          <td>11-7-2014</td>
          <td><span class="label label-success">Approved</span></td>
          <td>750 din</td>
        </tr>
        <tr>
          <td>2</td>
          <td>11-7-2014</td>
          <td><span class="label label-warning">Pending</span></td>
          <td>1250 din</td>
        </tr>
        <tr>
          <td>3</td>
          <td>11-7-2014</td>
          <td><span class="label label-primary">Approved</span></td>
          <td>500 din</td>
        </tr>
        <tr>
          <td>4</td>
          <td>11-7-2014</td>
          <td><span class="label label-danger">Denied</span></td>
          <td>945 din</td>
        </tr>
      </tbody>-->