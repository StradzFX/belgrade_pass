<div class="page_content">
	<?php include_once 'app/pages/template/company_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
                    <div class="title">Rezervacije rođendana</div>
                    <br/>
					<div class="personal_data">
						<div>
							<ul class="nav nav-tabs">
								<li role="presentation" class="tab_option reservations <?php if($selected_tab == 'reservations'){ ?>active<?php } ?>">
                                    <a href="javascript:void(0)" onclick="toggle_tab('reservations')">
                                       Rezervacije
                                    </a>
                                </li>
                                <li role="presentation" class="tab_option done_deals <?php if($selected_tab == 'done_deals'){ ?>active<?php } ?>">
                                    <a href="javascript:void(0)" onclick="toggle_tab('done_deals')">
                                       Zakazani rođendani
                                    </a>
                                </li>
                            </ul>
                            <?php include_once 'app/pages/views/elements/company/birthdays/reservations.php'; ?>
                            <?php include_once 'app/pages/views/elements/company/birthdays/done_deals.php'; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.container -->
	</div>
	<!-- /.form-content -->	
</div>
<!-- /.form-content -->	

<script type="text/javascript">
	function toggle_tab(option){
        $('.tab_option').removeClass('active');
        $('.'+option).addClass('active');
        $('.tab_box').hide();
        $('.tab_box_'+option).show();
    }
</script>