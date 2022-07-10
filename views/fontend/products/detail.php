<?php include 'views/fontend/common/head.php' ?>
<?php include 'views/fontend/common/header.php' ?>

<body>
    <?php count($products['data']) > 0 ? include 'views/fontend/common/slide.php' : '' ?>
    <div class="main">
        <div class="grid wide">
            <div class="productInfo">
                <div class="row">
                    <div class="col l-5 m-12 s-12">
                        <img style="width: 100%;" src="<?= $product['data'][0]['image'] ?>"/>
                    </div>
                    <div class="col l-7 m-12s s-12 pl">
                        <h3 class="productInfo__name">
                        <?= $product['data'][0]['name'] ?>
                        </h3>
                        <div class="productInfo__price">
                            <?= $product['data'][0]['price'] ?> <span class="priceInfo__unit">đ</span>
                            ->
                            <?= $product['data'][0]['price'] - $product['data'][0]['discount'] ?> <span class="priceInfo__unit">đ</span>
                        </div>
                        <div class="productInfo__description">
                            <span><?= $product['data'][0]['description'] ?></span>
                        </div>

                        <div class="productInfo__addToCart">
                            <div class="buttons_added">
                                <input class="minus is-form" type="button" value="-" onclick="minusProduct()">
                                <input aria-label="quantity" class="input-qty" max="10" min="1" name="" type="number" value="1">
                                <input class="plus is-form" type="button" value="+" onclick="plusProduct()">
                            </div>
                            <div class=" btn btn--default orange ">Thêm vào giỏ</div>
                        </div>
                        <div class="productIndfo__category ">
                            <p class="productIndfo__category-text"> Số lượng đã bán : <?= $product['data'][0]['sold'] ?></p>
                            <p class="productIndfo__category-text"> Số lượng trong kho : <?=  $product['data'][0]['quantity'] ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <?php require 'views/fontend/common/footer.php' ?>