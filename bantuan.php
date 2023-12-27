<?php
session_start();
include 'config/connect.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bantuan | Rakushop Indonesia</title>
    <link rel="shortcut icon" href="assets/icons/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/bantuan.css">
    <script src="https://kit.fontawesome.com/d9b2e6872d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'components/header.php' ?>
    <main>
        <h1>Bantuan</h1>
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Pertanyaan</th>
                    <th>Jawaban</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $sql = "SELECT * FROM faq";
                    $query = mysqli_query($conn, $sql);
                    $counter = 1;
                    while($row = mysqli_fetch_array($query)){
                        echo "<tr>
                                <td>$counter.</td>
                                <td>$row[question]</td>
                                <td>$row[answer]</td>
                            </tr>";
                        $counter++;
                    }
                ?>
            </tbody>
        </table>
    </main>
    <?php include 'components/footer.php' ?>
</body>
<script>
let currentBanner = 1;
const banners = document.querySelectorAll('.banner-box img');
const dots = document.querySelectorAll('.banner-dot .dot');

function changeBanner(index) {
    banners.forEach(banner => banner.style.display = 'none');
    banners[index - 1].style.display = 'block';
    dots.forEach(dot => dot.classList.remove('active'));
    dots[index - 1].classList.add('active');
    currentBanner = index;
}

function autoChangeBanner() {
    if (currentBanner == banners.length) {
        currentBanner = 1;
    } else {
        currentBanner++;
    }
    changeBanner(currentBanner);
}

setInterval(autoChangeBanner, 10000);
</script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="search.js"></script>
</html>