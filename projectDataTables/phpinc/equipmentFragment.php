<?php
  require_once 'dbconnect.php';
?>

<select class="categorySelect <?php echo $extraClass ?>" name="category">
  <option value="-1" hidden>Category</option>
  <?php
    $categoryStmt = $con->prepare("SELECT CategoryID, Name FROM P_CATEGORIES ORDER BY Name");
    $categoryStmt->execute();
    $categories = $categoryStmt->fetchAll();
    foreach($categories as $category) {
      echo '<option value="'.$category['CategoryID'].'">'.$category['Name'].'</option>';
    }
  ?>
</select>

<select class="manufacturerSelect <?php echo $extraClass ?>" name="select">
  <option value="-1" hidden>Manufacturer</option>
  <?php
    $manufacturerStmt = $con->prepare("SELECT ManufacturerID, Name FROM P_MANUFACTURERS ORDER BY Name");
    $manufacturerStmt->execute();
    $manufacturers = $manufacturerStmt->fetchAll();
    foreach($manufacturers as $manufacturer) {
      echo '<option value="'.$manufacturer['ManufacturerID'].'">'.$manufacturer['Name'].'</option>';
    }
  ?>
</select>

<select class="modelSelect <?php echo $extraClass ?>" name="model">
  <option value="-1" hidden>Model</option>
  <?php
    $modelStmt = $con->prepare("SELECT ModelID, Name FROM P_MODELS ORDER BY Name");
    $modelStmt->execute();
    $models = $modelStmt->fetchAll();
    foreach($models as $model) {
      echo '<option value="'.$model['ModelID'].'">'.$model['Name'].'</option>';
    }
  ?>
</select>

<select class="userSelect <?php echo $extraClass ?>" name="user">
  <option value="-1" hidden>User</option>
  <?php
    $userStmt = $con->prepare("SELECT UserID, Name FROM P_USERS ORDER BY Name");
    $userStmt->execute();
    $users = $userStmt->fetchAll();
    foreach($users as $user) {
      echo '<option value="'.$user['UserID'].'">'.$user['Name'].'</option>';
    }
  ?>
</select>

<select class="locationSelect <?php echo $extraClass ?>" name="location">
  <option value="-1" hidden>Location</option>
  <?php
    $locationStmt = $con->prepare("SELECT LocationID, Name FROM P_LOCATIONS ORDER BY Name");
    $locationStmt->execute();
    $locations = $locationStmt->fetchAll();
    foreach($locations as $location) {
      echo '<option value="'.$location['LocationID'].'">'.$location['Name'].'</option>';
    }
  ?>
</select>

<br>
<br>

Purchased:<input type="date" class="purchaseDate <?php echo $extraClass ?>" name="purchaseDate">

&nbsp&nbsp Warranty:<input type="number" class="warranty <?php echo $extraClass ?>" name="warranty" min="0">&nbspyears

<?php
  if($doQty) {
    echo '&nbsp&nbsp Qty: <input type="number" class="qty '.$extraClass.'" name="qty" min="1" max="99">';
  }
?>

<br><br>

Network ID:<input type="text" class="networkID <?php echo $extraClass ?>" name="networkID">

Serial#:<input type="text" class="serial <?php echo $extraClass ?>" name="serial">

Notes:<input type="text" class="notes <?php echo $extraClass ?>" name="notes">

<br><br>
