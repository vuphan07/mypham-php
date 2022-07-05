<?php include 'views/fontend/common/head.php' ?>
<?php if (isset($_SESSION['message_response'])) {
    $message = $_SESSION['message_response'];
    echo "<script>
            window.onload = function () { alert('${message}'); }
</script>";
} ?>
<?php unset($_SESSION['message_response']); ?>

<body>
    <?php include 'views/fontend/common/header.php' ?>
    <!--================Cart Table Area =================-->
    <section class="contact_form_area p_100">
        <div class="container">
            <div class="main_title">
                <h2>Phản hồi</h2>
                <h5>Hãy cho chúng tôi phản hồi của bạn về cửa hàng</h5>
            </div>
            <div class="row">
                <div class="col-lg-7">
                    <form class="row contact_us_form" action="?controller=contact&action=store" method="post" id="contactForm" novalidate="novalidate">
                        <div class="form-group col-md-6">
                            <input type="text" class="form-control" id="name" name="name" placeholder="Your name">
                        </div>
                        <div class="form-group col-md-6">
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address">
                        </div>
                        <div class="form-group col-md-12">
                            <textarea class="form-control" name="message" id="message" rows="1" placeholder="Wrtie message"></textarea>
                        </div>
                        <div class="form-group col-md-12">
                            <button type="submit" value="submit" class="btn order_s_btn form-control">submit now</button>
                        </div>
                    </form>
                </div>
                <div class="col-lg-4 offset-md-1">
                    <div class="contact_details">
                        <div class="contact_d_item">
                            <h3>Address :</h3>
                            <p>54B, Tailstoi Town 5238 <br /> La city, IA 522364</p>
                        </div>
                        <div class="contact_d_item">
                            <h5>Phone : <a href="tel:01372466790">01372.466.790</a></h5>
                            <h5>Email : <a href="mailto:rockybd1995@gmail.com">rockybd1995@gmail.com</a></h5>
                        </div>
                        <div class="contact_d_item">
                            <h3>Opening Hours :</h3>
                            <p>8:00 AM – 10:00 PM</p>
                            <p>Monday – Sunday</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require 'views/fontend/common/footer.php' ?>