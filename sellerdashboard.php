<?php include($_SERVER['DOCUMENT_ROOT'].'/Registration/server.php'); 

if(empty($_SESSION['username'])){
    header('location:login.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User registration</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="header">
    <h2>Home</h2>
    </div>
    <div class="title">
    <?php if(isset($_SESSION['success'])):?>
        <div class="success">
        <h3>
        <?php 
            echo $_SESSION['success'];
            unset($_SESSION['success']);
        ?>
        </h3></div>
    <?php endif ?>
    
    <?php if (isset($_SESSION["username"])): ?>
        <p>Welcome to the seller's dashboard, <?php echo $_SESSION["username"];?></p>
        <p><a href="sellerdashboard.php?logout='1'" class="btn">Logout</a></p>
    <?php endif ?>
    </div>
    <form method="post" action="sellerdashboard.php>
    <?php include('errors.php'); ?>
    <div class="input-group">
    <label>Name of the commodity*</label>
    <input type="text" name="name">
    </div>
    <div class="input-group">
    <label>Description of the commodity</label>
    <input type="text" name="description">
    </div>
    <div class="input-group">
    <label>Picture:</label>
    <input type="text" name="image">
    </div>
    <div class="input-group">
    <label>Price of the commodity:*</label>
    <input type="number" name="price">
    </div>
    <div class="input-group">
    <label>Quantity available:*</label>
    <input type="number" name="quantity">
    </div>
    <div class="input-group">
    <button type="submit" name="upload" class="btn">Upload</button>
    </div>                                                                <!--Getting new added product's details-->          

   

    <?php
    if(isset($_POST['upload'])){
        $name=mysqli_real_escape_string($db,$_POST['name']);
        $description=mysqli_real_escape_string($db,$_POST['description']);
        $image=mysqli_real_escape_string($db,$_POST['image']);
        $price=mysqli_real_escape_string($db,$_POST['price']);
        $quantity=mysqli_real_escape_string($db,$_POST['quantity']);
        if(empty($name)){
            array_push($errors,"Name of the commodity is required");
        }
        if(empty($price)){
            array_push($errors,"Price of the commodity is required");
        }
        if(empty($quantity)){
            array_push($errors,"Availability of the commodity is required");
        }
        if(count($errors)==0){

            $sql2="INSERT INTO product (pname, description1, image1, price, quantity)
                        VALUES ('$name', '$description', '$image', '$price', '$quantity')";
            mysqli_query($db,$sql2);
        }
    }                                                                   //Uploading the product by the seller to the database
    ?>
    
</body>
</html>