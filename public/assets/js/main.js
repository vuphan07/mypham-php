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
  });
};
