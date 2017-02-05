<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge"> 
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>Smart Containers</title>

		<meta name="author" content="Zenin Easa" />

		<link rel="stylesheet" type="text/css" href="css/normalize.css" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />

		<script src="js/jquery.min.js"></script>
		<script>
		jQuery(window).load(function() {
			jQuery("#preloader").delay(1000).fadeOut("slow");
		})
		</script>
	</head>

	<body>

		<div class="slide first">
			<h1>Smart Containers</h1>
		</div>
		<div class="second slide">

			<div class="link">
				<?php

				include 'database.php';

				$con=mysqli_connect($host,$user,$pass,$database);
				if (mysqli_connect_errno())
				  {
				  echo "Failed to connect to MySQL: " . mysqli_connect_error();
				  }

				$sql="SHOW TABLES FROM `$database`";
				$result=mysqli_query($con,$sql);

				while ($row=mysqli_fetch_array($result,MYSQLI_NUM)) {
					$cont = $row[0];
					$query = "SELECT * FROM `$cont` ORDER BY timestamp DESC LIMIT 1";
					$res = mysqli_query($con,$query);
					$r=mysqli_fetch_array($res,MYSQLI_NUM);
				?>
					<a onclick="loadsection('<?php echo $cont; ?>')"><div class="button"><?php echo $cont." - ".$r[1]; ?></div></a>
					<div id="<?php echo $cont.'-load'; ?>" style="display:none"></div>

				<?php
				}

				mysqli_free_result($result);
				mysqli_close($con);
				?>
				
				<a onclick="addsection('<?php echo ++$cont; ?>')"><div class="button" style="background:rgba(0,0,0,0.8)">Add Container</div></a>
				<div id="<?php echo $cont.'-load'; ?>" style="display:none"></div>

			</div>


		</div>

		<div id="preloader">
			<ul class="loader">
				<li>
					<div class="circle"></div>
					<div class="ball"></div>
				</li>
				<li>
					<div class="circle"></div>
					<div class="ball"></div>
				</li>
				<li>
					<div class="circle"></div>
					<div class="ball"></div>
				</li>
				<li>
					<div class="circle"></div>
					<div class="ball"></div>
				</li>
				<li>
					<div class="circle"></div>
					<div class="ball"></div>
				</li>
			</ul>
		</div>

		<div id="load"></div>
		<script>
		function loadsection(cont){
			if($("#"+cont+"-load").is(':visible')){
				$("#"+cont+"-load").hide();      
			}
			else{
				$("#"+cont+"-load").hide().load("loadsection.php?cont="+cont).fadeIn('500');
			}
		}
		function addsection(cont){
			if($("#"+cont+"-load").is(':visible')){
				$("#"+cont+"-load").hide();      
			}
			else{
				$("#"+cont+"-load").hide().load("edit.php?cont="+cont).fadeIn('500');
			}
		}
		</script>

	</body>
</html>
