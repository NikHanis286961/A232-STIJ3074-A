<?php
include 'dbconnect.php';

session_start();

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name'];
    $password = sha1($_POST['psw']); // Hash the password using SHA1

    try {
        $stmt = $conn->prepare("SELECT * FROM user_tbl WHERE user_username = :username AND user_password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            // Login successful
            $_SESSION['username'] = $username;
            echo "<p style='color: green;'>Login successful! Redirecting to the home page...</p>";
            header("refresh:2;url=index.php");
            exit();
        } else {
            // Login failed
            $errorMessage = "Invalid username or password.";
        }
    } catch (PDOException $e) {
        $errorMessage = "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CliNik - Sign In</title>
<link rel="icon" href="../images/CliNik_Logo.png" type="image/png" />
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
  background: url(../images/Background.png) no-repeat;
	background-size: cover; /* Cover the entire page */
	background-attachment: fixed;
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

.container {
  width: 100%;
  max-width: 400px;
  background-color: white;
  padding: 16px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  position: relative;
  z-index: 1;
}

input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

button {
  background-color: #dcd405;
  color: black;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button:hover {
  opacity: 0.8;
}

.flex-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

span.psw {
  padding-top: 16px;
}

.error {
  color: red;
}

.signup {
  text-align: center;
}

@media screen and (max-width: 300px) {
  .flex-container {
    flex-direction: column;
  }
  span.psw, label {
    float: none;
    width: 100%;
    text-align: center;
    padding-top: 0;
  }
  .cancelbtn {
    width: 100%;
  }
}
</style>

<script>
function setCookies(cname, cvalue, exdays) {
    const d = new Date();
    d.setTime(d.getTime() + (exdays*24*60*60*1000));
    let expires = "expires=" + d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for(let i = 0; i <ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function rememberMe() {
    let email = document.forms["loginForm"]["name"].value;
    let pass = document.forms["loginForm"]["psw"].value;
    let rememberme = document.forms["loginForm"]["remember"].checked;
    if (rememberme && email != "" && pass != "") {
        setCookies("cemail", email, 5);
        setCookies("cpass", pass, 5);
        setCookies("cremember", rememberme, 5);
        console.log("COOKIES:" + email, pass, rememberme);
        alert("Credential Stored");
    } else {
        setCookies("cemail", "", 5);
        setCookies("cpass", "", 5);
        setCookies("cremember", rememberme, 5);
        document.forms["loginForm"]["name"].value = "";
        document.forms["loginForm"]["psw"].value = "";
        document.forms["loginForm"]["remember"].checked = false;
        console.log("COOKIES:" + email, pass, rememberme);
        if (email == "" && pass == "") {
            alert("Please fill in email and password");
        } else {
            alert("Credential Removed");
        }
    }
}

function clearErrorMessage() {
    setTimeout(function() {
        let errorDiv = document.querySelector('.error');
        if (errorDiv) {
            errorDiv.style.display = 'none';
        }
    }, 5000); 
}

window.onload = function() {
    clearErrorMessage();
    let email = getCookie("cemail");
    let pass = getCookie("cpass");
    let rememberme = getCookie("cremember") === "true";
    document.forms["loginForm"]["remember"].checked = false;
    if (email != "" && pass != "") {
        document.forms["loginForm"]["name"].value = email;
        document.forms["loginForm"]["psw"].value = pass;
        document.forms["loginForm"]["remember"].checked = rememberme;
    }
};


</script>
</head>
<body>

<nav class="navbar">
  <a href="welcome.php"><img class="logo" src="../images/CliNik_Logo.png"></a>
</nav>

<form name="loginForm" action="login.php" method="post">
  <div class="container">
    <h2 style="text-align: center">Login Form</h2>
    <?php if (!empty($errorMessage)): ?>
      <div class="error"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    <hr>
    <label for="name"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="name" id="idemail" required>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="idpass" required>
    <hr>

    <button type="submit">Login</button>

    <div class="flex-container">
      <label>
        <input type="checkbox" checked="checked" name="remember" id="idremember" onclick="rememberMe()"> Remember me
      </label>
    </div>
  </div>

  <div>
    <p>Don't have an account? <a href="./register.php">Register</a>.</p>
  </div>
</form>


</body>
</html>