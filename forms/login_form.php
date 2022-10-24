<form class="reg_form" method = "post" action="do_login.php">
    <div class = "reg_title">Log in</div>
    <div class="input log">
         <label for="username">Username</label>
         <input type="text" name="username" id="username" required>
         <span class="spin"></span>
      </div>
      <div class="input log">
         <label for="password">Password</label>
         <input type="password" name="password" id="password" required>
         <span class="spin"></span>
      </div>
    <button type="submit" class="log_button">Log in</button>
    <?php flash(); ?>
</form>
