<?php
include '../config/connect.php';

$searchText = $_POST['search'];
$query = "SELECT * FROM users WHERE name LIKE '%$searchText%' OR email LIKE '%$searchText%' OR role LIKE '%$searchText%' OR updated_at LIKE '%$searchText%'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($user = mysqli_fetch_assoc($result)) {
        echo "
        <tr>
            <td>$no</td>
            <td>{$user['name']}</td>
            <td>{$user['email']}</td>
            <td>{$user['role']}</td>
            <td>{$user['updated_at']}</td>
            <td>
                <a href='user_u.php?id={$user['id']}'><i class='fas fa-edit'></i></a>
                <a href='?id={$user['id']}'><i class='fas fa-trash'></i></a>
            </td>
        </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='6'>No records found</td></tr>";
}
?>
