<?php include 'views/fontend/common/head.php' ?>
<?php $orders = $orders['data'] ?>

<body>
    <?php include 'views/fontend/common/header.php' ?>
    <!--================Cart Table Area =================-->

    <section class="cart_table_area p_100">
        <div class="container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Số lượng</th>
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
                                    <td><?= $value['namestatus'] ?></td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <?php require 'views/fontend/common/footer.php' ?>