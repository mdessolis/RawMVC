<?php
defined('APP') or die();
?>
<?php
$t = new Tabella();
$t->setTitolo('Regioni del continente '.$this->tpl->name);
$t->setColonne([
    'region_id'=>"ID",
    'name'=>"Denominazione"
]);
$t->setElenco($this->tpl->list);
echo $t;
?>
<p><a href="?option=listContinents">Torna alla lista dei continenti</a></p>