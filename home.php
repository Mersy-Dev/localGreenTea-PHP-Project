<?php
include 'components/connection.php';
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
    <title>Green Coffee - home page</title>
</head>

<body>
    <?php include 'components/header.php'; ?>

    <div class="main">
        <section class="home-section">
            <div class="slider">
                <div class="slider__slider slide1">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Green Tea Coffee International</h1>  
                        <p>Green Coffee is a coffee  and coffee powder. We sell coffee beans and coffee powder with the best quality and </p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>

                <!-- slide end -->

                <div class="slider__slider slide2">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Welcome to my shop</h1>
                        <p>Green Coffee is a coffee  and coffee powder. We sell coffee beans and coffee powder with the best quality and </p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>

                <!-- slide end -->

                <div class="slider__slider slide3">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Green Coffee</h1>
                        <p>Green Coffee is a coffes and coffee powder. We sell coffee beans and coffee powder with the best quality and </p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>

                <!-- slide end -->

                <div class="slider__slider slide4">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Green Coffee</h1>
                        <p>Green Coffee is a coffee  and coffee powder. We sell coffee beans and coffee powder with the best quality and </p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>

                <!-- slide end -->

                <div class="slider__slider slide5">
                    <div class="overlay"></div>
                    <div class="slide-detail">
                        <h1>Green Coffee</h1>
                        <p>Green Coffee is a coffee and coffee powder. We sell coffee beans and coffee powder with the best quality and </p>
                        <a href="view_products.php" class="btn">shop now</a>
                    </div>
                    <div class="hero-dec-top"></div>
                    <div class="hero-dec-bottom"></div>
                </div>

                <!-- slide end -->
                <div class="left-arrow"><i class="bx bxs-left-arrow"></i></div>
                <div class="right-arrow"><i class="bx bxs-right-arrow"></i></div>
            </div>
              

        </section>
        <!-- home slider end -->
        <section class="thumb">
            <div class="box-container">
                <div class="box">
                    <img src="img/thumb2.jpg" alt="">
                    <h3>green tea</h3>
                    <p>Lorem, ipsum dolor sit a, unde obcaecati. Aperiam dolor officia.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>

                <div class="box">
                    <img src="img/thumb0.jpg" alt="">
                    <h3>lemon coffee</h3>
                    <p>Lorem, ipsum dolor sit ame, unde obcaecati. Aperiam dolor officia.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>

                <div class="box">
                    <img src="img/thumb1.jpg" alt="">
                    <h3>green tea</h3>
                    <p>Lorem, ipsum dolor sit amet unde obcaecati. Aperiam dolor officia.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>

                <div class="box">
                    <img src="img/thumb.jpg" alt="">
                    <h3>green coffee</h3>
                    <p>Lorem, ipsum dolor sit unde obcaecati. Aperiam dolor officia.</p>
                    <i class="bx bx-chevron-right"></i>
                </div>
            </div>
        </section>

        <section class="container">
            <div class="box-container">
                <div class="box">
                    <img src="img/about-us.jpg" alt="">
                </div>
                <div class="box">
                    <img src="img/download.png" alt="">
                    <span>healthy tea</span>
                    <h1>save up to 50% off</h1>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Nihil sa exercitationem commodi veritatis nam!</p>
                </div>
            </div>
        </section>

        <section class="shop">
            <div class="title">
                <img src="img/download.png" alt="">
                <h1>Trending Product</h1>
            </div>

            <div class="row">
                <img src="img/about.jpg" alt="">
                <div class="row-details">
                    <img src="img/basil.jpg" alt="">
                    <div class="top-footer">
                        <h1>a cup of green tea makes you healthy</h1>
                    </div>
                </div>
            </div>

            <div class="box-container">
                <div class="box">
                    <img src="img/card.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>

                <div class="box">
                    <img src="img/card0.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>

                </div>

                <div class="box">
                    <img src="img/card1.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>

                <div class="box">
                    <img src="img/card2.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>

                <div class="box">
                    <img src="img/10.jpg" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
                </div>

                <div class="box">
                    <img src="img/6.webp" alt="">
                    <a href="view_products.php" class="btn">shop now</a>
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