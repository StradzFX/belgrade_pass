<div class="container post_office_page">
    <div class="row">
        <div class="col-12 col-lg-12 ">
            <div class="offer_column">
                <div class="offer_section">
                    <div class="title">
                        Kreirana uplatnica
                    </div>
                    <div class="content">
                        <div class="success_message">
                            Uspešno ste izvršili rezervaciju paketa!
                        </div>
                        <div>
                            - Da bi Vam paket bio aktiviran, morate uplatiti navedeni iznos u najbližoj pošti, banci ili e-banking nalogom. <br/>

                             - Rok za uplatu je 5 radnih dana od trenutka rezervacije paketa.  <br/>

                             - U nastavku je prikazan primer popunjene uplatnice.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="offer_column">
                <div class="offer_section">
                    <div class="title">
                        Primer uplatnice
                    </div>
                    <div class="content">
                        <span id="za_stampu">
                            <img src="<?php echo $base_url; ?>public/images/post_office/<?php echo $purchase->id; ?>.jpg" id="uplatnica"  />
                        </span>
                        <div id="print">
                            <br/>
                            <a href="javascript:void(0)" name="dugme_stampaj_uplatnicu" class="btn btn-success">
                                Odštampaj uplatnicu
                            </a>

                        </div><!--print-->
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="offer_column">
                <div class="offer_section">
                    <div class="title">
                        Uputstvo za uplatu
                    </div>
                    <div class="content">
                        <div class="step_item">
                            <p><strong>1</strong> Odštampajte popunjenu uplatnicu. Ako sami popunjavate uplatnicu, ne zaboravite da navedete poziv na broj.</p>

                            <div style="clear:both"></div>
                        </div><!--step-->

                        <div class="step_item">
                            <p><strong>2</strong> Navedeni iznos uplatite u najbližoj banci ili putem e-banking naloga. Uplatu možete izvršiti najkasnije 5 radna dana nakon isteka ponude.</p>
                            <div style="clear:both"></div>
                        </div><!--step-->

                        <div class="step_item">
                            <p><strong>3</strong> Nakon evidentiranja Vaše uplate na KIDPASS žiro-računu, paket će biti aktiviran na Vašem profilu.</p>
                            <div style="clear:both"></div>
                        </div><!--step-->

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style type="text/css">
    .promo_image{
        width: 100%;
        display: block;
        margin-bottom: 20px;
    }
</style>

<script type="text/javascript">
	$("[name='dugme_stampaj_uplatnicu']").click(function(){
	 	var html = $('#za_stampu').html();
	  	print_html(html);
	});

	function print_html(html){
  		var imgWindow = window.open('', 'popup', 'toolbar=no,menubar=no,width=1000,height=800');
  			imgWindow.document.open();
  			imgWindow.document.write("<html><head></head><body onload='window.print()'>"+html+"</body></html>");
  			imgWindow.document.close();
	}
</script>