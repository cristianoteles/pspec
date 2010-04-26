<?php
namespace PSpec;

class BeAnInstanceOf implements assertion{
    function execute($subject, $expectedClassName) {
        $message = get_class($subject)
                .' <span class="expectationText">should be an instance of</span> '
                . $expectedClassName;

        return new ExpectationResult(
            ($subject instanceof $expectedClassName),
            $message
        );
    }
}