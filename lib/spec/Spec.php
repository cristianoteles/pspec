<?php
namespace PSpec\Spec;

function it($name, $exampleTestFunction) {
    Spec::addExampleToActual(\PSpec\Example::buildExample($name, $exampleTestFunction));
}

function expect($value) {
    return new \PSpec\Expectation($value);
}

function expectException($exceptionClassName) {
    \PSpec\Example::addExpectedExceptionToOpenExample($exceptionClassName);
}

function describe($name, $descriptionFunction ) {
    
    $oldActual = Spec::getActualExampleGroup();
    if(!$oldActual) {
        $newExampleGroup = \PSpec\ExampleSpec::buildExampleSpec($name);
        $specData = \PSpec\PSpec::getActualSpecData();
        $newExampleGroup->setSpecData($specData);
        Spec::setActualExampleGroup($newExampleGroup);
        $descriptionFunction();
        Spec::emptyActualExampleGroup();
        \PSpec\PSpec::addExampleGroupToActual($newExampleGroup);
    }
    else {
        $newExampleGroup = \PSpec\ExampleGroup::buildExampleGroup($name);
        $oldActual->addExample($newExampleGroup);
        Spec::setActualExampleGroup($newExampleGroup);
        $descriptionFunction();
        Spec::setActualExampleGroup($oldActual);
    }
}

class Spec {
    static protected $actualExampleGroup;

    static function setActualExampleGroup(\PSpec\ExampleGroup $exampleGroup) {
        self::$actualExampleGroup = $exampleGroup;
    }

    static function emptyActualExampleGroup() {
        self::$actualExampleGroup = null;
    }

    /**
     *
     * @return ExampleGroup
     */
    static function getActualExampleGroup() {
        return self::$actualExampleGroup;
    }

    static function addExampleToActual(\PSpec\Example $example) {
        self::$actualExampleGroup->addExample($example);
    }
}