<?php
session_start();
include 'config/connect.php';

if(isset($_GET['id'])){
    $game_id = $_GET['id'];
    $sqlg = "SELECT * FROM games WHERE id = $game_id";
    $result = mysqli_query($conn, $sqlg);
    if(mysqli_num_rows($result) > 0){
        $row = mysqli_fetch_assoc($result);
        $game_name = $row['name'];
        $game_credit_name = $row['credit_name'];
        $game_image = $row['image'];
    } else {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $game_name ?> | Rakushop Indonesia</title>
    <link rel="shortcut icon" href="assets/icons/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/index.css">
    <script src="https://kit.fontawesome.com/d9b2e6872d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include 'components/header.php' ?>
    <main>
        <h1><?= $game_name ?></h1>
        <small><?= $game_credit_name ?></small>
        <img src="assets/images/games/<?= $game_image ?>" alt="<?= $game_name ?>">
    </main>
    <?php include 'components/footer.php' ?>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="search.js"></script>
</html>