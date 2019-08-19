<div class="page_content">
<?php include_once 'app/pages/template/user_menu.php'; ?>
<div class="my-account">
	<div class="container">

		<?php include_once 'app/pages/views/elements/company/home/company_home.php'; ?>
		<?php include_once 'app/pages/views/elements/company/home/retail_home.php'; ?>


	</div>
</div>

<script type="text/javascript">
	function resend_card_data(){
    var data = {};
        data.forgot_email = 'nesto';
    var call_url = "resend_card_data";  

    var call_data = { 
        data:data 
    }  

    var callback = function(response){  
      if(response.success){
        var valid_selector = 'success';
      }else{
        var valid_selector = 'error';
      }
      show_user_message(valid_selector,response.message);

    }  
    ajax_json_call(call_url, call_data, callback);  
  }
</script>
		<!-- /.wrapper-main -->

	<?php /*
		<div class="inv-projects-blog-headline border-orange">
			<h2>PROJECTS THAT YOU JOIN</h2>

			<a class="waves-effect waves-light btn orange darken-2 right" href="#">
				Submit project
			</a>
			<!-- /.button -->
		</div>
		<!-- /.inv-projects-blog-headline -->

		<div class="message-info">
			You didn't join to any projects.
		</div>
		<!-- /.message-info -->

		<div class="inv-projects-blog-wrapper">
			<div class="row">
				<?php for ($x = 1; $x <= 1; $x++) { ?>
				<div class="col s4">
					<div class="inv-project">
						<div class="picture" style="background: url(_preview/project-<?php echo $x+1 ?>.jpg) no-repeat center; background-size:cover;">
							
						</div>
						<!-- /.picture -->
						<h3>Ezy Planet</h3>
						<div class="description">
							To provide proper credit, use the embedded credit already in the icon you downloaded or you can copy the line.
						</div>
						<!-- /.description -->
						<div class="tags">
							<div class="tag">
								Startup spotlight 
							</div>
							<!-- /.tag -->
							<div class="tag">
								Transport
							</div>
							<!-- /.tag -->
						</div>
						<!-- /.tags -->
					</div>
					<!-- /.inv-project -->
				</div>
				<?php } ?>
			</div>
		</div>
		<!-- /.inv-projects-blog-wrapper -->


		<div class="inv-projects-blog-headline border-red">
			<h2>PROJECTS THAT YOU HAVE SUBMIT</h2>
			<a class="waves-effect waves-light btn  red darken-1 right" href="#">
				Submit project
			</a>
			<!-- /.button -->
		</div>
		<!-- /.inv-projects-blog-headline -->


		<div class="message-info">
			You didn't submit any projects.
		</div>
		<!-- /.message-info -->


		<div class="inv-projects-blog-wrapper">
			<div class="row">
				<?php for ($x = 4; $x <= 5; $x++) { ?>
				<div class="col s4">
					<div class="inv-project">
						<div class="picture" style="background: url(_preview/<?php echo $x+1 ?>.jpg) no-repeat center; background-size:cover;">
							
						</div>
						<!-- /.picture -->
						<h3>Ezy Planet</h3>
						<div class="description">
							To provide proper credit, use the embedded credit already in the icon you downloaded or you can copy the line.
						</div>
						<!-- /.description -->
						<div class="tags">
							<div class="tag">
								Startup spotlight 
							</div>
							<!-- /.tag -->
							<div class="tag">
								Transport
							</div>
							<!-- /.tag -->
						</div>
						<!-- /.tags -->
					</div>
					<!-- /.inv-project -->
				</div>
				<?php } ?>
			</div>
		</div>
		<!-- /.inv-projects-blog-wrapper -->

		*/?>
	</div>
	<!-- /.container -->
</div>
<!-- /.form-content -->	




<script>
	function editProfile(){
		$('#edit_account').slideToggle(400);
	}
</script>
	