<?php include($_SERVER['DOCUMENT_ROOT'].'/Registration/server.php'); 

if(empty($_SESSION['username'])){
    header('location:login.php');
}

 if (isset($_POST["add"])){
        if (isset($_SESSION["cart"])){
            $item_array_id = array_column($_SESSION["cart"],"product_id");
            if (!in_array($_GET["id"],$item_array_id)){
                $count = count($_SESSION["cart"]);
                $item_array = array(
                    'product_id' => $_GET["id"],
                    'item_name' => $_POST["hidden_name"],
                    'product_price' => $_POST["hidden_price"],
                    'item_quantity' => $_POST["quantity"],
                );
                $_SESSION["cart"][$count] = $item_array;
                echo '<script>window.location="buyerdashboard.php"</script>';
            }else{
                echo '<script>alert("Product is already Added to Cart")</script>';
                echo '<script>window.location="buyerdashboard.php"</script>';
            }
        }else{
            $item_array = array(
                'product_id' => $_GET["id"],
                'item_name' => $_POST["hidden_name"],
                'product_price' => $_POST["hidden_price"],
                'item_quantity' => $_POST["quantity"],
            );
            $_SESSION["cart"][0] = $item_array;
        }
    }
    if (isset($_GET["action"])){
        if ($_GET["action"] == "delete"){
            foreach ($_SESSION["cart"] as $keys => $value){
                if ($value["product_id"] == $_GET["id"]){
                    unset($_SESSION["cart"][$keys]);
                    echo '<script>alert("Product has been Removed...!")</script>';
                    echo '<script>window.location="buyerdashboard.php"</script>';
                }
            }
        }
    }
 ?>   
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
    @import url('https://fonts.googleapis.com/css?family=Titillium+Web');
    *{
        font-family:'Titillium Web', sans-serif;
    }
    .product{
        border:1px solid #cccccc;
        padding:10px;
        text-align:center;
        background-color:#efefef;
    }
    </style>
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
        <p>Welcome to the buyer's dashboard, <?php echo $_SESSION["username"];?></p>
        <p><a href="buyerdashboard.php?logout='1'" class="btn">Logout</a></p>
    <?php endif ?>
    </div>
    <div class="container">
    <h2>Shopping Cart</h2>
    <?php
        $query="SELECT * FROM product ORDER BY id ASC";
        $result=mysqli_query($db,$query);
        if(mysqli_num_rows($result)>0){
            while($row=mysqli_fetch_array($result)){
        
    ?>
    <form method="post" action="buyerdashboard.php?action=add&id=<?php echo $row["id"] ?>">
    <div class="product">
    <img src="<?php echo $row["image"]; ?>">
    <h5><?php echo $row["pname"];?></h5>
    <h5><?php echo $row["description"]?></h5>
    <h5><?php echo "Rs.";echo $row["price"];?></h5>
    <input type="text" name="quantity" value="1">
    <input type="hidden" name="hidden_name" value="<?php echo $row["pname"];?>">
    <input type="hidden" name="hidden_price" value="<?php echo $row["price"];?>">
    <input type="submit" name="add" style="margin-top:5px;" value="Add to Cart">
    </div>
    </form>
    <?php
            }
        }
    ?>
    <h3 class="title2">Shopping cart details</h3>
        <div class="table">
        <table>
            <tr>
            <th width="30%">Product Name</th>
            <th width="20%">Quantity</th>
            <th width="30%">Price</th>
            <th width="30%">Total Price</th>
            <th width="30%">Remove Item</th>
            </tr>
            <?php
            if(!empty($_SESSION["cart"])){
                $total=0;
                foreach ($_SESSION['cart'] as $key => $value){
                    ?>
            <tr>
                <td><?php echo $value['item_name'];?></td>    
                <td><?php echo $value['item_quantity'];?></td>
                <td><?php echo "Rs.";echo $value["product_price"];?></td>
                <td><?php echo "RS.";echo number_format($value['item_quantity'] * $value['product_price'],2);?></td>    
                <td><a href="buyerdashboard.php?action=delete&id=<?php echo $value["product_id"];?>">Remove Item</td>    
            </tr>    
            <?php
                $total=$total+($value["item_quantity"] * $value["product_price"]);
                }
            ?>
            <tr>
                <td align="right">Total</td>
                <th align="right"><?php echo "Rs.";echo number_format($total,2);?></th>
                <td></td>
            </tr>
            <?php
            }
            ?>
            </table>
        </div>
    </div>
</body>
</html>


