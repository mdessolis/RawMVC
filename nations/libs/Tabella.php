<?php
/**
Classe Tabella HTML
*/

class Tabella {
  private $colonne = [];
  private $elenco = [];
  private $titolo = "";

  public function setTitolo($titolo){
    $this->titolo = $titolo;
  }
  public function setColonne($colonne){
    $this->colonne = $colonne;
  }

  public function setElenco($elenco){
    $this->elenco = $elenco;
  }

  public function __toString(){
    $t = !empty($this->titolo) ? "<caption class=\"caption-top text-center\">{$this->titolo}</caption>": "";
    $r = '<table class="table table-bordered table-striped">'
          . $t .
          '   <thead>
              <tr>';
    foreach($this->colonne as $nomesql=>$nome){
      $r .= "<th>{$nome}</th>";
    }
    $r.='     </tr>
             </thead>
             <tbody>';
    foreach($this->elenco as $riga){
      $r .= "<tr>";
      foreach($this->colonne as $nomesql=>$nome){
        $r .= "<td>{$riga->$nomesql}</td>";
      }
      $r .= "</tr>";
    }
    $r.= "</tbody></table>";
    return $r;
  }
}