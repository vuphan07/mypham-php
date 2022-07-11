<?php
if(isset($categories['data'])) {
    $listCategories = $categories['data'];
}else {
    $listCategories = [];
}

?>

<?php
if (isset($_SESSION['cart'])) {
    $totalCart = array_reduce($_SESSION['cart'], function ($sum, $item) {
        $sum += ($item['price'] - $item['discount']) * $item['quantity'];
        return $sum;
    });
} else {
    $totalCart = 0;
}

?>

<div class="header scrolling" id="myHeader">
    <div class="grid wide">
        <div class="header__top">
            <div class="navbar-icon">
                <span></span>
                <span></span>
                <span></span>
            </div>
            <a href="index.php" class="header__logo">
                <img src="public/assets/logo.png" alt="">
            </a>
            <form method="get">

                <div class="header__search">
                    <div class="header__search-wrap">
                        <input type="text" name="keysearch" class="header__search-input" placeholder="Tìm kiếm">
                        <a class="header__search-icon" href="#">
                            <button type="submit" style="background: transparent;border: none;outline: none;">
                                <i type="submit" class="fas fa-search"></i>
                            </button>
                        </a>
                    </div>
                </div>
            </form>

            <?php if (isset($_SESSION['user'])) { ?>

                <div class="header__account" style="width:300px;display:flex;justify-content: space-around;">
                    <a style="font-size: 16px; font-weight: bold;" href="#"><?= $_SESSION['user']['username'] ?></a>
                    <?php if ($_SESSION['user']['role'] == 'admin') { ?>
                        <a style="font-size: 16px; font-weight: bold;" href="admin.php">Trang quản trị</a>
                    <?php } ?>
                    <a style="font-size: 16px; font-weight: bold;" href="?controller=user&action=logout">Đăng xuất</a>
                </div>
            <?php } else { ?>
                <div class="header__account">
                    <a href="#my-Login" class="header__account-login">Đăng Nhập</a>
                    <a href="#my-Register" class="header__account-register">Đăng Kí</a>
                </div>
            <?php } ?>
            <!-- Cart -->
            <div class="header__cart have" href="#">
                <i class="fas fa-shopping-basket"></i>
                <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
                    <div class="header__cart-amount">
                        <?= count($_SESSION['cart']) ?>
                    </div>
                <?php } ?>
                <div class="header__cart-wrap">
                    <ul class="order__list">
                        <?php if (isset($_SESSION['cart'])) foreach ($_SESSION['cart'] as &$cart) { ?>
                            <li class="item-order">
                                <div class="order-wrap">
                                    <a href="index.php" class="order-img">
                                        <img src="<?= $cart['image'] ?>" alt="">
                                    </a>
                                    <div class="order-main">
                                        <a href="product.html" class="order-main-name"><?= $cart['name'] ?>đ</a>
                                        <div class="order-main-price"><?= $cart['quantity'] ?> x <?= $cart['price'] - $cart['discount'] ?>đ</div>
                                    </div>
                                    <a href="?controller=cart&action=destroy&id=<?= $cart['id'] ?>" class="order-close"><i class="far fa-times-circle"></i></a>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="total-money">
                        <?= $totalCart ?> đ
                    </div>
                    <a href="?controller=cart" class="btn btn--default cart-btn">Xem giỏ hàng</a>
                    <a href="?controller=cart" class="btn btn--default cart-btn orange">Thanh toán</a>
                    <!-- norcart -->
                    <!-- <img class="header__cart-img-nocart" src="http://www.giaybinhduong.com/images/empty-cart.png" alt=""> -->
                </div>
            </div>
        </div>
    </div>
    <!-- Menu -->
    <div class="header__nav">
        <ul class="header__nav-list">
            <li class="header__nav-item nav__search">
                <div class="nav__search-wrap">
                    <input class="nav__search-input" type="text" name="" id="" placeholder="Tìm sản phẩm...">
                </div>
                <div class="nav__search-btn">
                    <i class="fas fa-search"></i>
                </div>
            </li>
            <li class="header__nav-item authen-form">
                <a href="#" class="header__nav-link">Tài Khoản</a>
                <ul class="sub-nav">
                    <li class="sub-nav__item">
                        <a href="#my-Login" class="sub-nav__link">Đăng Nhập</a>
                    </li>
                    <li class="sub-nav__item">
                        <a href="#my-Register" class="sub-nav__link">Đăng Kí</a>
                    </li>
                </ul>
            </li>
            <li class="header__nav-item index">
                <a href="index.php" class="header__nav-link">Trang chủ</a>
            </li>
            <li class="header__nav-item">
                <a href="#" class="header__nav-link">Giới Thiệu</a>
            </li>
            <li class="header__nav-item">
                <a href="#" class="header__nav-link">Sản Phẩm</a>
                <div class="sub-nav-wrap grid wide">
                    <?php if (isset($categories) && isset($categories['data'])) {
                        foreach ($categories['data'] as &$category) { ?>
                            <ul class="sub-nav">
                                <li class="sub-nav__item">
                                    <a href="?category=<?= $category['id']  ?>" class="sub-nav__link"><?= $category['name'] ?></a>
                                </li>
                            </ul>
                    <?php  }
                    } ?>
                </div>
            </li>
        </ul>
    </div>


    <!-- Modal Form -->
    <div class="ModalForm">
        <div class="modal" id="my-Register">
            <a href="#" class="overlay-close"></a>
            <div class="authen-modal register">
                <h3 class="authen-modal__title">Đăng Kí</h3>
                <div class="form-group">
                    <label for="name" class="form-label">Họ Tên</label>
                    <input id="name" name="account" type="text" class="form-control">
                    <!-- <span class="form-message">Không hợp lệ !</span> -->
                </div>
                <div class="form-group" style="margin-top:12px;">
                    <label for="name" class="form-label">Số điện thoại</label>
                    <input id="phone" name="phone" type="text" class="form-control">
                    <!-- <span class="form-message">Không hợp lệ !</span> -->
                </div>
                <div class="form-group" style="margin-top:12px;">
                    <label for="email" class="form-label">Tài khoản Email *</label>
                    <input id="email" name="email" type="text" class="form-control">
                    <span class="form-message"></span>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Mật khẩu *</label>
                    <input id="password" name="password" type="text" class="form-control">
                    <span class="form-message"></span>
                </div>
                <div class="form-group">
                    <label for="confirmpassword" class="form-label">Nhập lại mật khẩu *</label>
                    <input id="confirmpassword" name="password" type="text" class="form-control">
                    <span class="form-message"></span>
                </div>
                <div class="authen__btns">
                    <div class="btn btn--default" onclick="handleRegister()">Đăng Kí</div>
                </div>
            </div>
        </div>
        <div class=" modal" id="my-Login">
            <a href="#" class="overlay-close"></a>
            <div class="authen-modal login">
                <h3 class="authen-modal__title">Đăng Nhập</h3>
                <div class="form-group">
                    <label for="account" class="form-label">Username</label>
                    <input id="username" name="username" type="text" class="form-control">
                    <!-- <span class="form-message">Tài khoản không chính xác !</span> -->
                </div>
                <div class="form-group" style="margin-top:12px;">
                    <label for="password" class="form-label">Mật khẩu *</label>
                    <input id="password_login" name="password" type="text" class="form-control">
                    <span class="form-message"></span>
                </div>
                <div class="authen__btns center">
                    <div class="btn btn--default" onclick="handleLogin()">Đăng Nhập</div>
                </div>
            </div>
        </div>
        <div class="up-top" id="upTop" onclick="goToTop()">
            <i class="fas fa-chevron-up"></i>
        </div>
    </div>

</div>