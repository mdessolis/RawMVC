<?php defined('APP') or die(); ?>
<h1>Countries</h1>
<form action="?option=countriesFlags&task=register" method="post" enctype="multipart/form-data">
  <fieldset class="bg-dark text-white p-3">
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
          foreach ($this->model->getRegions() as $region) {
            $selected = $region->region_id == $this->model->region_id ? "selected" : "";
            echo "<option value=\"{$region->region_id}\" {$selected}>
                          {$region->continent_name} - {$region->region_name}
                        </option>";
          }
          ?>
        </select>

      </div>
    </div>
    <div class="row m-3">
      <div class="col-3 text-end">
        <label for="flag" class="form-label">Flag</label>
      </div>
      <div class="col-9">
        <input type="file" name="flag" id="flag">
        <input type="hidden" name="old_flag" id="old_flag" value="<?= $this->model->flag ?>">
        <?php if (!empty($this->model->flag)){ ?>
          <img src="components/countriesFlags/flags/<?= $this->model->flag ?>" 
               alt="<?= $this->model->flag?>" 
               style="max-width: 200px">
        <?php } ?>
      </div>
    </div>
    <p class="m-3">
      <button type="submit" name="register" class="btn btn-primary">Register</button>
    </p>
  </fieldset>
</form>
<?php if (!empty($this->model->message)) print "<h1>".$this->model->message."</h1>"; ?>
<section class="p-3">
  <?php
  $list = $this->model->getList();
  $table = new HTMLTable();
  $table->setColumns([
      'country_id'=>'ID', 
      'name'=>'Name', 
      'area'=>'Area', 
      'national_day'=>'National Day', 
      'country_code2'=>'Code2', 
      'country_code3'=>'Code3', 
      'region_name'=>'Region', 
      'edit'=>'ops'
  ]);
  foreach ($list as &$row) {
    $baseqs = "option=countriesFlags&id={$row->country_id}";
    $row->edit = "<a href=\"?{$baseqs}&task=edit\"><span class=\"bi-pencil\" role=\"img\" aria-label=\"Edit\"></span></a> ";
    $row->edit .= "<a href=\"?{$baseqs}&task=canc\"><i class=\"bi-trash\"></i></a>";
  }
  $table->setList($list);
  echo $table;
  ?>
</section>