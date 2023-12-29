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
        exit();
    }

    if (isset($_POST['place_order'])) {
        // Sanitize and retrieve form data
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $number = filter_var($_POST['number'], FILTER_SANITIZE_NUMBER_INT);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $address = filter_var($_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ', ' . $_POST['pincode'], FILTER_SANITIZE_STRING);
        $address_type = filter_var($_POST['address_type'], FILTER_SANITIZE_STRING);
        $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);

        $verify_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
        $verify_cart->execute([$user_id]);

        if (isset($_GET['get_id'])) {
            $get_product = $conn->prepare("SELECT * FROM products WHERE id = ? LIMIT 1");
            $get_product->execute([$_GET['get_id']]);
            if ($get_product->rowCount() > 0) {
                while ($fetch_p = $get_product->fetch(PDO::FETCH_ASSOC)) {
                    // Insert order based on a single product
                    $insert_order = $conn->prepare("INSERT INTO orders (id, user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                    $insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $fetch_p['id'], $fetch_p['price'], 1]);
                    header('location: order.php');
                    exit();
                }
            } else {
                $warning_msg[] = 'Something went wrong';
            }
        } elseif ($verify_cart->rowCount() > 0) {
            while ($f_cart = $verify_cart->fetch(PDO::FETCH_ASSOC)) {
                // Insert order based on items in the cart
                $insert_order = $conn->prepare("INSERT INTO orders (id, user_id, name, number, email, address, address_type, method, product_id, price, qty) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
                $insert_order->execute([unique_id(), $user_id, $name, $number, $email, $address, $address_type, $method, $f_cart['product_id'], $f_cart['price'], $f_cart['qty']]);
                header('location: order.php');
                exit();
            }
            if ($insert_order) {
                // Delete cart items after successful order placement
                $delete_cart_id = $conn->prepare("DELETE FROM cart WHERE user_id = ?");
                $delete_cart_id->execute([$user_id]);
                header('location: order.php');
                exit();
            }
        } else {
            $warning_msg[] = 'Something went wrong';
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
    <title>Green Coffee - checkout page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <div class="banner">
            <h1>checkout summary</h1>
        </div>

        <div class="title2">
            <a href="home.php">home</a><span>/ checkout summary </span>
        </div>
      

        <section class="checkout">
            <div class="title">
                <img src="img/download.png" class="logo" alt="">
                <h1>checkout summary</h1>
                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Numquam, facere!</p>
            </div>
            <div class="row">
                    <form action="" method="post">
                        <h3>billing details</h3>
                        <div class="flex">
                            <div class="box">
                                <div class="input-field">
                                    <p>your name <span>*</span></p>
                                    <input type="text" name="name" id="" placeholder="your name" class="input" maxlength="50" required>
                                </div>

                                <div class="input-field">
                                    <p>email address <span>*</span></p>
                                    <input type="email" name="email" id="" placeholder="email address" class="input" maxlength="50" required>
                                </div>

                                <div class="input-field">
                                    <p>phone number <span>*</span></p>
                                    <input type="number" name="number" id="" placeholder="phone number" class="input" maxlength="10" required>
                                </div>

                                <div class="input-field">
                                    <p>Payment method <span>*</span></p>
                                    <select name="method" class="input">
                                        <option value="cash on delivery">cash on delivery</option>
                                        <option value="credit or debit card">credit or debit card </option>
                                        <option value="net banking">net banking</option>
                                        <option value="paytm">paytm</option>
                                        <option value="UPI">UPI</option>
                                    </select>
                                </div>

                                <div class="input-field">
                                    <p>address type <span>*</span></p>
                                    <select name="address_type" class="input">
                                        <option value="home">home</option>
                                        <option value="office">office</option>
                                    </select>
                                </div>
                            </div>

                            <div class="box">
                                <div class="input-field">
                                    <p>address line 01 <span>*</span></p>
                                    <input type="text" name="flat" placeholder="e.g flat & building number" class="input" maxlength="50" required>
                                </div>

                                <div class="input-field">
                                    <p>address line 02 <span>*</span></p>
                                    <input type="text" name="street" id="" placeholder="street name" class="input" maxlength="50" required>
                                </div>

                                <div class="input-field">
                                    <p>city name <span>*</span></p>
                                    <input type="text" name="city" id="" placeholder="city name" class="input" maxlength="50" required>
                                </div>

                                <div class="input-field">
                                    <p>country name <span>*</span></p>
                                    <input type="text" name="country" id="" placeholder="state" class="input" maxlength="50" required>
                                </div>

                                <div class="input-field">
                                    <p>pincode <span>*</span></p>
                                    <input type="number" name="pincode" id="" placeholder="110022" class="input" maxlength="6" min="0" max="999999" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="place_order" class="btn">place order</button>
                    </form>
                     <div class="summary">
                        <h3>my bag</h3>
                        <div class="box-container">
                            <?php
                            $grand_total = 0;
                            if (isset($_GET['get_id'])) {
                                $select_get = $conn->query("SELECT * FROM product WHERE id = ?");
                                $select_get->execute([$_GET['get_id']]);
                                while ($fetch_get = $select_get->fetch(PDO::FETCH_ASSOC)) {
                                    $sub_total = $fetch_get['price'];
                                    $grand_total += $sub_total;

                                    ?>
                                                                    <div class="box">
                                                                        <img src="image/<?php echo $fetch_get['image']; ?>" alt="" class="image">
                                                                        <div class="">
                                                                            <h3 class="name"><?php echo $fetch_get['name']; ?></h3>
                                                                            <p class="price"><?php echo $fetch_get['price']; ?>/-</p>
                                                                        </div>
                                                                    </div>
                                                                    <?php
                                }
                            } else {
                                $select_cart = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
                                $select_cart->execute([$user_id]);
                                if ($select_cart->rowCount() > 0) {
                                    while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                                        $select_products = $conn->prepare("SELECT * FROM products WHERE id = ?");
                                        $select_products->execute([$fetch_cart['product_id']]);
                                        $fetch_product = $select_products->fetch(PDO::FETCH_ASSOC);
                                        $sub_total = $fetch_product['price'] * $fetch_cart['qty'];
                                        $grand_total += $sub_total;
                                        ?>
                                                                                        <div class="flex">
                                                                                            <img src="image/<?= $fetch_product['image']; ?>" alt="" class="image">
                                                                                            <div class="">
                                                                                                <h3 class="name"><?= $fetch_product['name']; ?></h3>
                                                                                                <p class="price"><?= $fetch_product['price']; ?> X <?= $fetch_cart['qty']; ?></p>
                                                                                            </div>
                                                                                        </div>
                                                                                        <?php
                                    }
                                } else {
                                    echo "<h3 class='empty'>Your cart is empty</h3>";

                                }
                            }
                            ?>
                        </div>
                        <div class="grand-total">
                            <span>total amount payable:</span>
                            $<?= $grand_total; ?>/-

                     </div>     
            
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