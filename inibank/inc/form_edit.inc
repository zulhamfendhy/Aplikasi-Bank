<form name="myForm" method="POST" action="admin_editcustomer.php">
	<div class="form-row">
		<div class="col-25"><label>No. Rekening</label></div>
		<div class="col-40"><input type="text" name="rekening" value="<?php if(isset($_POST['rekening'])) echo htmlspecialchars($_POST['rekening'])?>" readonly></div>
		<div class="col-35"><?php echo $errekening; ?></div>
	</div>

	<div class="form-row">
		<div class="col-25"></div>
		<div class="col-40"><input type="hidden" name="saldo" value="100" readonly></div>
		<div class="col-35"></div>
	</div>

	<div class="form-row">
		<div class="col-25"><label>Nama</label></div>
		<div class="col-40"><input type="text" name="nama" value="<?php if(isset($_POST['nama'])) echo htmlspecialchars($_POST['nama'])?>"></div>
		<div class="col-35"><?php echo $ernama; ?></div>
	</div>

	<div class="form-row">
		<div class="col-25"><label>Alamat</label></div>
		<div class="col-40"><input type="text" name="alamat" value="<?php if(isset($_POST['alamat'])) echo htmlspecialchars($_POST['alamat'])?>"></div>
		<div class="col-35"><?php echo $eralamat; ?></div>
	</div>
			
	<div class="form-row">
		<div class="col-25"><label>Email</label></div>
		<div class="col-40"><input type="text" name="email" value="<?php if(isset($_POST['email'])) echo htmlspecialchars($_POST['email'])?>"></div>
		<div class="col-35"><?php echo $eremail; ?></div>
	</div>

	<div class="form-row">
		<div class="col-25"><label>No. Telepon</label></div>
		<div class="col-40"><input type="text" name="telepon" value="<?php if(isset($_POST['telepon'])) echo htmlspecialchars($_POST['telepon'])?>"></div>
		<div class="col-35"><?php echo $ertelepon; ?></div>
	</div>

	<div class="form-row">
		<div class="col-25"><label>Username</label></div>
		<div class="col-40"><input type="text" name="username" value="<?php if(isset($_POST['username'])) echo htmlspecialchars($_POST['username'])?>"></div>
		<div class="col-35"><?php echo $erusername; ?></div>
	</div>

	<div class="form-row">
		<div class="col-25"><label>Password</label></div>
		<div class="col-40"><input type="password" name="password" value=""></div>
		<div class="col-35"><?php echo $erpassword; ?></div>
	</div>

	<div class="form-row">
		<div class="col-25"><label>Konfirmasi Password</label></div>
		<div class="col-40"><input type="password" name="conpassword" value=""></div>
		<div class="col-35"><?php echo $erconpassword; ?></div>
	</div>

	<div class="form-row">
		<div class="col-25"></div>
		<div class="col-40">
			<input type="submit" name="submit" value="Edit">
			<a class="button" href="./admin_daftarcustomer.php">Batal</a>
		</div>
	</div>
</form>