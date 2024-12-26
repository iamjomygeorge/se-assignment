<?php 
session_start();
require_once("connection.php");

$error = '';

try {
    $result = mysqli_query($conn, "SELECT * FROM example ORDER BY id DESC");
    if (!$result) {
        throw new Exception("Error fetching data: " . mysqli_error($conn));
    }
} catch (Exception $e) {
    $error = $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
    try {
        if (!isset($_SESSION['id'])) {
            throw new Exception("You must be logged in to upload images.");
        }

        $userId = $_SESSION['id']; // Logged-in user ID

        $stmt = $conn->prepare("SELECT id FROM images WHERE user_id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $resultImages = $stmt->get_result();
        if ($resultImages->num_rows > 0) {
            throw new Exception("You can only upload one image.");
        }

        $image = $_FILES['image']['tmp_name'];

        if (!is_uploaded_file($image)) {
            throw new Exception("Invalid file upload.");
        }

        $imageData = file_get_contents($image);
        if (!$imageData) {
            throw new Exception("Failed to read the uploaded file.");
        }

        $stmt = $conn->prepare("INSERT INTO images (user_id, data) VALUES (?, ?)");
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }

        $null = NULL;
        $stmt->bind_param("ib", $userId, $null);
        $stmt->send_long_data(1, $imageData);

        if (!$stmt->execute()) {
            throw new Exception("Error executing statement: " . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        $uploadMessage = $e->getMessage();
    }
}

if (isset($_GET['delete_image_id'])) {
    try {
        $imageId = $_GET['delete_image_id'];
        $userId = $_SESSION['id'];

        $stmt = $conn->prepare("DELETE FROM images WHERE id = ? AND user_id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }

        $stmt->bind_param("ii", $imageId, $userId);
        if (!$stmt->execute()) {
            throw new Exception("Error deleting image: " . $stmt->error);
        }

        $stmt->close();
    } catch (Exception $e) {
        $uploadMessage = $e->getMessage();
    }
}

$imageResult = [];
if (isset($_SESSION['id'])) {
    try {
        $userId = $_SESSION['id'];
        $stmt = $conn->prepare("SELECT id FROM images WHERE user_id = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }

        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $resultImages = $stmt->get_result();
        if ($resultImages) {
            $imageResult = $resultImages->fetch_all(MYSQLI_ASSOC);
        } else {
            throw new Exception("Error fetching images: " . $stmt->error);
        }
        $stmt->close();
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

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
        <h1>Hello, <?php echo htmlspecialchars($_SESSION['name'], ENT_QUOTES, 'UTF-8'); ?></h1>
        <a href="logout.php" class="logout-btn">Logout</a>
    </header>
    <?php if ($error): ?>
        <div class="error"><?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?></div>
    <?php endif; ?>

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
        if ($result) {
            while ($res = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($res['name'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($res['age'], ENT_QUOTES, 'UTF-8') . "</td>";
                echo "<td>" . htmlspecialchars($res['email'], ENT_QUOTES, 'UTF-8') . "</td>";    
                echo "<td>
                    <a href=\"edit.php?id={$res['id']}\">Edit</a> | 
                    <a href=\"delete.php?id={$res['id']}\" onClick=\"return confirm('Are you sure you want to delete?')\">Delete</a>
                </td>";
                echo "</tr>";
            }
        }
        ?>
    </table>

    <h2>Upload an Image</h2>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="image">Choose an image to upload:</label>
        <input type="file" name="image" id="image" accept="image/*" required>
        <button type="submit">Upload</button>
    </form>

    <h2>Your Uploaded Images</h2>
    <ul>
        <?php
        if (!empty($imageResult)) {
            foreach ($imageResult as $image) {
                echo "<li>Image " . 
                    " <a href=\"?delete_image_id=" . $image['id'] . "\" onClick=\"return confirm('Are you sure you want to delete this image?')\">Delete</a> | 
                    <a href=\"view.php?id=" . $image['id'] . "\">View</a></li>";
            }
        } else {
            echo "<li>No images uploaded yet.</li>";
        }
        ?>
    </ul>
</body>
</html>
<?php 
} else {
    header("Location: index.php");
    exit();
}
?>