<?php
$page = "Register";

include './components/header.php';

if(!isset($_SESSION['csrf_token'])) {
  $_SESSION["csrf_token"] = base64_encode(openssl_random_pseudo_bytes(32));
}

if(!empty($_POST)) {
  $csrf_token_on_input = $_POST["csrf_token"];
  $csrf_token_in_session = $_SESSION["csrf_token"] ?? [];
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
    $register = register($_POST);
    if($register == 1) {
      echo '<script>
            Swal.fire({
              title: "Success!",
              text: "Your account has created!",
              icon: "success",
              showConfirmButton: false,
              timer: 2500,
            });
            setTimeout(() => {
              document.location.href = "login";
            }, 2500);
        </script>';
    } elseif($register == 200) {
      echo '<script>
            Swal.fire({
              title: "Warning!",
              text: "Username alredy exits!",
              icon: "warning",
              showConfirmButton: false,
              timer: 2500,
            });
        </script>';
    } else {
      echo '<script>
            Swal.fire({
              title: "Failed!",
              text: "Your account failed created!",
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
      <div class="card b-white mb-5">
        <div class="card-body">
          <h2 class="t-black semi-header mb-3 text-center">Register</h2>
          <form action="" id="register" class="mt-4 font-primary" method="post">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?? "awokawok" ?>">
            <div class="mb-3">
              <label for="name" class="form-label t-black medium-header">Name <span class="text-danger">*</span></label>
              <input type="text" name="name" class="form-control" id="name" placeholder="Enter name">
            </div>
            <div class="mb-3">
              <label for="username" class="form-label t-black medium-header">Username <span class="text-danger">*</span></label>
              <input type="text" name="username" oninput="toLowwerCase(this)" class="form-control" id="username" placeholder="Enter username">
            </div>
            <div class="mb-3">
              <label for="password" class="form-label t-black medium-header">Password <span class="text-danger">*</span></label>
              <input type="password" name="password" class="form-control password" id="password" placeholder="Enter password">
              <div class="d-flex align-items-center column-gap-2">
                <input type="checkbox" class="form-check-input" id="togglePassword">
                <p class="d-inline-block  mt-20">See Password</p>
              </div>
            </div>
            <button class="btn btn-primary mt-4" type="submit"><i class="bi bi-plus-lg"></i> Register</button>
            <p class="t-black font-primary mt-5 text-center">Have account? <a href="login" class="t-blue text-decoration-none">Login</a></p>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<script>

  function toLowwerCase(input) {
    input.value = input.value.toLowwerCase();
  }
  const togglePassword = document.getElementById("togglePassword");
  const inputPassword = document.getElementById("password");

  togglePassword.addEventListener('change', () => {
    const type = inputPassword.getAttribute("type") === "password" ? "text" : "password";
    inputPassword.setAttribute("type", type);
  });

  $().ready(() => {
    $("#register").validate({
      rules: {
        name: {
          required: true,
          minlength: 5,
        },
        username: {
          required: true,
          minlength: 5,
        },
        password: {
          required: true,
          minlength: 8,
        },
      }
    })
  })
</script>

<?php
include './components/footer.php';
?>