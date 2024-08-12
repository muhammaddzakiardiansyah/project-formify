<?php

// echo password_hash('dzakianggelika', PASSWORD_ARGON2I);
// echo PHP_EOL;
// echo mt_rand(10000000, 10000000000);
// $str = "satu, dua, tiga";

// print_r($arr = explode(",", $str));

// $string = 'satu dua tiga';

// $key_password = hash('sha256', 'bimsalabim');

// $newPass = $string . $key_password;

$data = 'aku adalahh abim & dzaki';

echo htmlspecialchars($data);

// $hash = base64_encode($data);

// echo base64_decode($hash);

// $password = password_hash($newPass, PASSWORD_ARGON2I);

// if(password_verify($newPass, '$argon2i$v=19$m=65536,t=4,p=1$WUdJczZjbHFqQUQ1ZGhHTg$7s/l3sI3v/rb9lzy5SFrVqSrCEYgajXsyA01IPiXeQQ')) {
//   echo 'bener';
// } else {
//   echo 'salah';
// }

$st = "aku, kamu, dia";
$arr = explode(",", $st);
array_pop($arr);

var_dump($arr);