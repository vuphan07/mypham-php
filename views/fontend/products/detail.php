<?php include 'views/fontend/common/head.php' ?>
<?php include 'views/fontend/common/header.php' ?>

<body>
    <section class="banner_area">
        <div class="container">
            <div class="banner_text">
                <h3>Product Details</h3>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Product Details</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!--================End Main Header Area =================-->

    <!--================Product Details Area =================-->
    <section class="product_details_area p_100">
        <div class="container">
            <?php if ($product['data'] && count($product['data']) > 0) { ?>
                <div class="row product_d_price">
                    <div class="col-lg-6">
                        <div class="product_img"><img class="img-fluid" src="<?= $product['data'][0]['image']?>" alt=""></div>
                    </div>
                    <div class="col-lg-6">
                        <div class="product_details_text">
                            <h4><?= $product['data'][0]['name'] ?></h4>
                            <p><?= $product['data'][0]['description'] ?></p>
                            <h5>Price :<span><?= "$" . $product['data'][0]['price'] ?></span></h5>
                            <div class="quantity_box">
                                <label for="quantity">Quantity :</label>
                                <input type="text" placeholder="1" id="quantity">
                            </div>
                            <a class="pink_more" href="#">Add to Cart</a>
                        </div>
                    </div>
                </div>
            <?php } else { ?>
                <h1>Không tìm thấy sản phẩm</h1>
            <?php } ?>
        </div>
    </section>
    <!--================End Product Details Area =================-->
    <section class="similar_product_area p_100">
        <div class="container">
            <?php if ($products['data'] && count($products['data']) > 0) { ?>
                <div class="main_title">
                    <h2>Similar Products</h2>
                </div>
                <div class="row similar_product_inner">
                    <?php foreach ($products['data'] as &$value) { ?>
                        <div class="col-lg-3 col-md-4 col-6">
                            <div class="cake_feature_item">
                                <div class="cake_img" onclick="redirectProductDetails(<?= $value['id'] ?>)">
                                    <img src="<? $value['image']?>" alt="">
                                </div>
                                <div class="cake_text">
                                    <h4><?= "$" .  $value['price']  ?></h4>
                                    <h3><?= "$" .  $value['name']  ?></h3>
                                    <a class="pest_btn" href="#">Add to cart</a>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>
    <?php require 'views/fontend/common/footer.php' ?>