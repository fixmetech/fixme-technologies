<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="/css/admin/admin-dashboard.css">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap" rel="stylesheet" />
        <link rel="stylesheet" href="/css/admin/chart.css" />
    </head>
    <body>
    <?php
    include_once 'components/sidebar.php';
    include_once 'components/header.php';
    ?>

    <div class="container">
        <!-- ======================= Cards ================== -->
        <div class="cardBox">
            <div class="card">
                <div>
                    <div class="numbers"><?= htmlspecialchars($technicianCount, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="cardName">Total Technicians</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="construct-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?= htmlspecialchars($customerCount, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="cardName">Total Customers</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="people-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers"><?= htmlspecialchars($serviceCentreCount, ENT_QUOTES, 'UTF-8'); ?></div>
                    <div class="cardName">Service Centers</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="business-outline"></ion-icon>
                </div>
            </div>

            <div class="card">
                <div>
                    <div class="numbers">Rs. 7,842</div>
                    <div class="cardName">Earnings</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="cash-outline"></ion-icon>
                </div>
            </div>
        </div>

        <!-- ======================= Quick Actions ================== -->
        <div class="quickActions">
            <h2>Quick Actions</h2>
            <div class="actions">
                <a href="/admin/add-technician" class="action-btn">Add Technician</a>
                <a href="/admin/add-customer" class="action-btn">Add Customer</a>
                <a href="/admin/add-service-center" class="action-btn">Add Service Center</a>
                <a href="/admin/view-reports" class="action-btn">View Reports</a>
            </div>
        </div>

        <!-- ======================= Recent Activities ================== -->
        <div class="recentActivities">
            <h2>Recent Activities</h2>
            <ul>
                <li>Technician John Doe added on <?= date('Y-m-d'); ?></li>
                <li>Customer Jane Smith registered on <?= date('Y-m-d'); ?></li>
                <li>Service Center "FixIt Hub" updated on <?= date('Y-m-d'); ?></li>
                <li>Earnings report generated for March 2025.</li>
            </ul>
        </div>

        <!-- ======================= Charts ================== -->
        <div class="charts">
            <div class="chart">
                <h2>Earnings (Past 12 Months)</h2>
                <canvas id="lineChart"></canvas>
            </div>
            <div class="chart">
                <h2>Entities Overview</h2>
                <canvas id="doughnut"></canvas>
            </div>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="/js/admin/main.js"></script>
    <script src="/js/admin/chart.js"></script>
    <script>
        // Doughnut Chart
        var ctx2 = document.getElementById("doughnut").getContext("2d");
        var technicianCount = <?= json_encode($technicianCount); ?>;
        var customerCount = <?= json_encode($customerCount); ?>;
        var serviceCentreCount = <?= json_encode($serviceCentreCount); ?>;

        var myChart2 = new Chart(ctx2, {
            type: "doughnut",
            data: {
                labels: ["Customers", "Technicians", "Service Centers"],
                datasets: [
                    {
                        label: "Entities",
                        data: [customerCount, technicianCount, serviceCentreCount],
                        backgroundColor: ["#f30707", "rgb(19, 0, 230)", "rgb(252, 183, 9)"],
                        borderColor: ["#f30707", "rgb(19, 0, 230)", "rgb(252, 183, 9)"],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
            },
        });
    </script>

    <!-- Icons -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </body>
</html>