<?php
	$dbc = new PDO('mysql:host=localhost;dbname=banking','root','');
	function getacc($dbc,$username){
        $acc = '';
		try{
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $dbc->prepare("SELECT * FROM customer WHERE USERNAME_CUS= :username");
            $statement->bindValue(':username', $username);
            $statement->execute();
			foreach($statement as $exe){
				$acc = $exe['NO_REK'];
			}
        }
        catch (PDOException $err){
            $err->getMessage();
            echo $err;
        }
		
        return $acc;
    }
    $error = "";
    function checkP($dbc,$username, $pass){
        try{
            $dbc->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$statement = $dbc->prepare("SELECT * FROM customer WHERE USERNAME_CUS = :username and PASSWORD = SHA2( :password , 0 )");
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
	$error = "";
    if (isset($_POST['login'])){
        if (isset($_POST['login'])){
			if (checkP($dbc,$_POST['username'], $_POST['password'])){
				session_start();
				$_SESSION['user'] = getacc($dbc,$_POST['username']);
				$_SESSION['pass'] = $_POST['password'];
				$_SESSION['cust'] = true;
				header("Location: ../index.php");
				exit();
			}
			else if(empty($_POST['username'])){
					$error = $error."missing name";
				if(empty($_POST['password'])){
					$error = $error." and missing password";
				}
			}
			else if(empty($_POST['password'])){
				$error = $error." missing password";
			}
			else {
				$error = "invalid input name and password";
			}
		}
	}
?>
<!DOCTYPE html>
<html lang='id'>

<head>
    <title>Login Customer</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../css/style.css">
	
    <link rel="icon" href="../images/icon.ico">
</head>

<body>
	<div class="background">
        <div class="menu">
            <!-- BRAND LOGO -->
            <a class="logo">BANK INI</a>
            <div class="menuright">
            	<a href="../admin/admin_login.php">Admin</a>
            </div>
			
        </div>
		<div class="login">
			<div class="headform">
				<h3 class="center">Masuk Customer</h3>
			</div>
			<div class="col-100">
			<form method="POST" action="customer_login.php">
				<label>Username</label>
				<input type="text" name="username" id='username' placeholder="username.." value="<?php if(isset($_POST['username'])) echo htmlspecialchars($_POST['username'])?>">
				<p class="error"></p>
				<label>Password</label>
				<input type="password" name="password" id='password' placeholder="password.." value="<?php if(isset($_POST['password'])) echo htmlspecialchars($_POST['password'])?>">
				<p class="error"></p>
				<p class="error"><?php echo $error; ?></p>
				<input type="submit" name="login" value="Submit">
				<p></p>
			</form>
			</div>
		</div>
		</div>
	<div class="footer">
       <p>&copy; BANK INI 2018</p>
    </div>
</body>
</html>