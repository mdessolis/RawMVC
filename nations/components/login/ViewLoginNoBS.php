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
  <p class="d-flex justify-content-center">
    <label for="username" class="control-label p-3">Username</label>
    <input type="text" name="username" id="username" class="form-control">
  </p>
  <p class="d-flex justify-content-center">
    <label for="password" class="control-label p-3">Password</label>
    <input type="password" name="password" id="password" class="form-control">
</p>
  <p class="d-flex justify-content-center align-items-center">
    <input type="checkbox" name="rememberme" id="rememberme" class="form-check-input">
    <label for="rememberme" class="form-check-label p-3">Remember me</label>
</p>
  <p  class="d-flex justify-content-center align-items-center">
    <button type="submit" class="btn btn-primary">Login</button>
  </p>
</form>
<?php if(!empty($this->tpl->msg)) { ?>
<h2 class="text-bg-danger text-center"><?= $this->tpl->msg ?></h2>
<?php } ?>