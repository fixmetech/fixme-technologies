<?php

use app\core\Application;
use app\models\CusTechReq;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Customer Dashboard</title>
    <link rel="stylesheet" href="/css/customer/customer-dashboard.css">
    <link rel="stylesheet" href="/css/customer/overlay.css">
</head>

<body>
<?php
include_once 'components/sidebar.php';
include_once 'components/header.php';
?>
<!-- ======================= Cards ================== -->
<div class="cardBox">
    <div class="card">
        <div>
            <div class="numbers">65</div>
            <div class="cardName">Total Repairs</div>
        </div>

        <div class="iconBx">
            <ion-icon name="cog-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers">2</div>
            <div class="cardName">Level</div>
        </div>

        <div class="iconBx">
            <ion-icon name="trophy-outline"></ion-icon>

        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers">20</div>
            <div class="cardName">Total Reviews</div>
        </div>

        <div class="iconBx">
            <ion-icon name="star-outline"></ion-icon>
        </div>
    </div>

    <div class="card">
        <div>
            <div class="numbers">Rs. 7,842</div>
            <div class="cardName">Payments</div>
        </div>

        <div class="iconBx">
            <ion-icon name="cash-outline"></ion-icon>
        </div>
    </div>
</div>

<!-- ================ Request Details List ================= -->
<div class="details">
    <div class="recentRequests">
        <div class="cardHeader">
            <h2>Recent Requests</h2>
            <a href="#" class="btn">View All</a>
        </div>

        <table>
            <thead>
            <tr>
                <td>Name</td>
                <td>Price</td>
                <td>Payment</td>
                <td>Status</td>
            </tr>
            </thead>

            <tbody>
            <?php
            $ctr = new CusTechReq();
            $requests = $ctr->getAllRequests(Application::$app->session->get('customer'));
            foreach ($requests as $request) {
                echo
                    '<tr>
                    <td>' . $request['fname'] . ' ' . $request['lname'] . '</td> 
                    <td>Rs. 500</td> 
                    <td>Due</td>
                    <td><span class="status ' . $request['status'] . '">' . $request['status'] . '</span></td>
                </tr>';
            }
            /* status: pending , in Progress, rejected, completed */
            ?>
            </tbody>
        </table>
    </div>

    <!-- ================= Recent Technicians ================ -->
    <div class="recentTechnicians">
        <div class="cardHeader">
            <h2>Recent Technicians</h2>
        </div>

        <table>
            <?php
            $ctr = new CusTechReq();
            $recentTechnicians = $ctr->getRecentTechnicians(Application::$app->session->get('customer'));
            foreach ($recentTechnicians as $recentTechnician) {
                echo
                    '
                        <tr>
                            <td>
                                <div class="imgBx"><img src="' . $recentTechnician['profile_picture'] . '" alt="Technician profile-pic"></div>
                            </td>
                            <td>
                                <h4>' . $recentTechnician['fname'] . ' ' . $recentTechnician['lname'] . '  <br> <span>Technician</span></h4>
                            </td>
                        </tr>
                    ';
            }
            ?>

        </table>
    </div>
</div>

<!-- Overlay for the confirmation message -->
<div id="signOutOverlay" class="overlay">
    <div class="overlay-content">
        <p>Are you sure you want to sign out?</p>
        <button id="confirmSignOut" class="btn"><a href="/customer-logout"></a> Yes</button>
        <button id="cancelSignOut" class="btn">No</button>
    </div>
</div>
<!--    Icons-->
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="/js/customer/customer-home.js"></script>
<script src="/js/customer/overlay.js"></script>
</body>

</html>