<?php
namespace PSpec;

class ResultGroup implements \Iterator {

    private $position = 0;
    protected $exampleGroupName;
    protected $closureBody;
    protected $results = array();

    const STATUS_ERROR      = 'ERROR';
    const STATUS_FAILURE    = 'FAILURE';
    const STATUS_INCOMPLETE = 'INCOMPLETE';
    const STATUS_SUCCESS    = 'SUCCESS';

    function __construct($exampleGroupName) {
        $this->exampleGroupName = $exampleGroupName;
        $this->position = 0;
    }

    function calculateStatus() {
        if($this->countErrors()) return self::STATUS_ERROR;
        if($this->countFailures()) return self::STATUS_FAILURE;
        if($this->countIncomplete()) return self::STATUS_INCOMPLETE;
        return self::STATUS_SUCCESS;
    }

    function countErrors() {
        $count = 0;
        foreach($this->results as $result) {
            $count += $result->countErrors();
        }
        return $count;
    }
    
    function countExamples() {
        $count = 0;
        foreach($this->results as $result) {
            $count += $result->countExamples();
        }
        return $count;
    }
    
    function countFailures() {
        $count = 0;
        foreach($this->results as $result) {
            $count += $result->countFailures();
        }
        return $count;
    }
    
    function countIncomplete() {
        $count = 0;
        foreach($this->results as $result) {
            $count += $result->countIncomplete();
        }
        return $count;
    }

    function countResults() {
        return count($this->results);
    }

    function getExampleGroupName() {
        return $this->exampleGroupName;
    }

    function addResult($result) {
        $this->results[] = $result;
    }

    function rewind() {
        $this->position = 0;
    }

    function setClosureBody($closureBody) {
        $this->closureBody = $closureBody;
    }

    function current() {
        return $this->results[$this->position];
    }

    function key() {
        return $this->position;
    }

    function next() {
        ++$this->position;
    }

    function valid() {
        return isset($this->results[$this->position]);
    }
}