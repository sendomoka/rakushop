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
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $updated_at = $_POST['updated_at'];
    $sql = "UPDATE users SET name='$name', email='$email', password='$password', role='$role', updated_at='$updated_at' WHERE id=$id";
    $query = mysqli_query($conn, $sql);
    if($query){
        header("Location: users.php");
        exit();
    } else {
        echo "<script>alert('Update failed!')</script>";
    }
}

if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    $data = mysqli_fetch_assoc($query);
    if(!$data){
        header("Location: users.php");
        exit();
    }
} else {
    header("Location: users.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Update | Rakushop Indonesia</title>
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
            <a href="users.php">
                <i class="fas fa-gamepad"></i>
                Games
            </a>
            <a href="users.php">
                <i class="fas fa-wallet"></i>
                E-Wallets
            </a>
            <a href="orders.php" <?= basename($_SERVER['PHP_SELF']) == 'orders.php' ? 'class="active"' : ''; ?>>
                <i class="fas fa-shopping-cart"></i>
                Orders
            </a>
            <?php
            if($_SESSION['role'] == 'owner'){
                echo '<a href="users.php" class="active">
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
            <h2>User Update</h2>
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
                        <td>Email</td>
                        <td>:</td>
                        <td><input type="email" name="email" value="<?= $data['email'] ?>" required></td>
                    </tr>
                    <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td><input type="password" name="password" value="<?= $data['password'] ?>" required></td>
                    </tr>
                    <tr>
                        <td>Role</td>
                        <td>:</td>
                        <td>
                            <select name="role" required>
                                <option value="" disabled>Pilih Role</option>
                                <option value="owner" <?= $data['role'] == 'owner' ? 'selected' : '' ?>>Owner</option>
                                <option value="admin" <?= $data['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                            </select>
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