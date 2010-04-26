<?php
namespace PSpec;

class ExpectationResult{
    protected $success;
    protected $expectationType;
    protected $expectationText;
    protected $message;

    function  __construct($success, $expectationType, $message) {
        $this->success =  $success;
        $this->expectationType = $expectationType;
        $this->message = $message;
    }

    function countExamples() {
        $count = 0;
        foreach($this->results as $result) {
            $count += $result->count();
        }
        return $count;
    }

    function failed() {
        return !$this->success;
    }

    function getSuccess() {
        return $this->success;
    }

    function getExpectationType() {
        return $this->expectationType;
    }

    function getMessage() {
        return $this->message;
    }
}