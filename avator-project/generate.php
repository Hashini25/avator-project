<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gender = $_POST['gender'];
    $chest = $_POST['chest'];
    $waist = $_POST['waist'];
    $height = $_POST['height'];

    // Insert into DB
    mysqli_query($conn, "INSERT INTO users (gender, chest, waist, height) VALUES ('$gender', '$chest', '$waist', '$height')");
    $last_id = mysqli_insert_id($conn);
} else {
    // Load from DB if coming from edit/update
    $last_id = $_GET['id'];
    $res = mysqli_query($conn, "SELECT * FROM users WHERE id=$last_id");
    $row = mysqli_fetch_assoc($res);
    $gender = $row['gender'];
    $chest = $row['chest'];
    $waist = $row['waist'];
    $height = $row['height'];
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Avatar</title>
  <style>
    .avatar {
      width: <?= $waist + 30 ?>px;
      height: <?= $height ?>px;
      background-color: <?= $gender == 'male' ? 'blue' : 'pink' ?>;
      margin: 20px auto;
      border-radius: 10px;
    }
  </style>
</head>
<body class="container mt-5">

  <h2>Your Avatar</h2>
  <div class="avatar"></div>
  <p>Gender: <?= $gender ?> | Chest: <?= $chest ?> cm | Waist: <?= $waist ?> cm | Height: <?= $height ?> cm</p>
  <a href="edit.php?id=<?= $last_id ?>" class="btn btn-warning">Edit Measurements</a>

</body>
</html>
