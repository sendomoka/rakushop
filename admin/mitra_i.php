<?php
session_start();
include '../config/connect.php';

if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $country = $_POST['country'];
    $image_mitra = $_FILES['image_mitra']['name'];
    $image_mitra_tmp = $_FILES['image_mitra']['tmp_name'];
    $image_mitra_size = $_FILES['image_mitra']['size'];
    $image_mitra_error = $_FILES['image_mitra']['error'];
    $image_mitra_type = $_FILES['image_mitra']['type'];
    $image_mitra_ext = strtolower(end(explode('.', $image_mitra)));
    $extensions = ['jpg', 'jpeg', 'png'];
    if(in_array($image_mitra_ext, $extensions)){
        if($image_mitra_error === 0){
            $image_mitra_name = uniqid('mitra_', true) . '.' . $image_mitra_ext;
            move_uploaded_file($image_mitra_tmp, '../assets/images/mitras/' . $image_mitra_name);
            $sql = "INSERT INTO mitras (name, country, image) VALUES ('$name', '$country', '$image_mitra_name')";
            $query = mysqli_query($conn, $sql);
            if($query){
                header("Location: mitras.php");
                exit();
            }else{
                echo "<script>alert('Insert failed!')</script>";
            }
        }else{
            echo "<script>alert('Image error!')</script>";
        }
    }else{
        echo "<script>alert('Image type not allowed!')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra Insert | Rakushop Indonesia</title>
    <link rel="shortcut icon" href="../assets/icons/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/admin.css">
    <link rel="stylesheet" href="../css/a_insert.css">
    <script src="https://kit.fontawesome.com/d9b2e6872d.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php include '../components/admin_header.php' ?>
    <main>
        <div class="left">
            <a href="index.php" <?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-tachometer-alt"></i>
                Dashboard
            </a>
            <a href="banners.php">
                <i class="fas fa-image"></i>
                Banners
            </a>
            <a href="games.php">
                <i class="fas fa-gamepad"></i>
                Games
            </a>
            <a href="ewallets.php">
                <i class="fas fa-wallet"></i>
                E-Wallets
            </a>
            <a href="orders.php" <?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-shopping-cart"></i>
                Orders
            </a>
            <?php
            if($_SESSION['role'] == 'owner'){
                echo '<a href="users.php">
                    <i class="fas fa-users"></i>
                    Users
                </a>
                <a href="mitras.php" class="active">
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
            <h2>Mitra Insert</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td><input type="text" name="name" required></td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>:</td>
                        <td><input type="text" name="country" required></td>
                    </tr>
                    <tr>
                        <td>Image Mitra</td>
                        <td>:</td>
                        <td><input type="file" name="image_mitra" accept="image/*" required></td>
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" name="submit" value="Insert"></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
    <?php include '../components/admin_footer.php' ?>
</body>
</html>