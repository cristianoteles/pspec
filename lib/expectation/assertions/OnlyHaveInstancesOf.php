<?php
namespace PSpec;

class OnlyHaveInstancesOf implements assertion{
    function execute($subject, $expectedClassName) {
        $message = get_class($subject)
                .' <span class="expectationText">should have only instances of</span> '
                . $expectedClassName;
        foreach($subject as $item) {
            if(!($item instanceof $expectedClassName)) {
                return new ExpectationResult(false,$message);
            }
        }
        return new ExpectationResult(true);
    }
}