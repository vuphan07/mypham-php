<?php include 'views/fontend/common/head.php' ?>
<?php include 'views/fontend/common/header.php' ?>
<?php $totalCart = array_reduce($_SESSION['cart'], function ($sum, $item) {
    $sum += $item['price'] * $item['quantity'];
    return $sum;
}) ?>
<div class="card">
    <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
        <div class="row">
            <div class="col-md-8 cart">
                <div class="title">
                    <div class="row">
                        <div class="col">
                            <h4><b>Shopping Cart</b></h4>
                        </div>
                        <div class="col align-self-center text-right text-muted"><?= count($_SESSION['cart']) ?> items</div>
                    </div>
                </div>
                <?php foreach ($_SESSION['cart'] as &$cart) { ?>
                    <div class="row border-top border-bottom">
                        <div class="row main align-items-center">
                            <div class="col-2"><img class="img-fluid" src="<?= $cart['image'] ?>"></div>
                            <div class="col">
                                <!-- <div class="row text-muted"><?= $cart['name'] ?></div> -->
                                <div class="row"><?= $cart['name'] ?></div>
                            </div>
                            <div class="col">
                                <a href="?controller=cart&action=delete&id=<?= $cart['id'] ?>">-</a><a href="#" class="border"><?= $cart['quantity'] ?></a><a href="?controller=cart&action=store&id=<?= $cart['id'] ?>">+</a>
                            </div>
                            <div class="col">&dollar; <?= $cart['price'] * $cart['quantity'] ?> <span class="close"><a href="?controller=cart&action=destroy&id=<?= $cart['id'] ?>">&#10005;</a></span></div>
                        </div>
                    </div>
                <?php } ?>
                <div class="back-to-shop"><a href="./index.php">&leftarrow;</a><span class="text-muted">Back to shop</span></div>
            </div>
            <div class="col-md-4 summary">
                <div>
                    <h5><b>Summary</b></h5>
                </div>
                <hr>
                <?php
                foreach ($_SESSION['cart'] as $key => $value) { ?>
                    <div class="row">

                        <div class="col" style="padding-left:0;"><?= $value['name'] ?></div>
                        <div class="col text-right">&dollar;
                            <?= $value['price'] * $value['quantity'] ?>
                        </div>

                    </div>
                <?php
                } ?>

                <p>phương thức thanh toán</p>
                <select id="order-shipping">
                    <?php foreach ($shippings['data'] as &$value) { ?>
                        <option class="text-muted" name="shipping" value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
                    <?php } ?>
                </select>
                <p>Địa chỉ</p>
                <div class="input-group mb-3">
                    <input id="input-address" name="address" type="text" class="form-control" placeholder="address" aria-label="Recipient's username" aria-describedby="basic-addon2">
                </div>
                <p>Mã giảm giá</p>
                <div class="input-group mb-3">
                    <input id="input-discount-code" name="code" type="text" class="form-control" placeholder="Enter your code" aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button type="button" class="input-group-text" onclick="checkCode(<?= $totalCart ?>)">áp dụng</button>
                    </div>
                </div>
                <div id='row-discount-price'>

                </div>

                <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                    <div class="col">Tổng giá</div>
                    <div id='row-total-price' class="col text-right">&dollar;
                        <?= $totalCart ?></div>
                </div>
                <button class="btn" onclick="checkout(<?= isset($_SESSION['user']) ?  $_SESSION['user']['id'] : null ?>)">CHECKOUT</button>
            </div>
        </div>
    <?php } else {
        echo "<div style='margin: 100px auto 0 auto; height:20vh;' >Giỏ hàng trống</div>";
    } ?>
</div>
<?php require 'views/fontend/common/footer.php' ?>