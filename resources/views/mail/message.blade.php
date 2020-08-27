<!DOCTYPE html>
<html lang="en">
<style>
		body{
			background-color: #ecf0f5;
		}

		.container{
			width: 100%;
			margin-top: 100px;
			font-family: arial;
		}
		
		.center-container{
			width: 500px;
			height: 200px;
			margin: 0 auto;
			padding: 20px;
			background-color: #ffffff;
			box-shadow: 0 2px 3px rgba(0, 0, 0, 0.125);
		}
		.header{
			background-color: #1a1a27;
			width: 500px;
			height: 20px;
			margin: 0 auto;
			padding: 20px;
			padding-bottom: 10px;
			box-shadow: 0 2px 3px rgba(0, 0, 0, 0.125);
		}
		
		.header p{
			text-align: center;
			margin: 0;
			padding: 0;
			color: white;
			font-weight: bold;
		}
		
		.col-4{
			width: 20%;
			float: left;
			min-height: 1px;
			padding-left: 0;
			padding-right: 0;
			position: relative;
		}
		
		.col-6{
			width: 80%;
			float: left;
			min-height: 1px;
			padding-left: 0;
			padding-right: 0;
			position: relative;
			text-align: center;
		}
	
		.text{
			margin-top: 70px;
			margin-right: 100px;
			font-size: 20px;
            margin-left:15px;
			color: #777;
			width: 100%;
			text-align: center;
		}
	</style>
	<body>
		<div class="container">
			<div class="header">
				<p>Fleet Registration | FPC</p>
			</div>
			<div class="center-container">
				<div class="col-4">
					<img src="<?php echo $image_url;?>" style="width: 150px;">
				</div>
				<div class="col-6">
					<div class="text"><?php echo $message; ?></div>
				</div>
			</div>
		</div>
	</body>
</html>

