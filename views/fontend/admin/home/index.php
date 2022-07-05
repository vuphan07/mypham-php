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
                        <div class="col-sm-4">
                            <h2>Danh sách <b>Sản phẩm đã bán</b></h2>
                        </div>
                        <div class="col-sm-8">
                            <div class="search-box">
                                <button type="button" class="btn btn-success">
                                    <a style="color:#fff;" class="delete" title="Tạo mới" href="#creatediscount" class="trigger-btn" data-toggle="modal" data-toggle="tooltip">Thêm mã giảm giá</a>
                                </button>
                                <button type="button" class="btn btn-success">
                                    <a style="color:#fff;" class="delete" title="Tạo mới" href="#modeleditdiscounts" class="trigger-btn" data-toggle="modal" data-toggle="tooltip">Sửa mã giảm giá</a>
                                </button>
                                <button type="button" class="btn btn-success">
                                    <a style="color:#fff;" class="delete" title="Tạo mới" href="#modeldeletediscounts" class="trigger-btn" data-toggle="modal" data-toggle="tooltip">Xóa mã giảm giá</a>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name </th>
                            <th>img</th>
                            <th>đơn giá </th>
                            <th>số lượng</th>
                            <th>đã bán</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($products['data']) && count($products['data']) > 0) {
                            foreach ($products['data'] as $key => $value) { ?>
                                <tr>
                                    <td><?= $key + 1 ?></td>
                                    <td><?= $value['name'] ?></td>
                                    <td>
                                        <div>
                                            <img style="width:100px;height:100px;" class="img-fluid" src="<?= $value['image'] ?>" />
                                        </div>
                                    </td>
                                    <td><?= $value['price'] . "$" ?></td>
                                    <td><?= $value['quantity'] ?></td>
                                    <td><?= $value['sold'] ?></td>
                                </tr>
                        <?php }
                        } ?>
                        <tr>
                            <td></td>
                            <td></td>
                            <td>
                            </td>
                            <td></td>
                            <td>Tổng</td>
                            <td><?= $total['data'][0]['total'] . "$" ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- model add ma giảm giá -->
    <div id="creatediscount" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <form method="post" action="?controller=discount&action=store" enctype="multipart/form-data">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">mã</label>
                        <input type="text" required name="id" class="form-control">
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100">value</label>
                        <input type="number" min="0" required name="value" class="form-control">
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100">số lượng</label>
                        <input type="number" required name="count" class="form-control">
                    </div>
                    <button style="width:100%; margin: 0 auto; background-color:#f195b2; color:#fff;" type="submit" class="btn">Tạo</button>
                </form>
            </div>
        </div>
    </div>
    <!-- model edit disconts -->
    <div id="modeleditdiscounts" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <form method="post" action="?controller=discount&action=update">
                    <input type="text" style="display: none;" id="discountsId" name="id" class="form-control">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">mã</label>
                        <select class=" form-control" id="discountsIdChange" onchange="onchangeSelect()">
                            <?php if (isset($discounts) && isset($discounts['data'])) {
                                foreach ($discounts['data'] as &$discount) { ?>
                                    <option value="<?= $discount['value'] ?>"><?= $discount['id'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">giá trị</label>
                        <input disabled type="text" id="valueDiscounts" required name="value" class="form-control">
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">giá trị mới</label>
                        <input type="text" required name="newvalue" class="form-control">
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">số lượng</label>
                        <input type="text" required name="count" class="form-control">
                    </div>
                    <button style="width:100%; margin: 0 auto; background-color:#f195b2; color:#fff;" type="submit" class="btn">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
    <!-- model delete discount -->
    <div id="modeldeletediscounts" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <form method="post" action="?controller=discount&action=delete">
                    <input type="text" style="display: none;" id="IdDiscountDelete" name="id" class="form-control">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">mã</label>
                        <select class=" form-control" id="discountIdDelete" onchange="onchangeSelect2()">
                            <?php if (isset($discounts)) {
                                foreach ($discounts['data'] as &$discount) { ?>
                                    <option value="<?= $discount['value'] ?>"><?= $discount['id'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">giá trị</label>
                        <input disabled type="text" id="valueCurrentDiscount" required name="value" class="form-control">
                    </div>
                    <button style="width:100%; margin: 0 auto; background-color:#f195b2; color:#fff;" type="submit" class="btn">Xóa</button>
                </form>
            </div>
        </div>
    </div>
</body>
<script>
    const onchangeSelect = () => {
        $("#valueDiscounts").val($("#discountsIdChange").val());
        $("#discountsId").val($(`[value=${$("#discountsIdChange ").val()}]`)[0].innerText)
    }

    const onchangeSelect2 = () => {
        $("#valueCurrentDiscount").val($("#discountIdDelete").val());
        $("#IdDiscountDelete").val($(`[value=${$("#discountIdDelete").val()}]`)[0].innerText)
    }
</script>

</html>