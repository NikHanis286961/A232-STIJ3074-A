<?php
session_start();
session_unset();
session_destroy();
echo "<p style='color: green;'>Logout successful! Redirecting to the welcome page...</p>";
header("refresh:2;url=welcome.php");
exit();
?>

