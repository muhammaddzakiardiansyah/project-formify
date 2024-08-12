<?php include "./components/header.php" ?>
<?php
$uri = $_SERVER["REQUEST_URI"];
$array_uri = explode("/", $uri);
$fid = end($array_uri);
$delete_form = deleteForm($fid);
if ($delete_form === 404) {
  echo '<script>
              Swal.fire({
                title: "Failed!",
                text: "form not found!",
                icon: "error",
                showConfirmButton: false,
                timer: 2500,
              });
              setTimeout(() => {
                document.location.href = "/project-formify/show-form"
              }, 2500);
          </script>';
} elseif ($delete_form === 500) {
  echo '<script>
              Swal.fire({
                title: "Failed!",
                text: "Failed delete form!",
                icon: "error",
                showConfirmButton: false,
                timer: 2500,
              });
              setTimeout(() => {
                document.location.href = "/project-formify/show-form"
              }, 2500);
          </script>';
} elseif ($delete_form === 200) {
  echo '<script>
              Swal.fire({
                title: "Success!",
                text: "Success delete form!",
                icon: "success",
                showConfirmButton: false,
                timer: 2500,
              });
              setTimeout(() => {
                document.location.href = "/project-formify/show-form"
              }, 2500);
          </script>';
}

?>