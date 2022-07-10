<?php include 'views/fontend/common/head.php' ?>

<body>
	<?php include 'views/fontend/common/header.php' ?>
	<?php count($products['data']) > 0 ? include 'views/fontend/common/slide.php' : '' ?>
	<!--================Welcome Area =================-->
	<!--Product Category -->
	<div class="main__tabnine">
		<div class="grid wide">
			<!-- Tab items -->
			<div class="tabs">
				<div class="tab-item active">
					Danh sách sản phâm
				</div>
				<div class="line"></div>
			</div>
			<!-- Tab content -->
			<!--  -->
			<div class="tab-content">
				<div class="tab-pane active">
					<div class="row">
						<?php
						if (count($products['data']) > 0) {
							foreach ($products['data'] as &$product) { ?>
								<div class="col l-2 m-4 s-6">
									<div class="product">
										<div class="product__avt" style="background-image: url(<?= $product['image'] ?>);">
										</div>
										<div class="product__info">
											<h3 class="product__name"><?= $product['name'] ?></h3>
											<div class="product__price">
												<div class="price__old">
													<?= $product['price'] ?>
												</div>
												<div class="price__new"><?= (float)$product['price'] - (float)$product['discount'] ?> <span class="price__unit">đ</span></div>
											</div>
											<div class="product__sale">
												<span class="product__sale-percent"><?= (float)$product['discount'] / (float)$product['price'] * 100 ?>%</span>
												<span class="product__sale-text">Giảm</span>
											</div>
										</div>
										<a href="product.html" class="viewDetail">Xem chi tiết</a>
										<button style="outline: none;border:none;" onclick="addToCart(<?= $product['id'] ?>)" class="addToCart">Thêm vào giỏ</button>
									</div>
								</div>
							<?php }
						} else { ?>
							<div style="height:50vh;display:flex;flex-direction: column;justify-content: center;">
								<h1>Sản phẩm trống</h1>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- HightLight  -->
	<div class="main__policy">
		<div class="row">
			<div class="col l-3 m-6">
				<div class="policy bg-1">
					<img src="public/assets/img/policy/policy1.png" class="policy__img"></img>
					<div class="policy__info">
						<h3 class="policy__title">GIAO HÀNG MIỄN PHÍ</h3>
						<p class="policy__description">Cho đơn hàng từ 300K</p>
					</div>
				</div>
			</div>
			<div class="col l-3 m-6">
				<div class="policy bg-2">
					<img src="public/assets/img/policy/policy2.png" class="policy__img"></img>
					<div class="policy__info">
						<h3 class="policy__title">ĐỔI TRẢ HÀNG</h3>
						<p class="policy__description">Trong 3 ngày đầu tiên</p>
					</div>
				</div>
			</div>
			<div class="col l-3 m-6">
				<div class="policy bg-1">
					<img src="public/assets/img/policy/policy3.png" class="policy__img"></img>
					<div class="policy__info">
						<h3 class="policy__title">HÀNG CHÍNH HÃNG</h3>
						<p class="policy__description">Cam kết chất lượng</p>
					</div>
				</div>
			</div>
			<div class="col l-3 m-6">
				<div class="policy bg-2">
					<img src="public/assets/img/policy/policy4.png" class="policy__img"></img>
					<div class="policy__info">
						<h3 class="policy__title">TƯ VẤN 24/24</h3>
						<p class="policy__description">Giải đáp mọi thắc mắc</p>
					</div>
				</div>
			</div>

		</div>
	</div>
	</div>

	<?php require 'views/fontend/common/footer.php' ?>