<?php
session_start();
include '../config/connect.php';

if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Rakushop Indonesia</title>
    <link rel="shortcut icon" href="../assets/icons/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/a_dashboard.css">
    <script src="https://kit.fontawesome.com/d9b2e6872d.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <?php include '../components/admin_header.php' ?>
    <main>
        <div class="left">
            <a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="banners.php" <?= basename($_SERVER['PHP_SELF']) == 'banners.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-image"></i>
                Banners
            </a>
            <a href="games.php" <?= basename($_SERVER['PHP_SELF']) == 'games.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-gamepad"></i>
                Games
            </a>
            <a href="ewallets.php" <?= basename($_SERVER['PHP_SELF']) == 'ewallets.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-wallet"></i>
                E-Wallets
            </a>
            <a href="orders.php" <?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-shopping-cart"></i>
                Orders
            </a>
            <?php
            if($_SESSION['role'] == 'owner'){
                echo '<a href="users.php" '.(basename($_SERVER['PHP_SELF']) == 'users.php' ? 'class="active"' : '').'>
                    <i class="fas fa-users"></i>
                    Users
                </a>
                <a href="mitras.php" '.(basename($_SERVER['PHP_SELF']) == 'mitras.php' ? 'class="active"' : '').'>
                    <i class="fas fa-handshake"></i>
                    Mitras
                </a>';
            }
            ?>
            <a href="logout.php">
                <i class="fas fa-sign-out-alt"></i>
                Logout
            </a>
        </div>
        <div class="right">
            <h2>Dashboard</h2>
            <div class="cards">
                <div class="card">
                    <h3>Users</h3>
                    <h1><?= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM users")) ?></h1>
                </div>
                <div class="card">
                    <h3>Games</h3>
                    <h1><?= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM games")) ?></h1>
                </div>
                <div class="card">
                    <h3>Orders</h3>
                    <h1><?= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM orders")) ?></h1>
                </div>
                <div class="card">
                    <h3>E-Wallets</h3>
                    <h1><?= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM ewallets")) ?></h1>
                </div>
            </div>
            <div class="canvas-box">
                <div class="canvas">
                    <canvas id="myChart" height="200"></canvas>
                </div>
                <div class="canvas">
                    <canvas id="myChart2"></canvas>
                </div>
            </div>
        </div>
    </main>
    <?php include '../components/admin_footer.php' ?>
</body>
<script>
	var ctx = document.getElementById("myChart").getContext('2d');
	var myChart = new Chart(ctx, {
		type: 'line',
		data: {
			labels: ["January", "February", "March", "April", "May", "June", "July", "August","September","October","November","December"],
			datasets: [
                <?php
                    for ($year = 2022; $year <= 2023; $year++) {
                        $lineColor = ($year == 2022) ? "#547AFF" : "#FFF383";
                        echo "{ 
                                label: '$year',
                                data: [";
                        for ($month = 1; $month <= 12; $month++) {
                            $start_date = "$year-$month-01";
                            $end_date = date("Y-m-t", strtotime($start_date));
                            $query = mysqli_query($conn, "SELECT * FROM transactions WHERE created_at BETWEEN '$start_date' AND '$end_date'");
                            echo mysqli_num_rows($query) . ",";
                        }
                        echo "],
                                borderColor: '$lineColor',
                                borderWidth: 1
                            },";
                    }
                ?>
            ]
		},
		options: {
			scales: {
                x: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.2)'
                    },
                    ticks: {
                        color: 'white'
                    }
                },
                y: {
                    grid: {
                        color: 'rgba(255, 255, 255, 0.2)'
                    },
                    ticks: {
                        color: 'white'
                    }
                },
				yAxes: [{
					ticks: {
						beginAtZero:true
					}
				}]
			},
            plugins: {
                title: {
                    display: true,
                    text: 'Total Transactions',
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: 'white'
                }
            }
		}
	});

    var ctx2 = document.getElementById("myChart2").getContext('2d');
    var myChart2 = new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ["Pending", "Success", "Failed"],
            datasets: [{
                data: [
                    <?= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transactions WHERE status='pending'")) ?>,
                    <?= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transactions WHERE status='success'")) ?>,
                    <?= mysqli_num_rows(mysqli_query($conn, "SELECT * FROM transactions WHERE status='failed'")) ?>
                ],
                backgroundColor: ['#FFA500', '#008000', '#FF0000'],
                borderColor: 'rgba(255, 255, 255, 0.2)',
                borderWidth: 1
            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: 'Transaction Status',
                    font: {
                        size: 16,
                        weight: 'bold',
                    },
                    color: 'white'
                }
            }
        }
    });
</script>
</html>