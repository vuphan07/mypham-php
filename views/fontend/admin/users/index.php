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
                            <h2>Danh sách <b>User</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name </th>
                            <th>email</th>
                            <th>phone </th>
                            <th>Tổng số đơn hàng</th>
                            <th>Tổng giá trị</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($users['data']) && count($users['data']) > 0) {
                            foreach ($users['data'] as $key => $value) {
                                if ($value['role'] !== 'admin') { ?>
                                    <tr>
                                        <td><?= $key + 1 ?></td>
                                        <td><?= $value['username'] ?></td>
                                        <td><?= $value['email'] ?></td>
                                        <td><?= $value['phone'] ?></td>
                                        <td><?= $value['totalorders'] ?></td>
                                        <td><?= $value['totalcost'] . "$" ?></td>
                                        <td>
                                            <a href="#modaledituser" data-toggle="modal" onclick="setIdUpdate(<?= $value['id'] ?>)" class="edit" title="Edit" data-toggle="tooltip"><i class="material-icons">&#xE254;</i></a>
                                            <a onclick="setIdUserDelete(<?= $value['id'] ?>)" class="delete" title="Delete" href="#myModal" class="trigger-btn" data-toggle="modal" data-toggle="tooltip"><i class="material-icons">&#xE872;</i></a>
                                        </td>
                                    </tr>
                        <?php }
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- model -->
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
    <!-- model edit user -->
    <div id="modaledituser" class="modal fade">
        <div class="modal-dialog modal-confirm">
            <div class="modal-content">

                <form method="post" action="?controller=user&action=update">
                    <input type="text" style="display:none;" id="userid" name="userid" class="form-control" aria-describedby="emailHelp">
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minwidth-100">Email</label>
                        <input type="email" required name="email" class="form-control" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minwidth-100">Phone</label>
                        <input type="text" required name="phone" class="form-control" aria-describedby="emailHelp">
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <label class="form-label minwidth-100">Password</label>
                        <input type="password" required name="password" class="form-control">
                    </div>
                    <button style="width:100%; margin: 0 auto; background-color:#f195b2; color:#fff;" type="submit" class="btn">cập nhật
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
<script>
    const setIdUserDelete = (id) => {
        localStorage.setItem("itemDelete", id)
    }
    const handleDelete = () => {
        const id = localStorage.getItem("itemDelete");
        if (!id) return;
        $.post(`?controller=user&action=delete`, {
            method: "POST",
            data: {
                id,
            },
        }).then(res => {
            localStorage.removeItem("itemDelete")
            window.location.reload();
        }).catch(error => {
            localStorage.removeItem("itemDelete")
            window.location.reload();
        })
    }
    const handleCancelDelete = () => {
        localStorage.removeItem("itemDelete")
    }
    const setIdUpdate = (value) => {
        $('#userid').val(value)
    }
</script>

</html>