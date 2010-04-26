<?php
namespace PSpec;

class Example extends ExampleItem{

    protected $name;
    protected $function;
    protected static $openExampleResult;

    function __construct($name, \Closure $function) {
        $this->name = $name;
        $this->function = $function;
    }

    static function buildExample($name, \Closure $function) {
        return new Example($name,$function);
    }

    function getName() {
        return $this->name;
    }

    function toString($level) {
        $s = str_repeat('::::::', $level) . $this->name . "\n";
        return $s;
    }

    static function addExpectationResultToOpenResultGroup(ExpectationResult $result) {
        self::$openExampleResult->addResult($result);
    }

    function run() {
        $resultGroup = new ExampleResult($this->getName());
        self::$openExampleResult = $resultGroup;
        $f = $this->function;
        try {
            $f();
        }
        catch(\Exception $e) {
            $message = "<i>Exception Caught:</i> " . get_class($e) . "\n"
                . '<i>message:</i>"' . $e->getMessage() . "\"\n"
                . "<i>trace:</i><br/>"
                . $e->getTraceAsString();
            self::$openExampleResult->setError($message);
        }
        self::$openExampleResult = null;
        return $resultGroup;
    }
}