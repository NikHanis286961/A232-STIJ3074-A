<?php
include 'dbconnect.php';

$emailErr = $nameErr = $usernameErr = $passwordErr = $cpasswordErr = $telNoErr = $addressErr = "";
$successMessage = $errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = sha1($_POST['psw']); // Hash the password using SHA1
    $cpassword = sha1($_POST['psw-confirm']); // Hash the confirmed password using SHA1
    $tel_no = $_POST['tel_no'];
    $address = $_POST['address'];

    if (empty($_POST['psw-confirm'])) {
        $cpasswordErr = "Confirmed password is required";
    } elseif ($_POST['psw'] !== $_POST['psw-confirm']) {
        $cpasswordErr = "Passwords do not match";
    }

    if (empty($emailErr) && empty($nameErr) && empty($usernameErr) && empty($passwordErr) && empty($cpasswordErr) && empty($telNoErr) && empty($addressErr)) {
        try {
            // Check if the email already exists
            $stmt = $conn->prepare("SELECT * FROM user_tbl WHERE user_email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // Email already exists
                $emailErr = "Email already exists.";
            } else {
                // Check if the username already exists
                $stmt = $conn->prepare("SELECT * FROM user_tbl WHERE user_username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                    // Username already exists
                    $usernameErr = "Username already exists.";
            } else {
                // Email does not exist, proceed with insertion
                $stmt = $conn->prepare("INSERT INTO user_tbl (user_email, user_name, user_username, user_password, user_Cpassword, user_tel, user_address) VALUES (:email, :name, :username, :password, :cpassword, :tel_no, :address)");
                $stmt->bindParam(':email', $email);
                $stmt->bindParam(':name', $name);
                $stmt->bindParam(':username', $username);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':cpassword', $cpassword);
                $stmt->bindParam(':tel_no', $tel_no);
                $stmt->bindParam(':address', $address);
                $stmt->execute();

                $successMessage = "Registration successful!";
            }
          }
        } catch (PDOException $e) {
            // Handle PDO exceptions
            $emailErr = "Error: " . $e->getMessage();
            $usernameErr = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>CliNik - Sign Up</title>
<link rel="icon" href="../images/CliNik_Logo.png" type="image/png" />
<style>
body {
  font-family: Arial, Helvetica, sans-serif;
  margin: 0;
  min-height: 100vh;
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
  max-width: 500px;
  background-color: white;
  padding: 16px;
  border-radius: 8px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
  position: relative;
  margin: 40px auto;
}

input[type=text], input[type=email], input[type=password], textarea {
  font-family: Arial, Helvetica, sans-serif;
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}

textarea {
  height: 100px; /* Increased height for address input */
}

button.registerbtn {
  background-color: #dcd405;
  color: black;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  cursor: pointer;
  width: 100%;
}

button.registerbtn:hover {
  opacity: 0.8;
}

.flex-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

span.error {
  color: red;
}

.signin {
  text-align: center;
}

.error {
  color: red;
}

.success {
  color: green;
}

.signin a {
  color: dodgerblue;
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

</head>
<body>

<nav class="navbar">
  <a href="welcome.php"><img class="logo" src="../images/CliNik_Logo.png"></a>
</nav>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

  <div class="container">
  <h2 style="text-align: center">Register Form </h2>

  <?php if (!empty($errorMessage)): ?>
    <div class="error"><?php echo $errorMessage; ?></div>
  <?php endif; ?>

  <?php if (!empty($successMessage)): ?>
    <div class="success"><?php echo $successMessage; ?></div>
  <?php endif; ?>
  <hr>
<br></br>
    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Enter Email" name="email" id="email" required>
    <span class="error"><?php echo $emailErr;?></span>
<br></br>
    <label for="name"><b>Name</b></label>
    <input type="text" placeholder="Enter Name" name="name" id="name" required>
    <span class="error"><?php echo $nameErr;?></span>
<br></br>
    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" id="username" required>
    <span class="error"><?php echo $usernameErr;?></span>
<br></br>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
    <span class="error"><?php echo $passwordErr;?></span>
<br></br>
    <label for="psw-confirm"><b>Confirmed Password</b></label>
    <input type="password" placeholder="Enter Confirm Password" name="psw-confirm" id="psw-confirm" required>
    <span class="error"><?php echo $cpasswordErr;?></span>
<br></br>
    <label for="tel_no"><b>Phone Number</b></label>
    <input type="text" placeholder="Enter Phone Number" name="tel_no" id="tel_no" required>
    <span class="error"><?php echo $telNoErr;?></span>
<br></br>
    <label for="address"><b>Address</b></label>
    <textarea placeholder="Enter Address" name="address" id="address" required></textarea>
    <span class="error"><?php echo $addressErr;?></span>

    <hr>

    <button type="submit" class="registerbtn" >Register</button>
    
    <div class="signin">
      <p>Already have an account? <a href="./login.php">Sign in</a>.</p>
    </div>
  </div>
</form>

</body>
</html>