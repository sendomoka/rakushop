<?php
include '../config/connect.php';

$searchText = $_POST['search'];
$query = "SELECT od.*, g.name AS game_name, c.amount AS cred_amount, c.price AS cred_price, e.name AS ewallet FROM orders od JOIN games g ON od.game_id = g.id JOIN game_credits c ON od.game_credits_id = c.id JOIN ewallets e ON od.ewallet_id = e.id WHERE od.userid LIKE '%$searchText%' OR od.email LIKE '%$searchText%' OR g.name LIKE '%$searchText%' OR c.amount LIKE '%$searchText%' OR c.price LIKE '%$searchText%' OR e.name LIKE '%$searchText%'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $no = 1;
    while ($order = mysqli_fetch_assoc($result)) {
        echo "
        <tr>
            <td>$no</td>
            <td>{$order['userid']}</td>
            <td>{$order['email']}</td>
            <td>{$order['game_name']}</td>
            <td>{$order['cred_amount']} | {$order['cred_price']}</td>
            <td>{$order['ewallet']}</td>
            <td>
                <a href='order_u.php?id={$order['id']}'><i class='fas fa-edit'></i></a>
                <a href='?id={$order['id']}'><i class='fas fa-trash'></i></a>
            </td>
        </tr>";
        $no++;
    }
} else {
    echo "<tr><td colspan='7'>No records found</td></tr>";
}
?>
