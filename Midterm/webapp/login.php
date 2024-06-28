<?php
include 'dbconnect.php';

session_start();

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['name'];
    $password = sha1($_POST['psw']); 

    try {
        $stmt = $conn->prepare("SELECT * FROM user_tbl WHERE user_username = :username AND user_password = :password");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $_SESSION['username'] = $user['user_username'];
            $_SESSION['name'] = $user['user_name'];
            echo "<p style='color: green;'>Login successful! Redirecting to the home page...</p>";
            header("refresh:2;url=index.php");
            exit();
        } else {
            
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
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="icon" href="../images/CliNik_Logo.png" type="image/png" />
<style>
body {
  background: url(../images/Background.png) no-repeat;
  background-size: cover;
  background-attachment: fixed;
  margin: 0;
}

.logo {
  margin-left: 10px; 
}

.container {
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}

input[type=text], input[type=password], button[type=submit] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  box-sizing: border-box;
  border-radius: 4px;
}

button {
  width: 100%;
  background-color: #dcd405;
  color: black;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
}

button:hover {
  opacity: 0.8;
}

.flex-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.error {
  color: red;
}

.signup {
  text-align: center;
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
<nav class="w3-bar">
  <a href="welcome.php" class="w3-bar-item"><img src="../images/CliNik_Logo.png" class="w3-image" style="width:90px"></a>
</nav>

<form name="loginForm" action="login.php" method="post">
<div class="w3-container container">
  <h2 class="w3-center">Login Form</h2>
    <?php if (!empty($errorMessage)): ?>
      <div class="error w3-panel w3-red w3-padding"><?php echo $errorMessage; ?></div>
    <?php endif; ?>
    
    <label for="name"><b>Username</b></label>
    <input class="w3-input" type="text" placeholder="Enter Username" name="name" id="idemail" required>

    <label for="psw"><b>Password</b></label>
    <input class="w3-input" type="password" placeholder="Enter Password" name="psw" id="idpass" required>
    <button type="submit" class="w3-button w3-yellow">Login</button>

    <div class="flex-container">
      <label>
        <input class="w3-check" type="checkbox" checked="checked" name="remember" id="idremember" onclick="rememberMe()">
        <span>Remember me</span>
      </label>
    </div>
  </div>

  <div class="w3-container">
    <p class="w3-center">Don't have an account? <a href="./register.php">Register</a>.</p>
  </div>

</form>

<div class="w3-footer w3-grey" style="text-align: center; padding: 20px; width: 100%;">
		<p>&copy; <?php echo date("Y"); ?> CliNik. All rights reserved.</p>
	</div>

</body>
</html>
