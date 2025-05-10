<?php
include 'includes/db.php';
$id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM users WHERE id = $id");
$data = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Edit Avatar</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="container mt-5">

  <h2>Edit Measurements</h2>
  <form action="update.php" method="POST" class="row g-3">
    <input type="hidden" name="id" value="<?= $data['id'] ?>">
    <div class="col-md-4">
      <label class="form-label">Gender</label>
      <select name="gender" class="form-select" required>
        <option value="male" <?= $data['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
        <option value="female" <?= $data['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
      </select>
    </div>
    <div class="col-md-4">
      <label class="form-label">Chest (cm)</label>
      <input type="number" name="chest" class="form-control" value="<?= $data['chest'] ?>" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Waist (cm)</label>
      <input type="number" name="waist" class="form-control" value="<?= $data['waist'] ?>" required>
    </div>
    <div class="col-md-4">
      <label class="form-label">Height (cm)</label>
      <input type="number" name="height" class="form-control" value="<?= $data['height'] ?>" required>
    </div>
    <div class="col-12">
      <button type="submit" class="btn btn-success">Update</button>
    </div>
  </form>

</body>
</html>
