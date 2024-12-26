<?php 
session_start();
require_once("connection.php");
$result = mysqli_query($conn, "SELECT * FROM example ORDER BY id DESC");

if (isset($_SESSION['id']) && isset($_SESSION['user_name'])) { 
?>
<!DOCTYPE html>
<html>
<head>
    <title>HOME</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <header>
        <h1>Hello, <?php echo $_SESSION['name']; ?></h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </header>
    <p>
        <a href="add.php">Add New Data</a>
    </p>
    <table width='80%' border=0>
        <tr bgcolor='#DDDDDD'>
            <td><strong>Name</strong></td>
            <td><strong>Age</strong></td>
            <td><strong>Email</strong></td>
            <td><strong>Action</strong></td>
        </tr>
        <?php
        while ($res = mysqli_fetch_assoc($result)) {
            echo "<tr>";
            echo "<td>".$res['name']."</td>";
            echo "<td>".$res['age']."</td>";
            echo "<td>".$res['email']."</td>";    
            echo "<td><a href=\"edit.php?id=$res[id]\">Edit</a> | 
            <a href=\"delete.php?id=$res[id]\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a></td>";
        }
        ?>
    </table>
</body>
</html>

<?php 
} else {
    header("Location: index.php");
    exit();
}
?>