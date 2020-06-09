<?php


function validateForm(&$error, $field_list, $rekening, $saldo, $nama, $alamat, $email, $telepon,$username, $password, $conpassword)
{
	$patternName = "/^[a-zA-Z '-.]+$/";
	$patternNumber = "/^[0-9]*$/";
	$patternPassword = "/(?=.*[a-zA-Z])(?=.*[0-9])/i";
	if (!isset($field_list[$rekening]) || empty($field_list[$rekening])) {
		$error[$rekening] = 'field is required';
	}
	else if (!preg_match($patternNumber, $field_list[$rekening])){
		$error[$rekening] = 'harus angka';
	}

	if (!isset($field_list[$saldo]) || empty($field_list[$saldo])) {
		$error[$saldo] = 'field is required';
	}
	else if (!preg_match($patternNumber, $field_list[$saldo])){
		$error[$saldo] = 'harus angka';
	}

	if (!isset($field_list[$nama]) || empty($field_list[$nama])) {
		$error[$nama] = 'field is required';
	}
	else if (!preg_match($patternName, $field_list[$nama])){
		$error[$nama] = 'hanya berisi abjad';
	}

	if (!isset($field_list[$alamat]) || empty($field_list[$alamat])) {
		$error[$alamat] = 'field is required';
	}

	if (!isset($field_list[$email]) || empty($field_list[$email])) {
		$error[$email] = 'field is required';
	}
	else if (!filter_var($field_list[$email], FILTER_VALIDATE_EMAIL)) {
		$error[$email] = 'kesalahan penulisan email';
	}

	if (!isset($field_list[$telepon]) || empty($field_list[$telepon])) {
		$error[$telepon] = 'field is required';
	}
	else if (!preg_match($patternNumber, $field_list[$telepon])) {
		$error[$telepon] = 'hanya angka';
	}
	else if (strlen($field_list[$telepon]) <= 10) {
		$error[$telepon] = 'nomor telepon lebih dari 10 digit';
	}

	if (!isset($field_list[$username]) || empty($field_list[$username])) {
		$error[$username] = 'field is required';
	}
	else if (!preg_match($patternName, $field_list[$username])){
		$error[$username] = 'hanya berisi abjad';
	}

	if (!isset($field_list[$password]) || empty($field_list[$password])) {
		$error[$password] = 'field is required';
	}
	else if (strlen($field_list[$password]) < 8) {
		$error[$password] = 'panjang password lebih dari 8 karakter';
	}

	if (!isset($field_list[$conpassword]) || empty($field_list[$conpassword])) {
		$error[$conpassword] = 'field is required';
	}
	else if ($field_list[$conpassword] != $field_list[$password]) {
		$error[$conpassword] = 'password tidak sama';
	}
}

function validateLogin(&$error, $field_list, $username, $password)
{
	$pattern = "/^[a-zA-Z0-9]+$/";

	if (!isset($field_list[$username]) || empty($field_list[$username])) {
		$error[$username] = 'field is required';
	}
	else if (!preg_match($pattern, $field_list[$username])){
		$error[$username] = 'hanya huruf atau angka';
	}

	if (!isset($field_list[$password]) || empty($field_list[$password])) {
		$error[$password] = 'field is required';
	}
	else if (!preg_match($pattern, $field_list[$password])){
		$error[$password] = 'hanya huruf atau angka';
	}
}
?>