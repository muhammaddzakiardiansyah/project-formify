<?php
include './components/header.php';

include './components/navbar.php';

$user_id = 0;

if (isset($_COOKIE["key_1"]) && !empty($_COOKIE["key_1"])) {
  $decode = base64_decode($_COOKIE["key_1"]);
  if ($decode) {
    $user_id = $decode;
  }
}

$forms = getAllFormsByUserId($user_id);

?>
<div class="container mt-30">
  <div class="row mt-5">
    <div class="col-lg-4">
      <div class="card px-5 py-4 b-white mt-5">
        <h4 class="semi-header t-black text-center mb-20">Create New Form</h4>
        <a href="create-form" class="btn btn-primary"><i class="bi bi-file-earmark-plus"></i> Create Form</a>
      </div>
    </div>
    <div class="col-lg-8">
      <h3 class="big-header t-black mb-30 mt-5">List your forms</h3>
      <?php if (!empty($forms)) : ?>
        <?php foreach ($forms as $form) : ?>
          <div class="card b-white px-3 py-4 mb-20">
            <div class="d-flex justify-content-between t-black medium-header">
              <input type="hidden" id="copyUrl" name="copyUrl" value="http://localhost/project-formify/show-form-detail.php/<?= $form["slug"] ?>">
              <i class="bi bi-clipboard mb-3 pointer mt-1" onclick="copyUrl()"></i>
              <a onclick="return confirm('Sure delete it?')" href="delete-form.php/<?= $form["id"] ?>" class="text-black"><i class="bi bi-trash fs-5"></i></a>
            </div>
            <a href="show-form-detail.php/<?= $form["slug"] ?>" class="text-decoration-none">
              <div class="card-body d-flex justify-content-between align-items-center">
                <h4 class="t-black medium-header"><?= $form["title"] ?></h4>
                <small class="t-black medium-header"><?php $date = DateTime::createFromFormat("Y-m-d H:i:s", $form["created_at"]);
                                                      echo $date->format("Y/m/d") ?></small>

              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php else : ?>
        <div class="card">
          <div class="card-body font-primary t-black text-center">
            <h3 class="medium-header">You haven't created a form yet</h3>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<script>
  function copyUrl() {
    const textToCopy = document.getElementById("copyUrl");

    let tmpTextarea = document.createElement("textarea");
    tmpTextarea.value = textToCopy.value;
    document.body.appendChild(tmpTextarea);

    tmpTextarea.select();
    tmpTextarea.setSelectionRange(0, 99999);

    document.execCommand("copy");

    document.body.removeChild(tmpTextarea);

    Swal.fire({
      title: "Copied!",
      text: textToCopy.value,
      icon: "success",
      showConfirmButton: false,
      timer: 2500,
    });
  }
</script>
<?php
include './components/footer.php';
?>