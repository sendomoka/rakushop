<?php
include '../config/connect.php';

$searchText = $_POST['search'];
$query = "SELECT * FROM games WHERE name LIKE '%$searchText%' OR credit_name LIKE '%$searchText%'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($game = mysqli_fetch_assoc($result)) {
        echo "
        <tr>
            <td>$no</td>
            <td><img src='../assets/images/games/{$game['cover']}' alt='cover'></td>
            <td>{$game['name']}</td>
            <td>{$game['credit_name']}</td>
            <td>
                <a href='game_u.php?id={$game['id']}'><i class='fas fa-edit'></i></a>
                <a href='?id={$game['id']}'><i class='fas fa-trash'></i></a>
            </td>
        </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='5'>No records found</td></tr>";
}
?>
