<?php
defined('APP') or die();
?>
<?php
foreach ($this->tpl->list as $continent){
  $continent->btnRegions = "
    <a class=\"btn btn-primary\" 
       href='index.php?option=listContinents&task=listRegions&continent_id={$continent->continent_id}'>
        Regions
    </a>";
}
$t = new Tabella;
$t->setTitolo("Continenti");
$t->setColonne([
    "continent_id"=>"ID", 
    "name"        =>"Denominazione", 
    "btnRegions"  =>""
]);
$t->setElenco($this->tpl->list);
echo $t;
?>