<div class="page_content company_page_content">
	<?php include_once 'app/pages/template/company_menu.php'; ?>
	<div class="my-account">
		<div class="container">
			<div class="wrapper-main">
				<div class="user_data">
					<div class="title">Transakcije</div>
					<div class="personal_data">
						<?php if($any_transaction){ ?>
						<div>
							<ul class="nav nav-tabs">
                                <li role="presentation" class="payment_option approved_passes <?php if($selected_tab == 'approved_passes'){ ?>active<?php } ?>">
                                    <a href="javascript:void()" onclick="toggle_transaction_card('approved_passes')">
                                       Naplata računa kupcima
                                    </a>
                                </li>
                                <?php if($company->type == 'master'){ ?>
                                <li role="presentation" class="payment_option payments_debit <?php if($selected_tab == 'payments_debit'){ ?>active<?php } ?>">
                                    <a href="javascript:void()" onclick="toggle_transaction_card('payments_debit')">
                                       Uplate provizije
                                    </a>
                                </li>
                                <li role="presentation" class="payment_option payments_credit <?php if($selected_tab == 'payments_credit'){ ?>active<?php } ?>">
                                    <a href="javascript:void()" onclick="toggle_transaction_card('payments_credit')">
                                       Isplate BelgradePass-a
                                    </a>
                                </li>
                                <?php } ?>
                            </ul>
                            <?php include_once 'app/pages/views/elements/company/transactions/package_payments.php'; ?>
                            <?php include_once 'app/pages/views/elements/company/transactions/approved_passes.php'; ?>
                            <?php include_once 'app/pages/views/elements/company/transactions/payments_from_company.php'; ?>
                            <?php include_once 'app/pages/views/elements/company/transactions/payments_to_company.php'; ?>
						</div>
						<?php }else{ ?>
						<div class="no_transactions">
							
							<i class="fas fa-credit-card"></i>
							<br/><br/>
							Trenutno nemate nikakve transakcije
						</div>
						<?php } ?>
						
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function toggle_transaction_card(option){
        $('.payment_option').removeClass('active');
        $('.'+option).addClass('active');
        $('.paying_option_box').hide();
        $('.payment_option_'+option).show();
    }
</script>