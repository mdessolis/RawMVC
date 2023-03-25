<?php defined('APP') or die(); ?>
<h1>Countries</h1>
<form action="?option=continents&task=register" method="post">
  <fieldset class="bg-dark text-white">
    <legend>Edit/Insert</legend>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="country_id" class="form-label">ID</label>
      </div>
      <div class="col-9">
        <input type="text" name="country_id" value="<?= $this->model->country_id ?>" class="form-control" readonly>
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
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="area" class="form-label">Area (km<sup>2</sup>)</label>
      </div>
      <div class="col-9">
        <input type="number" name="area" value="<?= $this->model->area ?>" class="form-control">
      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="name" class="form-label">National Day</label>
      </div>
      <div class="col-9">
        <input type="date" name="national_day" value="<?= $this->model->national_day ?>" class="form-control">
      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="country_code2" class="form-label">Country code (2 letters)</label>
      </div>
      <div class="col-9">
        <input type="text" name="country_code2" value="<?= $this->model->country_code2 ?>" class="form-control">
      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="country_code3" class="form-label">Country code (3 letters)</label>
      </div>
      <div class="col-9">
        <input type="text" name="country_code3" value="<?= $this->model->country_code3 ?>" class="form-control">
      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="region_id" class="form-label">Region</label>
      </div>
      <div class="col-9">
        <select name="region_id" id="region_id" class="form-control">
          <option value="0">Choose a region</option>
          <?php
          foreach ($this->model->regions as $region) {
            $selected = $region->region_id == $this->model->region_id ? "selected" : "";
            echo "<option value=\"{$region->region_id}\" {$selected}>
                          {$region->continent_name} - {$region->region_name}
                        </option>";
          }
          ?>
        </select>

      </div>
    </div>
    <p class="m-3">
      <button type="submit" name="register" class="btn btn-primary">Register</button>
    </p>
  </fieldset>
</form>

<section class="p-3">
  <?php
  $list = $this->model->getList();
  $table = new HTMLTable();
  $table->setTableOptions('class="table table-hover "');
  $table->setHeaders(['ID', 'Name', 'Area', 'National Day', 'Code2', 'Code3', 'Region', 'ops']);
  foreach ($list as &$row) {
    $baseqs = "option=Countries&id={$row->country_id}";
    $row->edit = "<a href=\"?{$baseqs}&task=edit\"><span class=\"bi-pencil\" role=\"img\" aria-label=\"Edit\"></span></a> ";
    $row->edit .= "<a href=\"?{$baseqs}&task=canc\"><i class=\"bi-trash\"></i></a>";
  }
  $table->setList($list, ['country_id', 'name', 'area', 'national_day', 'country_code2', 'country_code3', 'region_name', 'edit']);
  echo $table->render();
  ?>
</section>