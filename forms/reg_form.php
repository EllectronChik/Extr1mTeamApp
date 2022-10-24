<form class="reg_form" method = "post" action="do_register.php">
    <div class = "reg_title">Register</div>
    <div class = "r_st">
    <span class="input reg">
         <label for="username">Username</label>
         <input type="text" name="username" id="username" required>
         <span class="spin"></span>
      </span>
      <span class="input reg">
         <label for="password">Password</label>
         <input type="password" name="password" id="password" required>
         <span class="spin"></span>
      </span>
</div>
      <div class = "r_st">

      <span class="input reg">
         <label for="email">Email</label>
         <input type="test" name="email" id="email" required>
         <span class="spin"></span>
      </span>
      <span class="input reg">
         <label for="re_password">Re-enter the password</label>
         <input type="password" name="re_password" id="re_password" required>
         <span class="spin"></span>
      </span>
</div>
<div class = "reg_b">
    <button type="submit" class="reg_button">Register</button>
    <?php flash(); ?></div>
</form>
