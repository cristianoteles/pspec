<?php
namespace PSpec;

class ExampleSpec extends ExampleGroup {
    protected $specData;

    function setSpecData(SpecData $specData) {
        $this->specData = $specData;
    }

    function getSpecData() {
        return $this->specData;
    }

    /**
     * @param string $name
     * @return ExampleSpec
     */
    static function buildExampleSpec($name) {
        $exampleSpec = new ExampleSpec($name);
        return $exampleSpec;
    }

    function run() {
        $resultGroup = new SpecResult($this->getName());
        $resultGroup->setSpecData($this->specData);
        foreach($this->examples as $example) {
            $resultGroup->addResult($example->run());
        }
        return $resultGroup;
    }
}
