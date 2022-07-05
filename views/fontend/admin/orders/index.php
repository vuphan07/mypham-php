<!DOCTYPE html>
<html lang="en">
<?php require('views/fontend/common/headAdmin.php') ?>

<body>
    <?php require('views/fontend/common/navbarAdmin.php') ?>
    <!-- end navbar -->
    <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-8">
                            <h2>Danh sách <b>Đơn hàng</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Mã đơn hàng</th>
                            <th scope="col">Sản phẩm</th>
                            <th scope="col">Số lượng</th>
                            <th scope="col">Giá</th>
                            <th scope="col">Phương thức thanh toán</th>
                            <th scope="col">Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($orders)) {
                            foreach ($orders['data'] as &$value) { ?>
                                <tr>
                                    <td><?= $value['id'] ?></td>
                                    <td><?= $value['nameproduct'] ?></td>
                                    <td><?= $value['quantity'] ?></td>
                                    <td><?= $value['cost'] . "$" ?></td>
                                    <td><?= $value['nameshipping'] ?></td>
                                    <td><?= $value['namestatus'] ?></td>
                                    <td>
                                        <a href="#modeleditstatus" data-toggle="modal" onclick="setIdUpdate(<?= $value['id'] ?>)" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                    </td>
                            <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- model create category -->
    <div id="modeleditstatus" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <form method="post" action="?controller=order&action=update">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">status</label>
                        <input type="text" id="orderId" name="id" style="display: none;" />
                        <select class=" form-control" name="status">
                            <?php if (isset($statusorders) && isset($statusorders['data'])) {
                                foreach ($statusorders['data'] as &$statusorder) { ?>
                                    <option value="<?= $statusorder['id'] ?>"><?= $statusorder['name'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <button style="width:100%; margin: 0 auto; background-color:#f195b2; color:#fff;" type="submit" class="btn">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    const setIdUpdate = (value) => {
        $('#orderId').val(value)
    }
</script>

</html>