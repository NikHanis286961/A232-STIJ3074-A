<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include('dbconnect.php');

$query = "SELECT `service_id`, `service_name`, `service_description`, `service_price` FROM `tbl_services`";
$stmt = $conn->prepare($query);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CliNik - Our Services</title>
    <link rel="icon" href="../images/CliNik_Logo.png" type="image/png" />
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background: url(../images/Background.png) no-repeat;
            background-size: cover; 
            background-attachment: fixed;
            margin: 0; 
        }

        .logo {
            width: 120px;
            padding: 10px 20px;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
        }

        .services-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        .w3-row-padding {
            margin: 0 -16px;
        }

        .w3-half {
            width: 50%;
            padding: 16px;
        }

        .service-card {
            background-color: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: transform 0.3s ease;
        }

        .service-card img {
            width: 100%;
            max-width: 200px;
            height: auto; 
            display: block;
            margin: auto; 
        }

        .service-card:hover {
            transform: translateY(-5px);
        }

        .service-card h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .service-card p {
            font-size: 16px;
            margin-bottom: 15px;
        }

        .view-details-btn {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: block;
            font-size: 16px;
            margin: auto;
            margin-top: 10px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .view-details-btn:hover {
            background-color: #45a049;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .w3-half {
                width: 100%;
            }
        }
        /* Modal Styling */
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.7);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            max-width: 600px;
            border-radius: 10px;
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 30px;
            font-weight: bold;
            color: #aaa;
            cursor: pointer;
        }

    </style>
</head>
<body>

<div class="w3-container w3-grey">    
    <a class="w3-bar-item"><img class="logo" src="../images/CliNik_Logo.png"></a>
</div>

<nav class="w3-bar w3-grey">
    <div class="w3-bar-item w3-right">
        <a href="logout.php" class="w3-button">Logout</a>
    </div>
    <div class="w3-bar-item">
        <a href="index.php" class="w3-button">Home</a>
    </div>
</nav>

<div class="container">
    <h2 class="w3-center">Our Services</h2>
    
    <div class="services-container">
        <div class="w3-row-padding">
            <?php foreach ($services as $service): ?>
            <div class="w3-half w3-container w3-margin-bottom">
                <div class="w3-card-4 service-card" onclick="showServiceDetails(<?php echo $service['service_id']; ?>)">
                    <img src="../images/service_<?php echo $service['service_id']; ?>.png" alt="<?php echo $service['service_name']; ?>" style="width:100%">
                    <div class="w3-container">
                        <h3><?php echo $service['service_name']; ?></h3>
                        <p><?php echo $service['service_description']; ?></p>
                        <p><strong>Price: </strong>RM<?php echo $service['service_price']; ?></p>
                        <button class="view-details-btn">View Details</button>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div id="serviceModal" class="modal">
    <div class="modal-content w3-animate-top">
        <span class="close" onclick="document.getElementById('serviceModal').style.display='none'">&times;</span>
        <header class="w3-container w3-yellow">
            <h2 id="modalServiceName" class="w3-center"></h2>
        </header>
        <div class="w3-container">
            <p id="modalServiceDescription"></p>
            <p id="modalServicePrice"></p>
        </div>
    </div>
</div>

<div class="w3-footer w3-grey" style="text-align: center; padding: 20px; bottom: 0; width: 100%;">
    <p>&copy; <?php echo date("Y"); ?> CliNik. All rights reserved.</p>
</div>

<script>
    function showServiceDetails(serviceId) {
       
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState === 4 && this.status === 200) {
                var serviceDetails = JSON.parse(this.responseText);
                if (serviceDetails.error) {
                   
                    console.error('Error fetching service details:', serviceDetails.error);
                } else {
                    
                    document.getElementById('modalServiceName').innerHTML = serviceDetails.service_name;
                    document.getElementById('modalServiceDescription').innerHTML = serviceDetails.service_description;
                    document.getElementById('modalServicePrice').innerHTML = 'Price: RM' + serviceDetails.service_price;

                   
                    document.getElementById('serviceModal').style.display='block';
                }
            }
        };
        xhr.open('GET', 'fetch_service.php?serviceId=' + encodeURIComponent(serviceId), true);
        xhr.send();
    }
</script>

</body>
</html>
