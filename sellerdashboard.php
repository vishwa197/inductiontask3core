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
    <div class="content">
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
</body>
</html>