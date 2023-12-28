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

//adding to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $id = unique_id();

    $qty = $_POST['qty'];
    $qty = filter_var($qty, FILTER_SANITIZE_STRING);


    $verify_cart = $conn->prepare("SELECT * FROM cart WHERE product_id = ? AND user_id = ?");
    $verify_cart->execute([$product_id, $user_id]);

    $max_cart_items = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
    $max_cart_items->execute([$user_id]);

    if ($verify_cart->rowCount() > 0) {
        $warn_msg[] = "Product already added to cart";
    } else if ($max_cart_items->rowCount() > 20) {
        $warn_msg[] = "cart is full";
    } else {
        $select_price = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1 ");
        $select_price->execute([$product_id]);
        $fetch_price = $select_price->fetch(PDO::FETCH_ASSOC);

        $insert_cart = $conn->prepare("INSERT INTO cart (id, product_id, user_id, price, qty) VALUES (?, ?, ?, ?, ?)");
        $insert_cart->execute([$id, $product_id, $user_id, $fetch_price['price'], $qty]);
        $success_msg[] = 'Product added to cart successfully';

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
    <title>Green Coffee - Product detail</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>Product details </h1>
        </div>

        <div class="title2">
            <a href="home.php">home</a><span> Product detail</span>
        </div>
      

        <section class="view_page">
            <?php
                if(isset($_GET['pid'])){
                    $pid = $_GET['pid'];
                    $select_products = $conn->prepare("SELECT * FROM products WHERE id = '$pid'");
                    $select_products->execute();
                    if($select_products->rowcount()>0){
                        while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){

                      
            ?>
            <form method="post" action="">
                <img src="image/<?php echo $fetch_products['image']; ?>" alt="">
                <div class="detail">
                    <div class="price">$<?php echo $fetch_products['price']?>/-</div>
                    <div class="name"><?php echo $fetch_products['name']?></div>
                    <div class="detail">
                        <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magni corporis itaque sint illo pariatur saepe in non dolorum voluptates illum iusto, vitae alias recusandae labore hic eius esse quae, explicabo nostrum, unde quidem quia. Necessitatibus explicabo nostrum expedita dicta assumenda?Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magni corporis itaque sint illo pariatur saepe in non dolorum voluptates illum iusto, vitae alias recusandae labore hic eius esse 
                            quae, explicabo nostrum, unde quidem quia. Necessitatibus explicabo nostrum expedita dicta assumenda?</p>
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $fetch_products['id'];?>">
                    <div class="button">
                        <button type="submit" name="add_to_wishlist" class="btn"> add to wishlist <i class="bx bx-heart"></i></button>
                        <input type="hidden" name="qty" value="1" min="0" class="quantity">
                        <button type="submit" name="add_to_cart" class="btn"> add to cart <i class="bx bx-cart"></i></button>


                    </div>
                </div>
            </form>
           <?php
                  }
                }
                } 
           ?>

        </section>

       
        <?php include 'components/footer.php'; ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="script.js"></script>
    <?php include 'components/alert.php'; ?>

</body>

</html>