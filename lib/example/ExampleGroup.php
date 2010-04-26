<?php
namespace PSpec;

class ExampleGroup extends ExampleItem {

    protected $name;
    protected $examples = array();

    //protected $function;

    function __construct($name) {
        $this->name = $name;
    }

    static function buildExampleGroup($name) {
        $exampleGroup = new ExampleGroup($name);
        return $exampleGroup;
    }
    
    function addExample(ExampleItem $example) {
        $this->examples[] = $example;
    }

    function getName() {
        return $this->name;
    }

    function toString($level) {
        $s = str_repeat('::::::', $level) . '< ' . $this->name . " >\n";
        foreach($this->examples as $example) {
            $s.= $example->toString($level + 1);
        }
        return $s;
    }

    /**
     * @return ResultGroup
     */
    function run() {
        $resultGroup = new ResultGroup($this->getName());
        foreach($this->examples as $example) {
            $resultGroup->addResult($example->run());
        }
        return $resultGroup;
    }
}