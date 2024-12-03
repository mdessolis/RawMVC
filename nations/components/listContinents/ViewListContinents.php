<?php
defined('APP') or die();
?>
<?php
foreach ($this->tpl['list'] as $continent){
  $continent->btnRegions = "
    <a class=\"btn btn-primary\" 
       href='index.php?option=listContinents&task=listRegions&continent_id={$continent->continent_id}'>
        Regions
    </a>";
}
$t = new HTMLTable;
$t->setTitle("Continenti");
$t->setColumns([
    "continent_id"=>"ID", 
    "name"        =>"Denominazione", 
    "btnRegions"  =>""
]);
$t->setList($this->tpl['list']);
echo $t;
?>