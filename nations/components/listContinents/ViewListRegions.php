<?php
defined('APP') or die();
?>
<?php
$t = new HTMLTable();
$t->setTitle('Regioni del continente '.$this->tpl['name']);
$t->setColumns([
    'region_id'=>"ID",
    'name'=>"Denominazione"
]);
$t->setList($this->tpl['list']);
echo $t;
?>
<p><a href="?option=listContinents">Torna alla lista dei continenti</a></p>