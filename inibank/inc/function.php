<?php
	//object ke mysql
	$dbc = new PDO('mysql:host=localhost;dbname=banking','root','');
	//fungsi validasi password
	function checkPassword($dbc,$username, $pass){
        try{
			//perintah untuk select password berdasarkan username dan password
            //$dbc = new PDO('mysql:host=localhost;dbname=myapp','root','');
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $dbc->prepare("SELECT * FROM customer WHERE NO_REK = :username and PASSWORD = SHA2( :password , 0) ");
            $statement->bindValue(':username', $username);
            $statement->bindValue(':password', $pass);
            $statement->execute();
        }
        catch (PDOException $err){
            $err->getMessage();
            echo $err;
        }
        return $statement->rowCount() > 0;
    }
	//validasi password
	function validatePass($dbc,$Username,$inPass){
		$pass_eror1 = " ";
		//jika password dan username ada 
		if (checkPassword($dbc,$Username, $inPass)){
			$go=true;
		}
		//jika password kosong 
		else if(empty($_POST["pass"])){
			$pass_eror1 = "please fill the password form<br>";$go = false;
		}
		//jika passwor dan salah 
		else{
			$pass_eror1 = "wrong password<br>";$go = false;
		}
		return array($pass_eror1,$go);
	}
	//fungsi mendapatkan saldo terakhir 
	function getSaldo($dbc,$username){
		try{
			$nilai = $dbc->prepare("SELECT MAX(ID_RIWAYAT) AS ID FROM `riwayat` WHERE NO_REK = :username ");
			$nilai->bindValue(':username', $username);
			$nilai->execute();			
		}
		catch (PDOException $err){
			$err->getMessage();echo $err;
		}
		foreach($nilai as $ket){
			try{
				$saldo = $dbc->prepare("SELECT * FROM `riwayat` WHERE NO_REK = :username AND ID_RIWAYAT = :ID ");
				$saldo->bindValue(':username', $username);
				$saldo->bindValue(':ID', $ket['ID']);
				$saldo->execute();
				foreach($saldo as $saldo){
					$max_trans = $saldo["SALDO"];
				}
			}
			catch (PDOException $err){
				$err->getMessage();echo $err;
			}
		}
		return $max_trans;
	}
	//fungsi update data 
	function update($dbc,$rekening,$nama,$phone,$alamat,$email){
		try{
            //$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $dbc->prepare("UPDATE customer SET 
			NAMA = :name,
			ALAMAT = :alamt,
			EMAIL = :email ,
			NO_HP = :hp 
			WHERE NO_REK = :no_rek ");
            $statement->bindValue(':name', $nama);
			$statement->bindValue(':alamt', $alamat);
			$statement->bindValue(':email', $email);
			$statement->bindValue(':hp', $phone);
			$statement->bindValue(':no_rek', $rekening);
            $statement->execute();
        }
        catch (PDOException $err){
            $err->getMessage();
            echo $err;
        }
	}
	//fungsi update email 
	function updateMail($dbc,$rekening,$email){
		try{
            //$dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $dbc->prepare("UPDATE customer SET 
			EMAIL = :email , 
			WHERE NO_REK = :no_rek ");
			$statement->bindValue(':email', $email);
			$statement->bindValue(':no_rek', $rekening);
            $statement->execute();
        }
        catch (PDOException $err){
            $err->getMessage();
            echo $err;
        }
	}
	//fungsi update password
	function updatePass($dbc, $password, $no_rek){
		try{
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $dbc->prepare("UPDATE customer SET 
			PASSWORD= :pass 
			WHERE NO_REK = :no_rek ");
			$statement->bindValue(':pass', $password);
			$statement->bindValue(':no_rek', $no_rek);
            $statement->execute();
        }
        catch (PDOException $err){
            $err->getMessage();
            echo $err;
        }
	}
	//chek keberadaan username (digunakan untuk validasi nama)
	function checkN($username){
        try{
			$dbc = new PDO('mysql:host=localhost;dbname=banking','root','');
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $dbc->prepare("SELECT * FROM customer WHERE NAMA = :username");
            $statement->bindValue(':username', $username);
            $statement->execute();
        }
        catch (PDOException $err){
            $err->getMessage();
            echo $err;
        }
        return $statement->rowCount() > 0;
    }
	//fungsi validasi nama/username 
	function validateName($inName){
		$name = '';
		$namei = $inName;
		$pattern_name = "%([a-zA-Z'_]+[0-9]{0,6}|[a-zA-Z'_]+)%";
		if(empty($inName)){$name = "please fill the surename form<br>";$go = false;}
		else if(!preg_match($pattern_name, $inName))
			{$name = 'input must first with alphabet and no space and end with numeric value <br>';$go = false;}
		else if(checkN($inName)){$name = 'name is avaliable <br>';$go = false;}
		else if($namei == $inName){$go = true;}
		else{$go = true;}
		return array($name,$go);
	}
	//fungsi validasi nomor tepon
	function validatePhone($number){
		$pattern_phone = "/^[0-9]*$/";
		$nomor_eror=" ";
		if(empty($number)){
			$nomor_eror="please fill the phone form<br>";
			$go = false;
		}
		//jika inputan bukan angka
		else if(!preg_match($pattern_phone, $number)){
			$nomor_eror = 'must contain numeric only<br>';
			$go = false;
		}
		//jika tidak memenuhi syarat telfon 
		else if(strlen($number)<10 && strlen($number)>14 ){
			$nomor_eror = 'number must in range 10 - 14';
			$go = false;
		}
		//jika kondisi benar
		else{
			$go = true;
		}
		return array($nomor_eror,$go);
	}
	//fungsi validasi address
	function validateAddr($inName){
		$name = '';
		$pattern_name = "%[a-zA-Z]+[.:]? ([a-zA-Z]+|[a-zA-Z]+ [a-zA-Z]+|[a-zA-Z]+ [a-zA-Z]+ [a-zA-Z]+) ([a-zA-Z]+[.: ]?[1-9]{1,4} [a-zA-Z]+[.: ]?[1-9]{1,4}|[a-zA-Z]+[.: ]?[1-9]{1,4}) [a-zA-Z]+ [a-zA-Z]+%";
		//jika inputan kosong
		if(empty( $inName )|| $inName =='')
			{$name = "please fill the adr form form<br>";$go = false;}
		//jika inputan address salah 
		else if(!preg_match($pattern_name, $inName )){
				$name = 'wrong input addr ';$go = false;
			}
		//jika kondisi sudah benar
		else{
			$go = true;
		}
		return array($name,$go);
	}
	//fungsi validasi email
	function validatEmail($inEmail){
		$email_eror = "";
		if(empty($inEmail))
			{$email_eror = "please fill email form<br>";$go = false;}
		else if (!filter_var($inEmail, FILTER_VALIDATE_EMAIL))
			{$email_eror = 'email wrong<br>';$go = false;}
		else{$go=true;}
		return array($email_eror,$go); 
	}
	//chek ada account bank atau tidak 
	function checkAcc($username){
        try{
			$dbc = new PDO('mysql:host=localhost;dbname=banking','root','');
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $dbc->prepare("SELECT * FROM customer WHERE NO_REK = :username");
            $statement->bindValue(':username', $username);
            $statement->execute();
        }
        catch (PDOException $err){
            $err->getMessage();
            echo $err;
        }
        return $statement->rowCount() > 0;
    }
	
	//validasi account bank
	function validateAcc($in,$out){
		$acc = "";
		if($in == $out){
			$acc = "cannot send to self account";$go = false;
		}
		else if (checkAcc($out)){
			$go=true;
		}
		else if(empty($out)){
			$acc = "please fil the form<br>";$go = false;
		}//
		else{
			$acc = "not found";$go = false;
		}
		return array($acc,$go);
	}
	
	//validasi nilai yang akan di transfer 
	function validateVal($valInput,$myAcc,$dbc){
		$pattern_phone = "/^[0-9]*$/";
		$nomor_eror=" ";
		$saldo = getSaldo($dbc,$myAcc);
		$go = false;
		if(empty($valInput)){
			$nomor_eror="please fill the value form<br>";
			
		}
		else if(!preg_match($pattern_phone,$valInput)){
			$nomor_eror="must contain numeric only <br>";
		}
		
		else if((float) $valInput > $saldo){
			$nomor_eror="value is more than max <br>";
		}
		else {$go = true;}
		return array($nomor_eror,$go);
		}
	
	//fungsi untuk tranfer uang 
	function transfer($dbc,$no_rek,$cus_no_rek,$value){
		try{
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			//nilai untuk kredit
			$saldo_no_rek = getSaldo($dbc,$no_rek) - $value;
			//nilai untuk debit
			$saldo_cus_no_rek = getSaldo($dbc,$cus_no_rek) + $value;
			$statement = $dbc->prepare('INSERT INTO transfer (NO_REK, CUS_NO_REK) VALUES ( :nr , :cnr )');
			$statement->bindValue(':nr', $no_rek);
			$statement->bindValue(':cnr', $cus_no_rek);
			$statement->execute();
			//nilai yang dinput yaitu nilai no.rekenig,nilai id transfer terakhir, nilai debet atau kredit, dan nilai saldo yang terakhir
			$statement = $dbc->prepare(
			"INSERT INTO `riwayat` (`NO_REK`, `ID_TRANSFER`, `SALDO`, `KREDIT`) 
			VALUES ( :nr ,(SELECT MAX(ID_TRANSFER) AS ID FROM `transfer` WHERE NO_REK = :nr AND CUS_NO_REK = :cnr ), :sn , :val );
			INSERT INTO `riwayat` (`NO_REK`, `ID_TRANSFER`, `SALDO`, `DEBET`) VALUES  
			( :cnr , (SELECT MAX(ID_TRANSFER) AS ID FROM `transfer` WHERE NO_REK = :nr AND CUS_NO_REK = :cnr  ), :scsn , :val )"
			);
			$statement->bindValue(':nr' , $no_rek);
			$statement->bindValue(':cnr' , $cus_no_rek);
			$statement->bindValue(':val', $value);
			$statement->bindValue(':sn', $saldo_no_rek);
			$statement->bindValue(':scsn', $saldo_cus_no_rek);
			$statement->execute();
        }
        catch (PDOException $err){
            $err->getMessage();
            echo $err;
        }
	}
?>