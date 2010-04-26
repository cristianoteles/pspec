<?php
namespace PSpec;

include_once "assertion.php";
include_once "assertions/BeEquals.php";
include_once "assertions/BeAnInstanceOf.php";
include_once "assertions/BeBetween.php";
include_once "assertions/OnlyHaveInstancesOf.php";

class Expectation {
    
    protected $subject;

    function  __construct($subject) {
        $this->subject = $subject;
    }

    function should($assertionName,$expectedValue) {
        $args = func_get_args();
        $registeredAssertions = array(
            'be equals' => '\PSpec\BeEquals',
            'be an instance of' => '\PSpec\BeAnInstanceOf',
            'be between' => '\PSpec\BeBetween',
            'only have instances of' => '\PSpec\OnlyHaveInstancesOf'
        );
        if(!array_key_exists($assertionName,$registeredAssertions)) {
            throw new Exception('Assertion "' . $assertionName . '" does not exists');
        }
        $assertionClass = $registeredAssertions[$assertionName];
        $assertion = new $assertionClass;
        $args[0] = $this->subject;
        $expectationResult = call_user_func_array(array($assertion,'execute'), $args);
        Example::addExpectationResultToOpenExampleResult($expectationResult);
    }
}