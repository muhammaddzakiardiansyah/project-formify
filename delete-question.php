<?php include './components/header.php'; ?>
<?php
$uri = $_SERVER["REQUEST_URI"];
$uri_array = explode("/", $uri);

$qid = $uri_array[3];
$redirect = "/" . $uri_array[5] . "/" . $uri_array[6] . "/" . $uri_array[7];

$delete_question = deleteQuestion($qid);
if ($delete_question === 404) {
  echo '<script>
              Swal.fire({
                title: "Failed!",
                text: "Question not found!",
                icon: "error",
                showConfirmButton: false,
                timer: 2500,
              });
              setTimeout(() => {
                document.location.href = "'.$redirect.'"
              }, 2500);
          </script>';
} elseif ($delete_question === 500) {
  echo '<script>
              Swal.fire({
                title: "Failed!",
                text: "Failed delete question!",
                icon: "error",
                showConfirmButton: false,
                timer: 2500,
              });
              setTimeout(() => {
                document.location.href = "'.$redirect.'"
              }, 2500);
          </script>';
} elseif ($delete_question === 200) {
  echo '<script>
              Swal.fire({
                title: "Success!",
                text: "Success delete question!",
                icon: "success",
                showConfirmButton: false,
                timer: 2500,
              });
              setTimeout(() => {
                document.location.href = "'.$redirect.'"
              }, 2500);
          </script>';
}
?>
<?php include './components/footer.php'; ?>