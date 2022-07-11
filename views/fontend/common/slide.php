<div class="main__slice">
    <div class="slider">
        <?php if (isset($productsSlide) && isset($productsSlide['data'])) { ?>
            <?php $i=0; foreach ($productsSlide['data'] as &$productValue) {if($i<3){ ?>
                <div class="slide active" style="background-image:url(<?= $productValue['image'] ?>)">

                    <div class="container">
                        <div class="caption">
                            <h1>Giảm giá <?= (float)$productValue['discount'] / (float)$productValue['price'] * 100 ?>%</h1>
                            <p>Giảm giá cực sốc trong tháng 7!</p>
                            <a href="listProduct.html" class="btn btn--default">Xem ngay</a>
                        </div>
                    </div>
                </div>
            <?php $i++;} } ?>
        <?php } ?>
    </div>
    <!-- controls  -->
    <div class="controls">
        <div class="prev">
            <i class="fas fa-chevron-left"></i>
        </div>
        <div class="next">
            <i class="fas fa-chevron-right"></i>
        </div>
    </div>
    <!-- indicators -->
    <div class="indicator">
    </div>
</div>