<?php

$page = 'Login';

include './components/header.php';

if(isset($_SESSION["user_login"])) {
  header("Location: show-form");
}

if(!isset($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = base64_encode(openssl_random_pseudo_bytes(32));
}

if(!empty($_POST)) {
  $csrf_token_on_input = $_POST["csrf_token"] ?? "";
  $csrf_token_in_session = $_SESSION["csrf_token"] ?? "";
  if($csrf_token_on_input !== $csrf_token_in_session) {
    unset($_SESSION["csrf_token"]);
    echo '<script>
        Swal.fire({
          title: "Failed!",
          text: "CSRF token is incorret!",
          icon: "error",
          showConfirmButton: false,
          timer: 2500,
        });
    </script>';
  } else {
    unset($_SESSION["csrf_token"]);
    $login = login($_POST);
    if($login === 200) {
      echo '<script>
          Swal.fire({
            title: "Success!",
            text: "Authentication success!",
            icon: "success",
            showConfirmButton: false,
            timer: 2500,
          });
          setTimeout(() => {
            document.location.href = "show-form";
          }, 2500);
      </script>';
    } elseif ($login === 400) {
      echo '<script>
          Swal.fire({
            title: "Authentication failed!",
            text: "Username or Password incorret!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
          });
      </script>';
    } elseif ($login === 404) {
      echo '<script>
          Swal.fire({
            title: "Authentication failed!",
            text: "User not found!",
            icon: "error",
            showConfirmButton: false,
            timer: 2500,
          });
      </script>';
    }
  }
}
?>

<div class="container h-100">
  <div class="row h-100">
    <div class="col-lg-6 mx-auto mt-5">
      <div class="card b-white">
        <div class="card-body">
          <h2 class="t-black semi-header mb-3 text-center">Login</h2>
          <form action="" id="login" class="mt-4 font-primary" method="post">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?? "awokawok" ?>">
            <div class="mb-3">
              <label for="username" class="form-label t-black medium-header">Username <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label t-black medium-header">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control" id="password" placeholder="Enter password">
              <div class="d-flex align-items-center column-gap-2">
                <input type="checkbox" class="form-check-input" id="togglePassword">
                <p class="d-inline-block  mt-20">See Password</p>
              </div>
            </div>
            <button class="btn btn-primary mt-4" type="submit"><i class="bi bi-box-arrow-in-right"></i> Login</button>
            <p class="t-black font-primary mt-5 text-center">Dont have account? <a href="register" class="t-blue text-decoration-none">Register</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  const togglePassword = document.getElementById("togglePassword");
  const inputPassword = document.getElementById("password");

  togglePassword.addEventListener('change', () => {
    const type = inputPassword.getAttribute("type") === "password" ? "text" : "password";
    inputPassword.setAttribute("type", type);
  });

  $().ready(() => {
    $("#login").validate({
      rules: {
        username: {
          required: true,
        },
        password: {
          required: true,
        }
      }
    });
  });
</script>

<?php
include './components/footer.php';
?>