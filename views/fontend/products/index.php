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
                            <h2>Danh sách <b>Sản phẩm</b></h2>
                        </div>
                        <div class="col-sm-8">
                            <div class="search-box">
                                <button type="button" class="btn btn-success">
                                    <a style="color:#fff;" class="delete" title="Tạo mới" href="#myModalCreate" class="trigger-btn" data-toggle="modal" data-toggle="tooltip">Thêm sản phẩm</a>
                                </button>
                                <button type="button" class="btn btn-success">
                                    <a style="color:#fff;" class="delete" title="Tạo mới" href="#myModalCreatecategory" class="trigger-btn" data-toggle="modal" data-toggle="tooltip">Thêm thể loại</a>
                                </button>
                                <button type="button" class="btn btn-success">
                                    <a style="color:#fff;" class="delete" title="Tạo mới" href="#modeleditcategorys" class="trigger-btn" data-toggle="modal" data-toggle="tooltip">update thể loại</a>
                                </button>
                                <button type="button" class="btn btn-success">
                                    <a style="color:#fff;" class="delete" title="Tạo mới" href="#modeldeletecategorys" class="trigger-btn" data-toggle="modal" data-toggle="tooltip">xóa thể loại</a>
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
                                    <td>
                                        <a href="#myModalCreate" data-toggle="modal" class="edit" onclick="setIdUpdate(<?= $value['id'] ?>)" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                        <a onclick="setIdProductDelete(<?= $value['id'] ?>)" class="delete" title="Delete" href="#myModal" class="trigger-btn" data-toggle="modal" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- model confirm  -->
    <div id="myModal" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <div class="modal-header flex-column">
                    <div class="icon-box">
                        <i class="material-icons">&#xE5CD;</i>
                    </div>
                    <h4 class="modal-title w-100">Are you sure?</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body">
                    <p>Do you really want to delete these records? This process cannot be undone.</p>
                </div>
                <div class="modal-footer justify-content-center">
                    <button onclick="handleCancelDelete()" type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button onclick="handleDelete()" type="button" class="btn btn-danger">Delete</button>
                </div>
            </div>
        </div>
    </div>
    <!-- model -->
    <div id="myModalCreate" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <form method="post" action="?controller=product&action=create" enctype="multipart/form-data">
                    <input type="text" style="display:none;" id="productId" name="idproduct" class="form-control">

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">name</label>
                        <input type="text" required name="name" class="form-control">
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100">price</label>
                        <input type="number" min="0" required name="price" class="form-control">
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100">quantity</label>
                        <input type="number" required name="quantity" class="form-control">
                    </div>

                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100">category </label>
                        <select class="form-control" name="category_id">
                            <?php if (isset($categories) && isset($categories['data'])) {
                                foreach ($categories['data'] as &$category) { ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100">description </label>
                        <input type="text" required name="description" class="form-control">
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100">discount </label>
                        <input type="text" required name="discount" class="form-control">
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100">image </label>
                        <input type="file" required name="image" id="fileToUpload" class="form-control">
                    </div>
                    <button style="width:100%; margin: 0 auto; background-color:#f195b2; color:#fff;" type="submit" class="btn">Tạo</button>
                </form>
            </div>
        </div>
    </div>
    <!-- model create category -->
    <div id="myModalCreatecategory" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <form method="post" action="?controller=category&action=store">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">name</label>
                        <input type="text" required name="name" class="form-control">
                    </div>
                    <button style="width:100%; margin: 0 auto; background-color:#f195b2; color:#fff;" type="submit" class="btn">Tạo</button>
                </form>
            </div>
        </div>
    </div>
    <!-- edit category -->

    <div id="modeleditcategorys" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <form method="post" action="?controller=category&action=update">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">category</label>
                        <select class=" form-control" name="categoryid">
                            <?php if (isset($categories) && isset($categories['data'])) {
                                foreach ($categories['data'] as &$category) { ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">new value</label>
                        <input type="text" required name="newvalue" class="form-control">
                    </div>
                    <button style="width:100%; margin: 0 auto; background-color:#f195b2; color:#fff;" type="submit" class="btn">Cập nhật</button>
                </form>
            </div>
        </div>
    </div>
    <!-- model delete category -->
    <div id="modeldeletecategorys" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
                <form method="post" action="?controller=category&action=delete">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minWidth-100 ">category</label>
                        <select class=" form-control" name="categoryid">
                            <?php if (isset($categories) && isset($categories['data'])) {
                                foreach ($categories['data'] as &$category) { ?>
                                    <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
                            <?php }
                            } ?>
                        </select>
                    </div>
                    <button style="width:100%; margin: 0 auto; background-color:#f195b2; color:#fff;" type="submit" class="btn">Xóa</button>
                </form>
            </div>
        </div>
    </div>

    <!-- model view category -->
    <div id="modelviewcategory" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">
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
                                    <td>
                                        <a href="#myModalCreate" data-toggle="modal" class="edit" onclick="setIdUpdate(<?= $value['id'] ?>)" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                        <a onclick="setIdProductDelete(<?= $value['id'] ?>)" class="delete" title="Delete" href="#myModal" class="trigger-btn" data-toggle="modal" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script>
    const setIdProductDelete = (id) => {
        localStorage.setItem("productIdDelete", id)
    }
    const handleDelete = () => {
        const id = localStorage.getItem("productIdDelete");
        if (!id) return;
        $.post(`?controller=product&action=delete`, {
            method: "POST",
            data: {
                id,
            },
        }).then(res => {
            if (res) {
                localStorage.removeItem("productIdDelete")
                window.location.reload();
            }
        }).catch(err => {
            console.log(err)
        })
    }
    const handleCancelDelete = () => {
        localStorage.removeItem("productIdDelete")
    }

    const setIdUpdate = (value) => {
        $('#productId').val(value)
    }
</script>

</html>