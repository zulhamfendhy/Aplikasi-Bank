<?php

$db = new PDO('mysql:host=localhost;dbname=banking','root', '');
$db -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Fungsi untuk mengambil seluruh data customer
function read_all_data($dbc, &$statment){
	$statment = $dbc -> prepare("SELECT * FROM customer WHERE NO_REK != 001");
	$statment -> execute();
}

// Fungsi untuk mengambil data customer tertentu
function select_rekening_data($dbc, &$statment, $value){
	$statment = $dbc -> prepare("SELECT * FROM customer WHERE NO_REK = :NO_REK");
	$statment -> bindValue(':NO_REK', $value);
	$statment -> execute();
}

// Fungsi untuk menambah data customer
function insert_data($dbc){
	$statment = $dbc -> prepare("INSERT INTO customer(NO_REK, NAMA, ALAMAT, EMAIL, NO_HP, PASSWORD, USERNAME_CUS) VALUES(:Rekening, :Nama, :Alamat, :Email, :Telepon, SHA2(:Password, 0), :Username)");
	$statment -> bindValue(':Rekening', $_POST['rekening']);
	$statment -> bindValue(':Nama', $_POST['nama']);
	$statment -> bindValue(':Alamat', $_POST['alamat']);
	$statment -> bindValue(':Email', $_POST['email']);
	$statment -> bindValue(':Telepon', $_POST['telepon']);
	$statment -> bindValue(':Password', $_POST['password']);
	$statment -> bindValue(':Username', $_POST['username']);
	$statment -> execute();
}

// Fungsi untuk menghapus data customer
function delete_data($dbc, $var){
	$statment = $dbc -> prepare("UPDATE transfer SET NO_REK = :Bank WHERE NO_REK = :Rekening;
		UPDATE transfer SET CUS_NO_REK = :Bank WHERE CUS_NO_REK = :Rekening;
		DELETE FROM riwayat WHERE NO_REK = :Rekening");
	$statment -> bindValue(':Bank', "001");
	$statment -> bindValue(':Rekening', $var);
	$statment -> execute();

	$statment = $dbc -> prepare("DELETE FROM customer WHERE NO_REK = :Rekening");
	$statment -> bindValue(':Rekening', $var);
	$statment -> execute();
}

// Fungsi untuk memperbarui data customer
function update_data($dbc){
	$statment = $dbc -> prepare("UPDATE customer SET NAMA = :Nama, ALAMAT = :Alamat, EMAIL = :Email, NO_HP = :Telepon, PASSWORD = SHA2(:Password, 0) WHERE NO_REK = :Rekening");
	$statment -> bindValue(':Rekening', $_POST['rekening']);
	$statment -> bindValue(':Nama', $_POST['nama']);
	$statment -> bindValue(':Alamat', $_POST['alamat']);
	$statment -> bindValue(':Email', $_POST['email']);
	$statment -> bindValue(':Telepon', $_POST['telepon']);
	$statment -> bindValue(':Password', $_POST['password']);
	$statment -> execute();
}

// Fungsi untuk mengecek admin
function check_admin($dbc, $postName, $postPassword){
	$statement = $dbc -> prepare("SELECT * FROM admin WHERE USEERN = :username and PASS = sha2(:password, 0)");
	$statement -> bindValue(':username', $postName);
	$statement -> bindValue(':password', $postPassword);
	$statement -> execute();

	return $statement->rowCount() > 0;
}

// Fungsi untuk menambah saldo awal
function transfer_admin($dbc){
	$statement = $dbc -> prepare("INSERT INTO transfer(NO_REK, CUS_NO_REK) VALUES(:bank, :customer)");
	$statement -> bindValue(':bank', "001");
	$statement -> bindValue(':customer', $_POST['rekening']);
	$statement -> execute();
}

// Fungsi untuk menambah riwayat awal
function riwayat_admin($dbc){
	$statement = $dbc -> prepare("INSERT INTO riwayat(NO_REK, ID_TRANSFER, DEBET, SALDO) VALUES(:customer, (SELECT MAX(ID_TRANSFER) AS ID FROM transfer WHERE NO_REK = :bank AND CUS_NO_REK = :customer), :debet, :saldo)");
	$statement -> bindValue(':bank', "001");
	$statement -> bindValue(':customer', $_POST['rekening']);
	$statement -> bindValue(':debet', $_POST['saldo']);
	$statement -> bindValue(':saldo', $_POST['saldo']);
	$statement -> execute();
}
?>



