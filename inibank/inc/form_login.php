<div class="login">
    <div class="headform">
        <h3 class="center">Masuk Admin</h3>
    </div>
    <form method="POST" action="admin_login.php">
        <label>Username</label>
        <input type="text" name="username" placeholder="username.." value="<?php if(isset($_POST['username'])) echo htmlspecialchars($_POST['username'])?>">
        <p class="error"><?php echo "$erusername"; ?></p>

        <label>Password</label>
        <input type="password" name="password" placeholder="password.." value="<?php if(isset($_POST['password'])) echo htmlspecialchars($_POST['password'])?>">
        <p class="error"><?php echo "$erpassword"; ?></p>

        <p class="error"><?php echo "$erdata"; ?></p>
        
        <input type="submit" value="Masuk" name="masuk">
    </form>
</div>