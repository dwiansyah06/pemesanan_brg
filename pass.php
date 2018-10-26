<?php
$result0 = preg_match('/[a-z]/', $string);
$result1 = preg_match('/[A-Z]/', $string);
$result2 = preg_match('/[\d]/', $string);
$result3 = preg_match('/[`!@#$%^&*()+=\-\[\]\';,.\/{}|":<>?~_\\\\]/', $string);
 
$not_passed_parameter = array();
if (!$result0) {
    $not_passed_parameter[] = "- Harus ada huruf kecil";
}
if (!$result1) {
    $not_passed_parameter[] = "- Harus ada huruf besar";
}
if (!$result2) {
    $not_passed_parameter[] = "- Harus ada angka";
}
if (!$result3) {
    $not_passed_parameter[] = "- Harus ada simbol";
}
 
if (count($not_passed_parameter) > 0) {
    echo "Password Anda tidak memenuhi kriteria berikut ini<br>" . PHP_EOL;
    foreach($not_passed_parameter as $t) {
        echo "$t<br>" . PHP_EOL;
    }
} else {
    echo "password oke!<br>" . PHP_EOL;
}
?>