<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Welcome to CliNik</title>
    <link rel="icon" href="../images/CliNik_Logo.png" type="image/png" />
	
</head>
<style>
    @import url('https://fonts.googleapis.com/css?family=Roboto:700&display=swap');
*{
	padding: 0;
	margin: 0;
}
.wrapper{
	background: url(../images/Background.png) no-repeat;
	background-size: cover;
	height: 100vh;
}
.navbar{
	position: fixed;
	height: 80px;
	width: 100%;
	top: 0;
	left: 0;
}
.navbar .logo{
	width: 90px;
	height: auto;
	padding: 20px 100px;
}

.wrapper .center{
	position: absolute;
	left: 50%;
	top: 55%;
	transform: translate(-50%, -50%);
	font-family: sans-serif;
	user-select: none;
}
.center h1{
    color: #000;
	font-size: 70px;
	width: 900px;
	font-weight: bold;
	text-align: center;
}
.center h6{
	color: white;
	font-size: 30px;
	font-weight: bold;
	margin-top: 10px;
	width: 885px;
	text-align: center;
}
.center .buttons{
	margin: 35px 280px;
}
.buttons button{
	height: 50px;
	width: 150px;
	font-size: 18px;
	font-weight: 600;
	color: white;
	background: #dcd405;
	outline: none;
	cursor: pointer;
	border: 1px solid #c6bf05;
	border-radius: 25px;
	transition: .4s;
}
.buttons .btn2{
	margin-left: 25px;
}
.buttons button:hover{
	background: #b0aa04;
}

</style>
<body>
	<div class="wrapper">
		<nav class="navbar">
			<img class="logo" src="../images/CliNik_Logo.png">
		</nav>
		<div class="center">
			<h1>Welcome To CliNik</h1>
			<h6>Healthy and Hip, That's Our Vibe</h2>
			<div class="buttons">
				<a href="login.php"><button>Sign In</button></a>
            	<a href="register.php"><button class="btn2">Sign Up</button></a>
			</div>
		</div>
	</div>

	<div class="footer" style="text-align: center; padding: 20px; bottom: 0; ">
		<p>&copy; <?php echo date("Y"); ?> CliNik. All rights reserved.</p>
	</div>
</body>
</html>