const emailRegex =
  /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

const handleRegister = () => {
  const username = $("#name").val();
  const phone = $("#phone").val();
  const password = $("#password").val();
  const confirmpassword = $("#confirmpassword").val();
  const email = $("#email").val();
  if (!username || !password || !confirmpassword || !email || !phone) {
    alert("Vui lòng nhập đầy đủ thông tin");
    return;
  }
  if (!emailRegex.test(email)) {
    alert("Email không hợp lệ");
    return;
  }
  if (confirmpassword != password) {
    alert("Mật khẩu không khớp");
    return;
  }
  const data = {
    username,
    password,
    email,
    phone,
    confirmpassword,
  };

  $.post("?controller=user&action=register", {
    method: "POST",
    data,
  }).then((res) => {
    console.log(res);
    if (res === "success") {
      alert("Đăng kí thành công");
      window.location.href = "/mypham/#my-Login";
    } else {
      alert("Đăng kí thất bại");
    }
  });
};

const handleLogin = () => {
  const username = $("#username").val();
  const password = $("#password_login").val();
  if (!username || !password) {
    alert("Vui lòng nhập đầy đủ thông tin");
    return;
  }
  const data = {
    username,
    password,
  };

  $.post("?controller=user&action=login", {
    method: "POST",
    data,
  }).then((res) => {
    console.log(res);
    if (res === "success") {
      alert("Đăng nhập thành công");
      window.location.href = "/mypham";
    } else {
      alert("Đăng nhập thất bại");
    }
  });
};

const addToCart = (id, count = 1) => {
  $.post("?controller=cart&action=store", {
    method: "POST",
    data: {
      id,
      count,
    },
  }).then((response) => {
    const { data, message } = JSON.parse(response);
    if (!$("#cart-icon").length) {
      $("#icon-cart-i").append(' <p class="number_cart" id="cart-icon"></p>');
    }
    alert(message);
    $("#cart-icon").text(data);
  });
};

const checkCode = (total) => {
  const valueCode = $("#input-discount-code").val();
  if (!valueCode) return;
  $.post("?controller=order&action=checkdiscountcode", {
    method: "POST",
    data: {
      code: valueCode,
    },
  }).then((response) => {
    const { data, message } = JSON.parse(response);
    alert(message);
    if (data && data.length) {
      let discountPrice = 0;
      const value = data[0].value;
      if (value.includes("%")) {
        discountPrice = (total * parseFloat(value)) / 100;
      } else {
        discountPrice = parseFloat(value);
      }
      $("#row-discount-price").html(`
      <div class="main__pay-text">giảm</div>
        <div  class="main__pay-price">
        -${discountPrice} ₫
        </div>
        
      `);

      if (discountPrice < total) {
        $("#row-total-price").html(`${total - discountPrice} đ`);
      } else {
        $("#row-total-price").html(`0 đ`);
      }

      $("#input-discount-code").attr("disabled", "disabled");
    }
  });
};

const checkout = (user) => {
  if (!user) {
    return alert("Bạn phải đăng nhập trước");
  }
  const userId = user;
  const data = {
    userId,
    price:
      parseFloat(
        $("#row-total-price").text().toString().trim().split(" ")[0]
      ) || null,
  };
  if ($("#input-discount-code").attr("disabled")) {
    data["discountCode"] = $("#input-discount-code").val();
  }
  $.post("?controller=order&action=store", {
    method: "POST",
    data,
  })
    .then((res) => {
      const { data, message } = JSON.parse(res);
      alert(message);
      if (data === 1) {
        window.location.href = "./index.php";
      }
    })
    .catch((err) => {
      console.log(err);
    });
};
