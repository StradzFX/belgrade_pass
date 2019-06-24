<div class="page_content">
	<?php include_once 'app/pages/template/company_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="personal_data">
						<div>
							<ul class="nav nav-tabs">
								<li role="presentation" class="tab_option new_card <?php if($selected_tab == 'new_card'){ ?>active<?php } ?>">
                                    <a href="javascript:void(0)" onclick="toggle_tab('new_card')">
                                       Aktivacija
                                    </a>
                                </li>
                                <li role="presentation" class="tab_option edit_cards <?php if($selected_tab == 'edit_cards'){ ?>active<?php } ?>">
                                    <a href="javascript:void(0)" onclick="toggle_tab('edit_cards')">
                                       Dopuna podataka
                                    </a>
                                </li>
                                <li role="presentation" class="tab_option all_cards <?php if($selected_tab == 'all_cards'){ ?>active<?php } ?>">
                                    <a href="javascript:void(0)" onclick="toggle_tab('all_cards')">
                                       Sve kartice
                                    </a>
                                </li>
                                <li role="presentation" class="tab_option cards_to_give <?php if($selected_tab == 'cards_to_give'){ ?>active<?php } ?>">
                                    <a href="javascript:void(0)" onclick="toggle_tab('cards_to_give')">
                                       Izdavanje
                                    </a>
                                </li>
                            </ul>
                            <?php include_once 'app/pages/views/elements/company/cards/new_card.php'; ?>
                            <?php include_once 'app/pages/views/elements/company/cards/edit_cards.php'; ?>
                            <?php include_once 'app/pages/views/elements/company/cards/all_cards.php'; ?>
                            <?php include_once 'app/pages/views/elements/company/cards/cards_to_give.php'; ?>
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