<?php
namespace PSpec;

class ExampleResult extends ResultGroup{

    protected $error;

    function addResult($expectationResult) {
        $this->results[] = $expectationResult;
    }

    function setError($error) {
        $this->error = $error;
    }

    function getError() {
        return $this->error;
    }


    function countExamples() {
        return 1;
    }
    
    function countErrors() {
        return isset ($this->error);
    }

    function countFailures() {
        $failed = false;
        foreach($this->results as $expectationResult) {
            if($expectationResult->failed()) {
                $failed = true;
            }
        }
        return $failed ? 1 : 0;
    }
    
    function countIncomplete() {
        return (count($this->results) == 0) ? 1 : 0;
    }
}