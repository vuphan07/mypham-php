<?php include 'views/fontend/common/head.php' ?>
<?php include 'views/fontend/common/header.php' ?>
<?php if (isset($_SESSION['cart'])) {
    $totalCart = array_reduce($_SESSION['cart'], function ($sum, $item) {
        $sum += ($item['price'] - $item['discount']) * $item['quantity'];
        return $sum;
    });
} else {
    $totalCart = 0;
} ?>

<body>
    <?php count($products['data']) > 0 ? include 'views/fontend/common/slide.php' : '' ?>
    <div class="main">
        <div class="grid wide">
            <h3 class="main__notify">
            </h3>
            <div class="row">
                <div class="col l-8 m-12 s-12">
                    <div class="main__cart">
                        <div class="row title">
                            <div class="col l-4 m-4 s-8">Sản phẩm</div>
                            <div class="col l-2 m-2 s-0">Giá</div>
                            <div class="col l-2 m-2 s-0">Số lượng</div>
                            <div class="col l-2 m-2 s-4">Tổng</div>
                            <div class="col l-1 m-1 s-0">Xóa</div>
                        </div>
                        <?php if (isset($_SESSION['cart'])) foreach ($_SESSION['cart'] as &$cart) { ?>
                            <div class="row item">
                                <div class="col l-4 m-4 s-8">
                                    <div class="main__cart-product">
                                        <img src="<?= $cart['image'] ?>" alt="">
                                        <div class="name"><?= $cart['name'] ?></div>
                                    </div>
                                </div>
                                <div class="col l-2 m-2 s-0">
                                    <div class="main__cart-price"><?= $cart['price'] - $cart['discount'] ?> đ</div>
                                </div>
                                <div class="col l-2 m-2 s-0">
                                    <div class="buttons_added">
                                        <a href="?controller=cart&action=delete&id=<?= $cart['id'] ?>">
                                            <input class="minus is-form" type="button" value="-" onclick="minusProduct()">
                                        </a>
                                        <input aria-label="quantity" class="input-qty" max="10" min="1" name="" type="number" value="<?= $cart['quantity'] ?>">
                                        <a href="?controller=cart&action=store&id=<?= $cart['id'] ?>">
                                            <input class="minus is-form" type="button" value="+" onclick="minusProduct()">
                                        </a>
                                    </div>
                                </div>
                                <div class="col l-2 m-2 s-4">
                                    <div class="main__cart-price"><?= $cart['quantity'] * ($cart['price'] - $cart['discount'])  ?> đ</div>
                                </div>
                                <div class="col l-1 m-1 s-0">
                                    <span class="main__cart-icon">
                                        <i class="far fa-times-circle "></i>
                                    </span>
                                </div>
                            </div>
                        <?php } ?>
                        <div onclick="(()=>window.location.reload())()" class="btn btn--default">
                            Cập nhật giỏ hàng
                        </div>
                    </div>
                </div>
                <div class="col l-4 m-12 s-12">
                    <div class="main__pay">
                        <div class="main__pay-title">Thanh toán</div>
                        <div class="pay-info">
                            <div class="main__pay-text">
                                Tổng phụ</div>
                            <div class="main__pay-price">
                                <?= $totalCart ?> ₫
                            </div>
                        </div>
                        <div class="pay-info">
                            <div class="main__pay-text">
                                Giao hàng
                            </div>
                            <div class="main__pay-text">
                                Giao hàng miễn phí
                            </div>
                        </div>
                        <div class="pay-info" id='row-discount-price'>

                        </div>
                        <div class="pay-info">
                            <div class="main__pay-text">
                                Tổng thành tiền</div>
                            <div id="row-total-price" class="main__pay-price">
                                <?= $totalCart ?> ₫
                            </div>
                        </div>
                        <div class="btn btn--default orange" onclick="checkout(<?= isset($_SESSION['user']) ?  $_SESSION['user']['id'] : null ?>)">Tiến hành thanh toán</div>
                        <div class="main__pay-title">Phiếu ưu đãi</div>
                        <input id="input-discount-code" type="text" class="form-control">
                        <div class="btn btn--default" onclick="checkCode(<?= $totalCart ?>)">Áp dụng</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php require 'views/fontend/common/footer.php' ?>