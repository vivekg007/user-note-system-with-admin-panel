<?php
	require_once 'assets/php/header.php';
?>
    
    <div class="container">
    	<div class="row justify-content-center my-2">
    		<div class="col-lg-6 mt-4" id="showAllNotification">
    			
    		</div>
    	</div>
    </div>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.0/jquery.min.js"></script>

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){


			//Fetch Norification of an User
			fetchNotification();
			function fetchNotification(){
				$.ajax({
					url: 'assets/php/process.php',
					method: 'post',
					data: { action: 'fetchNotification' },
					success:function(response){
						$("#showAllNotification").html(response);
					}

				});
			}

			//Check Notification 
			checkNotification();
			function checkNotification(){
				$.ajax({
					url: 'assets/php/process.php',
					method: 'post',
					data: { action: 'checkNotification' },
					success:function(response){
						$("#checkNotification").html(response);
					}
				});
			}

			//Remove Notification
			$("body").on("click", ".close", function(e){
				e.preventDefault();

				notification_id = $(this).attr('id');

				$.ajax({
					url: 'assets/php/process.php',
					method: 'post',
					data: { notification_id: notification_id },
					success:function(response){
						checkNotification();
						fetchNotification();
					}
				});
			});
		});
	</script>
</body>
</html>

