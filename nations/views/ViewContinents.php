<?php defined('APP') or die(); ?>
<h1>Continents</h1>
<form action="?option=continents&task=register" method="post">
    <fieldset class="bg-dark text-white">
        <legend>Edit/Insert</legend>
        <div class="row m-3">
            <div class="col-3 text-end">
                <label for="continent_id" class="form-label">ID</label>
            </div>
            <div class="col-9">
                <input type="text" 
                       name="continent_id" 
                       value="<?= $this->model->continent_id ?>" 
                       class="form-control"
                       readonly
                       >
            </div>
        </div>
        <div class="row m-3">
            <div class="col-3 text-end">
                <label for="name" class="form-label">Name</label>
            </div>
            <div class="col-9">
                <input type="text" name="name" value="<?= $this->model->name ?>" class="form-control">
            </div>
        </div>
        <p class="m-3">
            <button type="submit" name="register" class="btn btn-primary">Register</button>
            <button type="button" name="cancel" class="btn btn-info" onclick="window.location='?option=continents'">Reset</button>
        </p>
    </fieldset>
</form>

<section class="p-3">
    <?php
    $list = $this->model->getList();
    $table = new HTMLTable();
    $table->setTableOptions('class="table table-hover "');
    $table->setHeaders(['ID', 'Name', 'ops']);
    foreach ($list as $row) {
      $baseqs = "option=continents&id={$row->continent_id}";
      $row->edit = "<a href=\"?{$baseqs}&task=edit\"><span class=\"bi-pencil\" role=\"img\" aria-label=\"Edit\"></span></a> ";
      $row->edit .= "<a href=\"?{$baseqs}&task=canc\"><i class=\"bi-trash\"></i></a>";
    }
    $table->setList($list);
    echo $table->render();
    ?>
</section>