<?php

require './functions.php';

$uri = $_SERVER["REQUEST_URI"];
$array_uri = explode("/", $uri);
$end_uri = end($array_uri);

$form = getFormBySlug($end_uri);

$questions = [];
if (!empty($form)) {
  $questions = getQuestionByFormId($form["id"]);
} else {
  header("Location: /project-formify");
}

$user_id = 0;

if (isset($_COOKIE["key_1"]) && !empty($_COOKIE["key_1"])) {
  $decode = base64_decode($_COOKIE["key_1"]);
  if ($decode) {
    $user_id = $decode;
  }
}

$creator = $form["username"];
$page = $form["title"];

$answers = getAnswers($form["id"]);

include './components/header.php';

if (!isset($_SESSION["csrf_token"])) {
  $_SESSION["csrf_token"] = base64_encode(openssl_random_pseudo_bytes(32));
}

if ($user_id === 0 && !isset($_SESSION["user_id"])) {
  $_SESSION["user_id"] = mt_rand(10000000, 10000000000);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (isset($_POST["create_question"])) {
    $csrf_token_on_input = $_POST["csrf_token"] ?? "";
    $csrf_token_in_session = $_SESSION["csrf_token"] ?? "";
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
      $uri = $_SERVER["REQUEST_URI"];
      $create_question = createQuestion($_POST);
      if ($create_question === 201) {
        echo "<script>
              Swal.fire({
                title: 'Success!',
                text: 'question success created!',
                icon: 'success',
                showConfirmButton: false,
                timer: 2500,
              });
              setTimeout(() => {
                document.location.href = '$uri';
              }, 2500);
          </script>";
      } else {
        echo '<script>
              Swal.fire({
                title: "Failed!",
                text: "Failed create question!",
                icon: "error",
                showConfirmButton: false,
                timer: 2500,
              });
          </script>';
      }
    }
  } elseif (isset($_POST["question"])) {
    $csrf_token_on_input = $_POST["csrf_token"] ?? "";
    $csrf_token_in_session = $_SESSION["csrf_token"] ?? "";
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
      $create_answer = createAnswer($_POST, $form["answer_once"]);
      if ($create_answer === 201) {
        echo "<script>
              Swal.fire({
                title: 'Success!',
                text: 'The form has been sent!',
                icon: 'success',
                showConfirmButton: false,
                timer: 2500,
              });
              setTimeout(() => {
                document.location.href = '/project-formify/submited';
              }, 2500);
          </script>";
      } elseif ($create_answer === 400) {
        echo '<script>
              Swal.fire({
                title: "Failed!",
                text: "The form can only be answered once!",
                icon: "error",
                showConfirmButton: false,
                timer: 2500,
              });
        </script>';
      } else {
        echo '<script>
              Swal.fire({
                title: "Failed!",
                text: "Failed submit form!",
                icon: "error",
                showConfirmButton: false,
                timer: 2500,
              });
          </script>';
      }
    }
  } elseif (isset($_POST["delete-question"])) {
    var_dump($_POST["qid"]);
  }
}

?>
<div class="container mt-30">
  <div class="row mt-4">
    <div class="col-lg-10 mx-auto">
      <div class="card b-white mb-20">
        <div class="card-body">
          <h1 class="t-black big-header"><?= $form["title"] ?></h1>
          <p class="t-black medium-header mt-20"><?= $form["description"] ?></p>
          <h6 class="mt-5 t-black medium-header">Made by <?= $form["show_creator"] ? "<a href='#' class='text-decoration-none'>@$creator</a>" : "Anonymus" ?> on <small class="t-black medium-header"><?php $date = DateTime::createFromFormat("Y-m-d H:i:s", $form["created_at"]);
                                                                                                                                                                                                      echo $date->format("Y/m/d") ?></small>
          </h6>
          <?php if ($form["user_id"] == $user_id) : ?>
            <div class="box-tools mt-3 d-flex justify-content-beetwen gap-2">
              <button class="btn btn-sm btn-primary btn-create-question" onclick="createQuestion()"><i class="bi bi-file-earmark-plus"></i> Create Question</button>
              <button class="btn btn-sm btn-secondary btn-show-result" onclick="showResult()"><i class="bi bi-eye"></i> Result</button>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <!-- card result -->
      <?php include './components/card-result.php' ?>
      <!-- end card result -->
      <!-- card question -->
      <?php include './components/form-create-question.php' ?>
      <!-- end card question -->
      <!-- question card -->
      <form action="" id="question_card" class="font-primary" method="post">
        <input type="hidden" name="csrf_token" value="<?= $_SESSION["csrf_token"] ?? "awokawok" ?>">
        <input type="hidden" name="user_id" value="<?= $user_id === 0 ? $_SESSION["user_id"] : $user_id ?>">
        <input type="hidden" name="form_id" value="<?= $form["id"] ?>">
        <?php if (!empty($questions)) : ?>
          <?php foreach ($questions as $question) : ?>
            <?php if ($question["question_type"] === "input") : ?>
              <div class="card card-question b-white mb-3">
                <div class="card-body">
                  <label class="t-black medium-header mb-20" for="<?= $question["question_without_spaces"] ?>"><?= $question["question"] ?></label>
                  <input type="text" name="<?= $question["question_without_spaces"] ?>" id="<?= $question["question_without_spaces"] ?>" placeholder="Enter your answer" class="form-control font-primary">
                  <?php if ($form["user_id"] == $user_id) : ?>
                    <a onclick="return confirm('Delete it?')" href="/project-formify/delete-question.php/<?= $question['id'] ?>/<?= $_SERVER["REQUEST_URI"] ?>" class="btn btn-danger btn-sm mt-3 t-white medium-header">Delete</a>
                  <?php endif; ?>
                </div>
              </div>
            <?php elseif ($question["question_type"] === "textarea") : ?>
              <div class="card card-question b-white mb-3">
                <div class="card-body">
                  <label class="t-black medium-header mb-20" for="<?= $question["question_without_spaces"] ?>"><?= $question["question"] ?></label>
                  <textarea name="<?= $question["question_without_spaces"] ?>" id="<?= $question["question_without_spaces"] ?>" rows="4" placeholder="Explain in detail" class="form-control"></textarea>
                  <?php if ($form["user_id"] == $user_id) : ?>
                    <a onclick="return confirm('Delete it?')" href="/project-formify/delete-question.php/<?= $question['id'] ?>/<?= $_SERVER["REQUEST_URI"] ?>" class="btn btn-danger btn-sm mt-3 t-white medium-header">Delete</a>
                  <?php endif; ?>
                </div>
              </div>
            <?php elseif ($question["question_type"] === "combobox") : ?>
              <div class="card card-question b-white mb-3">
                <div class="card-body">
                  <label class="t-black medium-header mb-20" for="<?= $question["question_without_spaces"] ?>"><?= $question["question"] ?></label>
                  <select class="form-select" id="<?= $question["question_without_spaces"] ?>" name="<?= $question["question_without_spaces"] ?>" aria-label="Default select example">
                    <option value="" selected>Open this select menu</option>
                    <?php $answers = explode(",", $question["answers"]);
                    foreach ($answers as $answer) : ?>
                      <option value="<?= $answer ?>"><?= $answer ?></option>
                    <?php endforeach; ?>
                  </select>
                  <?php if ($form["user_id"] == $user_id) : ?>
                    <a onclick="return confirm('Delete it?')" href="/project-formify/delete-question.php/<?= $question['id'] ?>/<?= $_SERVER["REQUEST_URI"] ?>" class="btn btn-danger btn-sm mt-3 t-white medium-header">Delete</a>
                  <?php endif; ?>
                </div>
              </div>
            <?php endif; ?>
          <?php endforeach ?>
        <?php else : ?>
          <div class="card card-question">
            <div class="card-body">
              <h3 class="text-center t-black semi-header">No questions have been asked yet</h3>
            </div>
          </div>
        <?php endif; ?>
        <div class="mt-5 btn-question mb-5 d-flex justify-content-end">
          <?php if(!empty($questions)) : ?>
            <button class="btn btn-primary" type="submit" name="question"><i class="bi bi-send"></i> Submit</button>
          <?php else : ?>
            <button class="btn btn-primary disabled" type="submit" name="question"><i class="bi bi-send"></i> Submit</button>
          <?php endif; ?>
        </div>
      </form>
      <!-- end question -->
    </div>
  </div>
</div>

<!-- javascript -->
<script>
  function createQuestion() {
    const formQuestion = document.querySelector('.form-question');
    const btnQuestion = document.querySelector('.btn-question');
    formQuestion.classList.toggle('d-none');
    btnQuestion.classList.toggle('d-none');
  }

  function showResult() {
    const showResult = document.querySelector('.show-result');
    const cardQuestion = document.querySelectorAll('.card-question');
    const btnCreateQuestion = document.querySelector('.btn-create-question');
    const btnQuestion = document.querySelector('.btn-question');
    const formQuestion = document.querySelector('.form-question');

    formQuestion.classList.add('d-none');
    btnQuestion.classList.toggle('d-none');
    btnCreateQuestion.classList.toggle('d-none');
    cardQuestion.forEach((item) => item.classList.toggle('d-none'));
    showResult.classList.toggle('d-none');
  }

  const inputTypeQuestion = document.getElementById('type_question');
  const inputAnswers = document.querySelector('.input-answers');

  inputTypeQuestion.addEventListener('change', (e) => {
    const value = inputTypeQuestion.value;
    if (value === 'combobox') {
      inputAnswers.classList.remove('d-none');
    } else {
      inputAnswers.classList.add('d-none');
    }
  });

  $().ready(() => {
    $("#create_question").validate({
      rules: {
        question: {
          required: true,
          minlength: 3,
        },
        type_question: {
          required: true,
        },
        answers: {
          required: true,
        }
      }
    });
  });

  $().ready(() => {
    $("#question_card").validate({
      rules: {
        <?php foreach ($questions as $question) : ?>
          <?php if ($question["is_required"]) : ?>
            <?= $question["question_without_spaces"] ?>: {
              required: true,
            },
          <?php endif; ?>
        <?php endforeach; ?>
      }
    });
  });
</script>
<?php
include './components/footer.php';
?>