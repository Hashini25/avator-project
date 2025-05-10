<?php
include 'includes/db.php';

$id = $_POST['id'];
$gender = $_POST['gender'];
$chest = $_POST['chest'];
$waist = $_POST['waist'];
$height = $_POST['height'];

mysqli_query($conn, "UPDATE users SET gender='$gender', chest='$chest', waist='$waist', height='$height' WHERE id=$id");
header("Location: generate.php?id=$id");
?>
