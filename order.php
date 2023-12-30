<?php
include 'components/connection.php';
session_start();
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

if (isset($_POST['logout'])) {
    session_destroy();
    header('location: login.php');
}

//adding to wishlist
if (isset($_POST['add_to_wishlist'])) {
    $product_id = $_POST['product_id'];
    $id = unique_id();

    $verify_wishlist = $conn->prepare("SELECT * FROM wishlist WHERE product_id = ? AND user_id = ?");
    $verify_wishlist->execute([$product_id, $user_id]);

    $cart_num = $conn->prepare("SELECT * FROM cart WHERE product_id = ? AND user_id = ?");
    $cart_num->execute([$product_id, $user_id]);

    if ($verify_wishlist->rowCount() > 0) {
        $warning_msg[] = "Product already added to wishlist";
    } else if ($cart_num->rowCount() > 0) {
        $warning_msg[] = "Product already added to cart";
    } else {
        $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1 ");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_wishlist = $conn->prepare("INSERT INTO wishlist (id, product_id, user_id, price) VALUES (?, ?, ?, ?)");
        $insert_wishlist->execute([$id, $product_id, $user_id, $fetch_price['price']]);
        $success_msg[] = 'Product added to wishlist successfully';
    }
}


?>
<style type="text/css">
    <?php include 'style.css'; ?>
</style>

<!DOCTYPE html>
<html lang="en">    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">
    <title>Green Coffee - order page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>my order</h1>
        </div>

        <div class="title2">
            <a href="home.php">home</a><span>/ order</span>
        </div>
      

        <section class="orders">
                <div class="title">
                    <img src="img/download.png" class="logo" alt="">
                    <h1>my orders</h1>
                    <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Repudiandae velit laborum delectus repellendus similique earum qui fugit, tenetur et alias!</p>
                </div>  

                <div class="box-container">
                    <?php
                        $select_orders = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
                        $select_orders->execute([$user_id]);
                    if ($select_orders->rowCount() > 0) {
                        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                            $select_product = $conn->prepare("SELECT * FROM products WHERE id = ?");
                            $select_product->execute([$fetch_orders['product_id']]);
                            if ($select_product->rowCount() > 0) {
                                while ($fetch_product = $select_product->fetch(PDO::FETCH_ASSOC)) {
                                    ?>

                                    <div class="box" <?php if ($fetch_orders['status'] == 'cancel') { echo 'style="border: 2px solid red"; '; } ?>>
                                        <a href="view_order.php?get_id=<?= $fetch_orders['id']; ?>">
                                            <p class="date"><i class="bi bi-calendar-fill"></i><span><?= $fetch_orders['date']; ?></span></p>
                                            <img src="image/<?= $fetch_product['image']; ?>" alt="" class="image">
                                            <div class="row">
                                                <h3 class="name"><?= $fetch_product['name']; ?> </h3>
                                                <p class="price">Price : <?= $fetch_orders['price']; ?> x <?= $fetch_orders['qty']; ?></p>
                                                <p class="status" style="color:<?php if ($fetch_orders['status'] == 'delivered') {
                                                    echo 'green';} elseif($fetch_orders['status'] == 'canceled') {echo "red";} else {
                                                    echo 'orange'; } ?>"></p>
                                            </div>
                                        </a>

                                    </div>

                                <?php

                                }
                            }
                        }
                    } else {
                        echo "<p class='empty'>No orders yet!</p>";
                    }
                    ?>
                </div>
        </section>

       
        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>

</body>

</html>



<!-- <form action="upload.php" method="post" enctype="multipart/form-data">
    <input type="file" name="my_image" id="">
    <input type="submit" name="submit" value="upload">
</form> -->