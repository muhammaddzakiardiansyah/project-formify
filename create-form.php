<?php
$page = 'Create Form';

include './components/header.php';

include './components/navbar.php';

if (!isset($_SESSION['csrf_token'])) {
  $_SESSION["csrf_token"] = base64_encode(openssl_random_pseudo_bytes(32));
}

if (!empty($_POST)) {
  $csrf_token_on_input = $_POST["csrf_token"];
  $csrf_token_in_session = $_SESSION["csrf_token"];
  if ($csrf_token_on_input !== $csrf_token_in_session) {
    unset($_SESSION["csrf_token"]);
    $_SESSION["csrf_token"] = base64_encode(openssl_random_pseudo_bytes(32));
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
    $_SESSION["csrf_token"] = base64_encode(openssl_random_pseudo_bytes(32));
    $create_form = createForm($_POST);
    if ($create_form === 201) {
      echo '<script>
            Swal.fire({
              title: "Success!",
              text: "Form success created!",
              icon: "success",
              showConfirmButton: false,
              timer: 2500,
            });
            setTimeout(() => {
              document.location.href = "show-form";
            }, 2500);
        </script>';
    } elseif ($create_form === 404) {
      echo '<script>
            Swal.fire({
              title: "Warning!",
              text: "You need login to create form!",
              icon: "warning",
              showConfirmButton: false,
              timer: 2500,
            });
        </script>';
    } elseif ($create_form === 400) {
      echo '<script>
            Swal.fire({
              title: "Warning!",
              text: "The limit for creating forms is only 5!",
              icon: "warning",
              showConfirmButton: false,
              timer: 2500,
            });
        </script>';
    } elseif ($create_form = 500) {
      echo '<script>
            Swal.fire({
              title: "Failed!",
              text: "Failed create form!",
              icon: "error",
              showConfirmButton: false,
              timer: 2500,
            });
        </script>';
    }
  }
}

?>
<div class="container mt-30">
  <div class="row mt-5">
    <div class="col-lg-8 mx-auto">
      <div class="card">
        <h3 class="t-black semi-header">Create new from</h3>
        <form action="" class="mt-3 font-primary" method="post" id="create_form">
          <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?? "awokawok" ?>">
          <div class="mb-3">
            <label for="title" class="form-label t-black medium-header">Title <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Enter title">
          </div>
          <div class="mb-3">
            <label for="description" class="form-label t-black medium-header">Description <span class="text-danger">*</span></label>
            <textarea name="description" id="description" rows="4" placeholder="Enter description" class="form-control"></textarea>
          </div>
          <div class="mb-4">
            <label class="t-black medium-header mb-10">Show Creator ?</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="show_creator" id="required" value="1" checked>
              <label class="form-check-label" for="required">
                Yes
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="show_creator" id="not_required" value="0">
              <label class="form-check-label" for="not_required">
                No
              </label>
            </div>
          </div>
          <div class="mb-4">
            <label class="t-black medium-header mb-10">One submit ?</label>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="one_submit" id="ya" value="1" checked>
              <label class="form-check-label" for="ya">
                Yes
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="one_submit" id="not" value="0">
              <label class="form-check-label" for="not">
                No
              </label>
            </div>
          </div>
          <button class="btn btn-primary mt-4"><i class="bi bi-file-earmark-plus"></i> Create</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $().ready(() => {
    $("#create_form").validate({
      rules: {
        title: {
          required: true,
          minlength: 5,
        },
        description: {
          required: true,
          minlength: 5,
        }
      }
    })
  })
</script>
<?php
include './components/footer.php';
?>