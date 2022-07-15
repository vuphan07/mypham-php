<?php include 'views/fontend/common/head.php' ?>
<?php $orders = $orders['data'] ?>

<body>
    <?php include 'views/fontend/common/header.php' ?>
    <?php count($productsSlide['data']) > 0 ? include 'views/fontend/common/slide.php' : '' ?>
    <!--================Cart Table Area =================-->
    <div style="height:50px;"></div>
    <section class="cart_table_area p_100">
        <div class="container">
            <div class="table-responsive">
                <table id="customers">
                    <thead>
                        <tr>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($orders)) {
                            foreach ($orders as &$value) { ?>
                                <tr>
                                    <td><?= $value['id'] ?></td>
                                    <td><?= $value['nameproduct'] ?></td>
                                    <td><?= $value['quantity'] ?></td>
                                    <td><?= $value['cost'] ?></td>
                                    <td><?= $value['namestatus'] ?></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="height:100px;"></div>
    </section>
    <?php require 'views/fontend/common/footer.php' ?>