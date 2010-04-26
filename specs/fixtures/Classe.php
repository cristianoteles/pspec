<?php
namespace PSpec\Spec;
class Classe{
    private $segredo;
    public  $todosSabem;

    public function setTodosSabem($v) {$this->todosSabem = $v;}
    public function getTodosSabem()   {return $this->todosSabem;}
    public function setSegredo($v) {$this->segredo = $v;}
    public function getSegredo()   {return $this->segredo;}
}