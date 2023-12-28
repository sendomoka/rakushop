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
    $mitra = $_POST['mitras'];
    $image_updated = !empty($_FILES['image']['name']);
    $image_name = $image_updated ? uniqid('ewallet_', true) . '.' . strtolower(end(explode('.', $_FILES['image']['name']))) : $_POST['image_existing'];
    $sql = "UPDATE ewallets SET name='$name', mitra_id='$mitra', image='$image_name' WHERE id=$id";
    $query = mysqli_query($conn, $sql);
    if($query){
        if($image_updated){
            $path = "../assets/icons/ewallets/".$image_name;
            move_uploaded_file($_FILES['image']['tmp_name'], $path);
            unlink("../assets/icons/ewallets/".$_POST['image_existing']);
        }
        header("Location: ewallets.php");
        exit();
    } else {
        echo "<script>alert('Update failed!')</script>";
    }
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM ewallets WHERE id=$id");
    $data = mysqli_fetch_assoc($query);
    if(!$data){
        header("Location: ewallets.php");
        exit();
    }
} else {
    header("Location: ewallets.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Wallets Update | Rakushop Indonesia</title>
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
            <a href="ewallets.php">
                <i class="fas fa-gamepad"></i>
                Games
            </a>
            <a href="ewallets.php" class="active">
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
            <h2>E-Wallet Update</h2>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $data['id'] ?>">
                <input type="hidden" name="image_existing" value="<?= $data['image'] ?>">
                <table>
                    <tr>
                        <td>Name</td>
                        <td>:</td>
                        <td><input type="text" name="name" value="<?= $data['name'] ?>" required></td>
                    </tr>
                    <tr>
                        <td>Mitra</td>
                        <td>:</td>
                        <td>
                            <select name="mitras" required>
                                <option value="" disabled>Pilih Mitra</option>
                                <?php
                                $querym = mysqli_query($conn, "SELECT * FROM mitras");
                                while ($mitra_data = mysqli_fetch_array($querym)) {
                                    $selected = ($data['mitra_id'] == $mitra_data['id']) ? 'selected' : '';
                                    echo "<option value='$mitra_data[id]' $selected>$mitra_data[name]</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>Image E-Wallet</td>
                        <td>:</td>
                        <td style="display: flex; align-items: center">
                            <input type="file" name="image" id="image" accept="image/*">
                            <img src="../assets/icons/ewallet/<?= $data['image'] ?>" alt="ewallet" height="50">
                        </td>
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