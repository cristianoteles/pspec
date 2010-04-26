<?php
namespace PSpec;

class Example extends ExampleItem{

    protected $name;
    protected $function;
    protected $expectedExceptionClass = null;
    protected static $openExampleResult;
    protected static $openExample;

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

    static function addExpectationResultToOpenExampleResult(ExpectationResult $result) {
        self::$openExampleResult->addResult($result);
    }

    static function addExpectedExceptionToOpenExample($exceptionClassName) {
        self::$openExample->setExpectedException($exceptionClassName);
    }

    function setExpectedException($exceptionClassName) {
        $this->expectedExceptionClass = $exceptionClassName;
    }
    

    /**
     * @return ExampleResult
     */
    function run() {
        $resultGroup = new ExampleResult($this->getName());
        self::$openExampleResult = $resultGroup;
        self::$openExample = $this;
        $f = $this->function;
        try {
            $f();
            if($this->expectedExceptionClass) {
                self::$openExampleResult->addResult(new ExpectationResult(
                        false,
                        'Expected ' . $this->expectedExceptionClass . ' to be thrown'
                ));
            }
        }
        catch(\Exception $e) {
            if(
                $this->expectedExceptionClass &&
                ($e instanceof $this->expectedExceptionClass)
            ) {
                self::$openExampleResult->addResult(new ExpectationResult(true));
            }
            else {
                $message = "<i>Exception Caught:</i> " . get_class($e) . "\n"
                    . '<i>message:</i>"' . $e->getMessage() . "\"\n"
                    . "<i>trace:</i><br/>"
                    . $e->getTraceAsString();
                self::$openExampleResult->setError($message);
            }
        }
        self::$openExampleResult = null;
        return $resultGroup;
    }
}