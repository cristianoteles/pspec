<?php
namespace PSpec;

class BeEquals implements assertion{

    function execute($subject, $expectedValue) {
        $message = var_export($subject,1)
                .' <span class="expectationText">should be equals</span> '
                . var_export($expectedValue,1);

        return new ExpectationResult(
            ($subject === $expectedValue),
            $message
        );
    }
    
}