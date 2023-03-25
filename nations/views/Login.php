<?php
defined('APP') or die();
?>
<!-- Versione con Boostrap -->
<h1>Login</h1>
<form action="?option=Home&task=checkLogin" method="post">
  <div class="row m-1">
    <div class="col-3 text-end">
      <label for="username" class="control-label">Username</label>
    </div>
    <div class="col-9">
      <input type="text" name="username" id="username" class="form-control">
    </div>
  </div>
  <div class="row m-1">
    <div class="col-3 text-end">
      <label for="password" class="control-label ">Password</label>
    </div>
    <div class="col-9">
      <input type="password" name="password" id="password" class="form-control">
    </div>
  </div>
  <div class="row m-1">
    <div class="col-3 text-end">
      <input type="checkbox" name="rememberme" id="rememberme" class="form-check-input">
    </div>
    <div class="col-9 ">
      <label for="rememberme" class="form-check-label ">Remember me</label>
    </div>
  </div>
  <p class="row">
    <button type="submit" class="btn btn-large">Login</button>
  </p>
</form>
<?php if(!empty($this->message)) { ?>
<h2 class="text-bg-danger text-center"><?= $this->message() ?></h2>
<?php } ?>