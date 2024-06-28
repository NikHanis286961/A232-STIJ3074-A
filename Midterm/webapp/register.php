<?php
include 'dbconnect.php';

$emailErr = $nameErr = $usernameErr = $passwordErr = $cpasswordErr = $telNoErr = $addressErr = "";
$successMessage = $errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = sha1($_POST['psw']); 
    $cpassword = sha1($_POST['psw-confirm']); 
    $tel_no = $_POST['tel_no'];
    $address = $_POST['address'];

    if (empty($_POST['psw-confirm'])) {
        $cpasswordErr = "Confirmed password is required";
    } elseif ($_POST['psw'] !== $_POST['psw-confirm']) {
        $cpasswordErr = "Passwords do not match";
    }

    if (empty($emailErr) && empty($nameErr) && empty($usernameErr) && empty($passwordErr) && empty($cpasswordErr) && empty($telNoErr) && empty($addressErr)) {
        try {
            
            $stmt = $conn->prepare("SELECT * FROM user_tbl WHERE user_email = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                
                $emailErr = "Email already exists.";
            } else {
                
                $stmt = $conn->prepare("SELECT * FROM user_tbl WHERE user_username = :username");
                $stmt->bindParam(':username', $username);
                $stmt->execute();

                if ($stmt->rowCount() > 0) {
                   
                    $usernameErr = "Username already exists.";
            } else {
                
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
            
            $emailErr = "Error: " . $e->getMessage();
            $usernameErr = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>CliNik - Sign Up</title>
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="icon" href="../images/CliNik_Logo.png" type="image/png" />
<style>
body {
  background: url(../images/Background.png) no-repeat;
  background-size: cover;
  background-attachment: fixed;
  margin: 0;
}

.navbar {
  position: fixed;
  width: 100%;
  z-index: 1000;
}

.logo {
  margin-left: 10px;
}

.container {
  max-width: 500px;
  margin-left: auto;
  margin-right: auto;
}

input[type=text], input[type=email], input[type=password], textarea {
  width: 100%;
  padding: 12px;
  margin: 8px 0;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

button.registerbtn {
  width: 100%;
  background-color: #dcd405;
  color: black;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

button.registerbtn:hover {
  opacity: 0.8;
}

span.error {
  color: red;
}

@media screen and (max-width: 600px) {
  .container {
    padding: 20px;
  }
}
</style>
</head>
<body>

<nav class="w3-bar">
  <a href="welcome.php" class="w3-bar-item"><img src="../images/CliNik_Logo.png" class="w3-image" style="width:90px"></a>
</nav>

<div class="w3-container container">
  <h2 class="w3-center">Register Form</h2>

  <?php if (!empty($errorMessage)): ?>
    <div class="w3-panel w3-red w3-padding"><?php echo $errorMessage; ?></div>
  <?php endif; ?>

  <?php if (!empty($successMessage)): ?>
    <div class="w3-panel w3-green w3-padding"><?php echo $successMessage; ?></div>
  <?php endif; ?>

  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">

    <label for="email"><b>Email</b></label>
    <input type="email" placeholder="Enter Email" name="email" id="email" required>
    <span class="error"><?php echo $emailErr;?></span><br>

    <label for="name"><b>Name</b></label>
    <input type="text" placeholder="Enter Name" name="name" id="name" required>
    <span class="error"><?php echo $nameErr;?></span><br>

    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" id="username" required>
    <span class="error"><?php echo $usernameErr;?></span><br>

    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
    <span class="error"><?php echo $passwordErr;?></span><br>

    <label for="psw-confirm"><b>Confirm Password</b></label>
    <input type="password" placeholder="Enter Confirm Password" name="psw-confirm" id="psw-confirm" required>
    <span class="error"><?php echo $cpasswordErr;?></span><br>

    <label for="tel_no"><b>Phone Number</b></label>
    <input type="text" placeholder="Enter Phone Number" name="tel_no" id="tel_no" required>
    <span class="error"><?php echo $telNoErr;?></span><br>

    <label for="address"><b>Address</b></label>
    <textarea placeholder="Enter Address" name="address" id="address" required></textarea>
    <span class="error"><?php echo $addressErr;?></span><br>

    <button type="submit" class="w3-button w3-block w3-yellow registerbtn">Register</button>

    <div class="w3-center w3-margin-top">
      <p>Already have an account? <a href="./login.php">Sign in</a>.</p>
    </div>
  </form>
</div>

<div class="w3-footer w3-grey" style="text-align: center; padding: 20px; width: 100%;">
		<p>&copy; <?php echo date("Y"); ?> CliNik. All rights reserved.</p>
	</div>

</body>
</html>