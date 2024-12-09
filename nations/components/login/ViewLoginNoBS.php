<?php
defined('APP') or die();
?>
<!-- Versione con Boostrap -->
<style>
.login {
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.login input {
  width: 20rem;
}
.login input[type="checkbox"] {
  width: 1rem;
}
</style>
<h1>Login</h1>
<form action="?option=login&task=checkLogin" method="post" class="login">
  <p>
    <label for="username">Username</label>
    <input type="text" name="username" id="username" >
  </p>
  <p>
    <label for="password">Password</label>
    <input type="password" name="password" id="password">
</p>
  <p>
    <input type="checkbox" name="rememberme" id="rememberme">
    <label for="rememberme">Remember me</label>
</p>
  <p>
    <button type="submit">Login</button>
  </p>
</form>
<?php if(!empty($this->tpl['msg'])) { ?>
<h2 class="text-bg-danger text-center"><?= $this->tpl['msg'] ?></h2>
<?php } ?>