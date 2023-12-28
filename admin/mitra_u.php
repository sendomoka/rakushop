<?php
session_start();
include '../config/connect.php';

if(!isset($_SESSION['email'])){
    header("Location: ../login.php");
    exit();
}

if(isset($_POST['submit'])){
    $id = $_POST['id'];
    $name = $_POST['name'];
    $country = $_POST['country'];
    $image_mitra_updated = !empty($_FILES['image']['name']);
    $image_mitra_name = $image_mitra_updated ? uniqid('mitra_', true) . '.' . strtolower(end(explode('.', $_FILES['image']['name']))) : $_POST['old_image_mitra'];
    $sql = "UPDATE mitras SET name='$name', country='$country', image='$image_mitra_name' WHERE id=$id";
    $query = mysqli_query($conn, $sql);
    if($query){
        if($image_mitra_updated){
            $path = "../assets/images/mitras/".$image_mitra_name;
            move_uploaded_file($_FILES['image']['tmp_name'], $path);
            unlink("../assets/images/mitras/".$_POST['old_image_mitra']);
        }
        header("Location: mitras.php");
        exit();
    } else {
        echo "<script>alert('Update failed!')</script>";
    }
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM mitras WHERE id=$id");
    $data = mysqli_fetch_assoc($query);
    if(!$data){
        header("Location: mitras.php");
        exit();
    }
} else {
    header("Location: mitras.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mitra Update | Rakushop Indonesia</title>
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
            <a href="mitras.php">
                <i class="fas fa-gamepad"></i>
                Games
            </a>
            <a href="mitras.php">
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
            <h2>Mitra Update</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <input type="hidden" name="updated_at" value="<?= date('Y-m-d H:i:s') ?>">
                <table>
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td><input type="text" name="name" value="<?= $data['name'] ?>" required></td>
                    </tr>
                    <tr>
                        <td>Country</td>
                        <td>:</td>
                        <td><input type="text" name="country" value="<?= $data['country'] ?>" required></td>
                    </tr>
                    <tr>
                        <td>Image Mitra</td>
                        <td>:</td>
                        <td>
                            <input type="file" name="image" accept="image/*">
                            <img src="../assets/images/mitras/<?= $data['image'] ?>" alt="<?= $data['image'] ?>" height="50">
                            <input type="hidden" name="old_image_mitra" value="<?= $data['image'] ?>">
                    </tr>
                    <tr>
                        <td colspan="3"><input type="submit" name="submit" value="Update"></td>
                    </tr>
                </table>
            </form>
        </div>
    </main>
    <?php include '../components/admin_footer.php' ?>
</body>
</html>