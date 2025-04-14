<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Admin Dashboard</title>
        <link rel="stylesheet" href="/css/admin/admin-dashboard.css">
        <link rel="preconnect" href="https://fonts.googleapis.com" />
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
        <link
         href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;700&display=swap"
        rel="stylesheet"
    />
        <link rel="stylesheet" href="/css/admin/chart.css" />
    </head>
    <body>
    <?php
    include_once 'components/sidebar.php';
    include_once 'components/header.php';
    ?>
    <!-- JavaScript Files -->
    <script src="/js/admin/main.js"></script>
        <!-- ======================= Cards ================== -->
        <div class="cardBox">
            <div class="card">
            <div class="programming-stats">
            <div class="chart-container">
                <canvas class="my-chart"></canvas>
            </div>

            <div class="details">
                <ul></ul>
            </div> 
            </div>
            </div>

            <!-- <div class="card">
                <div>
                    <div class="numbers">
                    <?= htmlspecialchars($technicianCount, ENT_QUOTES, 'UTF-8'); ?> 
                    </div>
                    <div class="cardName">Total Technicians</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="pencil-outline"></ion-icon>
                </div>
            </div> -->



            <div class="card">
                <div>
                    <div class="numbers">Rs. 7,842</div>
                    <div class="cardName">Earning</div>
                </div>

                <div class="iconBx">
                    <ion-icon name="cash-outline"></ion-icon>
                </div>
            </div>
        </div>

        <!-- <div class="MainChart">

                <div class="Chart">
                    <h1>Earnings(Past 12 Months)</h1>
                    <div>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>

                <div class="Chart doughnut-chart">
                    <h1>Employees</h1>
                    <div>
                        <canvas id="doughnut"></canvas>
                    </div>
                </div>


            </div> -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script src="/js/admin/main.js"></script>
        <script src="/js/admin/chart.js"></script>
        <script >
            // For Doughnut-chart
        var ctx2 = document.getElementById("doughnut").getContext("2d");
        // Pass PHP counts to JavaScript
        var technicianCount = <?= json_encode($technicianCount); ?>;
        var customerCount = <?= json_encode($customerCount); ?>;
        var serviceCentreCount = <?= json_encode($serviceCentreCount); ?>;

        // Get the canvas element
        var ctx2 = document.getElementById("doughnut").getContext("2d");

        // Create Doughnut Chart
        var myChart2 = new Chart(ctx2, {
            type: "doughnut",
            data: {
                labels: ["Customers", "Technicians", "Service Centers"],
                datasets: [
                    {
                        label: "Entities",
                        data: [customerCount, technicianCount, serviceCentreCount],
                        backgroundColor: [
                            "#f30707",
                            "rgb(19, 0, 230)",
                            "rgb(252, 183, 9)"
                        ],
                        borderColor: [
                            "#f30707",
                            "rgb(19, 0, 230)",
                            "rgb(252, 183, 9)"
                        ],
                        borderWidth: 1,
                    },
                ],
            },
            options: {
                responsive: true,
            },
        });
    </script>

        </div>
                
    <!--    Icons-->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
    </body>
</html>