<?php
namespace PSpec;

class ExampleBefore extends ExampleItem {
    protected $function;
    
    function  __construct(\Closure $function) {
        $this->function = $function;
    }

    /**
     * @param  $function
     * @return ExampleBefore
     */
    static function buildExampleBefore(\Closure $function) {
        return new ExampleBefore($function);
    }

    function toString($level) {
        $s = str_repeat('::::::', $level) . "before\n";
        return $s;
    }

    function run(ResultGroup $resultGroup) {
        $f = $this->function;
        $f();
    }
}
