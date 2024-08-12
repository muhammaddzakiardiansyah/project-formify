<?php

declare(strict_types=1);

$project_name = 'project-formify';

$servername = "localhost";
$username = "root";
$password = "";
$database = "formify";
$random = "YTNIih903reHOH23232$#$2JFEjgarg4RJ4ITOF";

$connection = new mysqli($servername, $username, $password, $database);

if ($connection->connect_error) {
  die('connection error' . $connection->connect_errno);
}

if (!function_exists("register")) {
  function register(array $dataRegister): int
  {
    global
      $random,
      $connection;

    $id = mt_rand(10000000, 10000000000);
    $name = htmlspecialchars($dataRegister["name"]);
    $username = htmlspecialchars(strtolower($dataRegister["username"]));
    $profile = "-";
    $secret_key_password = hash('sha256', $random);
    $new_string_password = $dataRegister["password"] . $secret_key_password;
    $password = password_hash($new_string_password, PASSWORD_ARGON2I);
    $bio = "-";

    $sql = $connection->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $sql->bind_param("s", $username);
    $sql->execute();
    $resultGet = $sql->get_result();
    if ($resultGet->num_rows > 0) {
      return 200;
    } else {
      $stmt = $connection->prepare("INSERT INTO users (id, name, username, profile, password, bio) VALUES (?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("isssss", $id, $name, $username, $profile, $password, $bio);

      if ($stmt->execute()) {
        $stmt->close();
        $connection->close();
        return 1;
      } else {
        $stmt->close();
        $connection->close();
        return 0;
      }
    }
  }
}
if (!function_exists("login")) {
  function login(array $dataLogin): int
  {
    global
      $connection,
      $random;

    $username = $dataLogin["username"];
    $secret_key_password = hash("sha256", $random);
    $password = $dataLogin["password"] . $secret_key_password;

    $sql = $connection->prepare("SELECT * FROM users WHERE username = ? LIMIT 1");
    $sql->bind_param("s", $username);
    $sql->execute();
    $resultGet = $sql->get_result();
    $dataResultGet = $resultGet->fetch_object();
    if ($resultGet->num_rows > 0) {
      $sql->close();
      $connection->close();
      if (!password_verify($password, $dataResultGet->password)) {
        return 400;
      } else {
        $_SESSION["user_login"] = ["login" => true, "username" => $dataResultGet->username];
        // key 1 = id user, key 2 = username user
        setcookie("key_1", base64_encode(strval($dataResultGet->id)), time() + 86400, "/");
        setcookie("key_2", hash("sha256", $dataResultGet->username), time() + 86400, "/");
        return 200;
      }
    } else {
      $sql->close();
      $connection->close();
      return 404;
    }
  }
}

if (!function_exists("getUserById")) {
  function getUserById(int $id): array
  {
    global
      $connection;

    $sql = $connection->prepare("SELECT * FROM users WHERE id = ? LIMIT 1");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
      $sql->close();
      return $result->fetch_assoc();
    } else {
      $sql->close();
      return [];
    }
  }
}

if (!function_exists("getAllFormsByUserId")) {
  function getAllFormsByUserId(string $id): array
  {
    global
      $connection;

    $sql = $connection->prepare("SELECT * FROM forms WHERE user_id = ?");
    $sql->bind_param("s", $id);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
      $sql->close();
      $connection->close();
      $rows = [];
      while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
      }
      return $rows;
    } else {
      $sql->close();
      $connection->close();
      return [];
    }
  }
}

if (!function_exists("createForm")) {
  function createForm(array $dataForm): int
  {
    global
      $connection;


    $user_id = 0;

    if (isset($_COOKIE["key_1"]) && !empty($_COOKIE["key_1"])) {
      $decode = base64_decode($_COOKIE["key_1"]);
      if ($decode) {
        $user_id = $decode;
      }
    }

    $id = mt_rand(10000000, 10000000000);
    $title = $dataForm["title"];
    $description = htmlspecialchars($dataForm["description"]);
    $cleanString = preg_replace('/[<>@#^+~$%!?*&]+$/', "", $title);
    $titleArr = explode(" ", $cleanString);
    $slug = strtolower(rtrim(implode("-", $titleArr), "-"));
    $show_creator = intval($dataForm["show_creator"]);
    $one_submit = intval($dataForm["one_submit"]);
    $celan_title = htmlspecialchars($title);

    if (!empty($user_id)) {
      $sql = $connection->prepare("SELECT * FROM forms WHERE user_id = ?");
      $sql->bind_param("i", $user_id);
      $sql->execute();
      $result = $sql->get_result();

      if ($result->num_rows >= 5) {
        $sql->close();
        return 400;
      } else {
        $stmt = $connection->prepare("INSERT INTO forms (id, user_id, title, slug, description, show_creator, answer_once) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("iisssii", $id, $user_id, $celan_title, $slug, $description, $show_creator, $one_submit);

        if ($stmt->execute()) {
          $stmt->close();
          $connection->close();
          return 201;
        } else {
          $stmt->close();
          $connection->close();
          return 500;
        }
      }
    } else {
      return 404;
    }
  }
}

if(!function_exists("deleteForm")) {
  function deleteForm(string $fid): int
  {
    global 
      $connection;
    
    $get_form = $connection->prepare("SELECT * FROM forms WHERE id = ?");
    $get_form->bind_param("s", $fid);
    $get_form->execute();
    $result_get_form = $get_form->get_result();
    if($result_get_form->num_rows <= 0) {
      return 404;
    } else {
      $delete_answer = $connection->prepare("DELETE FROM answers WHERE form_id = ?");
      $delete_answer->bind_param("s", $fid);
      if($delete_answer->execute()) {
        $delete_question = $connection->prepare("DELETE FROM questions WHERE form_id = ?");
        $delete_question->bind_param("s", $fid);
        if($delete_question->execute()) {
          $delete_form = $connection->prepare("DELETE FROM forms WHERE id = ?");
          $delete_form->bind_param("s", $fid);
          if($delete_form->execute()) {
            return 200;
          }
        } else {
          return 500;
        }
      } else {
        return 500;
      }
    }
  }
}

if (!function_exists("getFormBySlug")) {
  function getFormBySlug(string $slug): array
  {
    global
      $connection;

    $sql = $connection->prepare("SELECT f.id, f.user_id, f.title, f.slug, f.description, f.show_creator, f.answer_once, f.created_at, s.username FROM forms f JOIN users s ON f.user_id = s.id WHERE slug = ?");
    $sql->bind_param("s", $slug);
    $sql->execute();
    $result = $sql->get_result();

    if ($result->num_rows > 0) {
      $sql->close();
      return $result->fetch_assoc();
    } else {
      $sql->close();
      return [];
    }
  }
}

if (!function_exists("getQuestionByFormId")) {
  function getQuestionByFormId(int $form_id): array
  {
    global
      $connection;

    $sql = $connection->prepare("SELECT * FROM questions WHERE form_id = ? ORDER BY created_at ASC");
    $sql->bind_param("i", $form_id);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows > 0) {
      $sql->close();
      $rows = [];
      while ($row = $result->fetch_assoc()) {
        $rows[] = $row;
      }
      return $rows;
    } else {
      $sql->close();
      return [];
    }
  }
}

if (!function_exists("createQuestion")) {
  function createQuestion(array $dataQuestion): int
  {
    global 
      $connection;
    
    $id = mt_rand(10000000, 10000000000);
    $form_id = htmlspecialchars($dataQuestion["form_id"]);
    $question = $dataQuestion["question"];
    $cleanStringQuestion = preg_replace("/[@#^+~$%!?*&]+$/", "", $question);
    $questionToArray = explode(" ", $cleanStringQuestion);
    $question_without_spaces = rtrim(implode("_", $questionToArray), "_");
    $type_question = htmlspecialchars($dataQuestion["type_question"]);
    $answers = htmlspecialchars($dataQuestion["answers"]) ?? "-";
    $is_required = htmlspecialchars($dataQuestion["is_required"]);
    $clean_question = htmlspecialchars($question);

    $stmt = $connection->prepare("INSERT INTO questions (id, form_id, question, question_without_spaces, question_type, answers, is_required) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssss", $id, $form_id, $clean_question, $question_without_spaces, $type_question, $answers, $is_required);

    if($stmt->execute()) 
      return 201;
    else
      return 400;
    
  }
}

if(!function_exists("deleteQuestion")) {
  function deleteQuestion(string $id): int
  {
    global $connection;

    $get_question = $connection->prepare("SELECT * FROM questions WHERE id = ? LIMIT 1");
    $get_question->bind_param("s", $id);
    $get_question->execute();
    $result_get_question = $get_question->get_result();
    if($result_get_question->num_rows <= 0) {
      return 404;
    } else {
      $delete_question = $connection->prepare("DELETE FROM questions WHERE id = ?");
      $delete_question->bind_param("s", $id);
      if($delete_question->execute()) {
        return 200;
      } else {
        return 500;
      }
    }
  }
}

if(!function_exists("createAnswer")) {
  function createAnswer(array $dataAnswer, int $answerOnce): int {
    global
      $connection;

    $id = mt_rand(10000000, 10000000000);
    $user_id = $dataAnswer["user_id"];
    $form_id = $dataAnswer["form_id"];
    $key_answers = implode(", ", array_keys($dataAnswer));
    $answers = htmlspecialchars(implode(", ", $dataAnswer));

    $sql = $connection->prepare("SELECT * FROM answers WHERE user_id = ?");
    $sql->bind_param("s", $user_id);
    $sql->execute();
    $result = $sql->get_result();

    if($result->num_rows >= 1 && $answerOnce === 1) {
      return 400;
    } else {
      $stmt = $connection->prepare("INSERT INTO answers (id, user_id, form_id, key_answers, answers) VALUES (?, ?, ?, ?, ?)");
      $stmt->bind_param("issss", $id, $user_id, $form_id, $key_answers, $answers);
      
      if($stmt->execute())
        return 201;
      else
        return 500;
     }
    }
}

if(!function_exists("getAnswers")) {
  function getAnswers(string $form_id): array
  {
    global 
      $connection;

    $get_answer = $connection->prepare("SELECT a.id, a.key_answers, a.answers, a.created_at, u.username FROM answers as a LEFT JOIN users as u ON a.user_id = u.id WHERE a.form_id = ?");
    $get_answer->bind_param("s", $form_id);
    $get_answer->execute();
    $result_get_answer = $get_answer->get_result();
    if($result_get_answer->num_rows <= 0) {
      return [];
    } else {
      $rows = [];
      while($row = $result_get_answer->fetch_assoc()) {
        $rows[] = $row;
      }
      return $rows;
    }
  }
}
