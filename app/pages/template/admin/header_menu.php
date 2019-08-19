<div class="user-panel" style="height: 38px;">
  <div class="pull-left" style="color: #949494;">
    <p>Logged in as: <b><?php echo $_SESSION['admin']; ?></b></p>
  </div>
</div>
<!-- search form -->
<ul class="sidebar-menu" data-widget="tree">
  <li class="header">MAIN NAVIGATION</li>
  <li class="treeview <?php if(in_array($page, array('categories_all','categories_manage','company_all','company_manage'))){ ?>active<?php } ?>">
    <a href="#">
      <i class="fa fa-list"></i>
      <span>Offers</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li class="treeview <?php if(in_array($page, array('categories_all','categories_manage'))){ ?>menu-open<?php } ?>" style="height: auto;">
        <a href="#"><i class="fa fa-list"></i> Categories
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if(in_array($page, array('categories_all','categories_manage'))){ ?>style="display:block"<?php } ?>>
          <li <?php if(in_array($page, array('categories_all'))){ ?>class="active"<?php } ?>><a href="categories_all/"><i class="fas fa-eye"></i> See all</a></li>
          <li <?php if(in_array($page, array('categories_manage'))){ ?>class="active"<?php } ?>>
            <a href="categories_manage/"><i class="fas fa-plus"></i></i> New
            </a>
          </li>
        </ul>
      </li>
      <li class="treeview <?php if(in_array($page, array('company_all','companies_manage'))){ ?>menu-open<?php } ?>" style="height: auto;">
        <a href="#"><i class="fa fa-building"></i> Companies
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu" <?php if(in_array($page, array('company_all','company_manage'))){ ?>style="display:block"<?php } ?>>
          <li <?php if(in_array($page, array('company_all'))){ ?>class="active"<?php } ?>><a href="company_all/"><i class="fas fa-eye"></i> See all</a></li>
          <li <?php if(in_array($page, array('company_manage'))){ ?>class="active"<?php } ?>>
            <a href="company_manage/"><i class="fas fa-plus"></i> New
            </a>
          </li>
        </ul>
      </li>
    </ul>
  </li>
  <li class="treeview <?php if(in_array($page, array('categories_all','categories_manage'))){ ?>active<?php } ?>">
    <a href="#">
      <i class="fa fa-credit-card"></i>
      <span>Cards</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
       <li class="treeview <?php if(in_array($page, array('company_cards_all','company_cards_manage','internal_cards_all','internal_card_assign','cards_distribution'))){ ?>active<?php } ?>" >
        <a href="#">
          <i class="fa fa-credit-card"></i>
          <span>Cards by type</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li <?php if(in_array($page, array('internal_cards_all','internal_card_assign'))){ ?>class="active"<?php } ?>><a href="internal_cards_all/"><i class="fas fa-address-card"></i> Internal use cards</a></li>
          <li <?php if(in_array($page, array('internal_cards_all','internal_card_assign'))){ ?>class="active"<?php } ?>><a href="company_cards_all/"><i class="fas fa-desktop"></i> Website cards</a></li>
          <li <?php if(in_array($page, array('cards_distribution'))){ ?>class="active"<?php } ?>><a href="cards_distribution/"><i class="fas fa-exchange-alt"></i> Cards distribution</a></li>
        </ul>
      </li>
      <li class="treeview <?php if(in_array($page, array('post_office','payment_cards','company_payments','admin_payments','admin_payments_create'))){ ?>active<?php } ?>">
        <a href="#">
          <i class="fa fa-credit-card"></i>
          <span>Payments</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li <?php if(in_array($page, array('admin_payments','admin_payments_create'))){ ?>class="active"<?php } ?>>
            <a href="admin_payments/"><i class="fas fa-user-shield"></i> Admin payments</a>
          </li>
          <li <?php if(in_array($page, array('post_office'))){ ?>class="active"<?php } ?>>
            <a href="post_office/"><i class="fas fa-mail-bulk"></i> Post Office</a>
            <li <?php if(in_array($page, array('post_office'))){ ?>class="active"<?php } ?>>
            <a href="invoices/"><i class="fas fa-file-invoice"></i></i>      Invoices</a>
          </li>
        </ul>
      </li>
    </ul>
  </li>

  <?php /*<li class="treeview">
    <a href="#">
      <i class="fa fa-user"></i>
      <span>Coaches</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li><a href="coaches_all/"><i class="fa fa-circle-o"></i> See all</a></li>
      <li><a href="coaches_manage/"><i class="fa fa-circle-o"></i> New</a></li>
    </ul>
  </li> */ ?>

 
  <li><a href="users_all/"><i class="fa fa-users"></i><span>Users</span></a></li>
  
  <li class="treeview <?php if(in_array($page, array('report_unused_cards','report_card_usage'))){ ?>active<?php } ?>">
    <a href="#">
      <i class="fa fa-signal"></i>
      <span>Reports</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      <li <?php if(in_array($page, array('report_card_usage'))){ ?>class="active"<?php } ?>>
        <a href="report_card_usage/"><i class="fas fa-tachometer-alt"></i> Card Usage</a>
      </li>
      <li <?php if(in_array($page, array('report_unused_cards'))){ ?>class="active"<?php } ?>>
        <a href="report_unused_cards/"><i class="fas fa-calendar-times"></i> Unused cards</a>
      </li>
    </ul>
  </li>

  

  <li><a href="javascript:void(0)" onclick="logout()"><i class="fa fa-power-off"></i> <span>Log out</span></a></li>
</ul>