<?php
namespace PSpec;

require_once 'setup.php';
require_once 'debug/Dbg.php';
require_once 'spec/Spec.php';
require_once 'SpecData.php';
require_once 'example/ExampleItem.php';
require_once 'example/Example.php';
require_once 'example/ExampleGroup.php';
require_once 'example/ExampleSpec.php';
require_once 'expectation/Expectation.php';
require_once 'result/ResultGroup.php';
require_once 'result/SpecResult.php';
require_once 'result/ExpectationResult.php';
require_once 'result/ExampleResult.php';
require_once 'reporter/ResultReporter.php';
require_once 'Exception.php';

class PSpec {

    protected $exampleGroups = array();
    private $descriptions;
    static $actualSpecData;
    static $beforeInstance;
    static $actualInstance;

    /**
     * @var PSpec
     */
    static $instance;
    /**
     * @return PSpec
     */
    static function build() {
        return new PSpec;
    }

    private function __construct() {}

    private function getDescriptionFilename($name) {
        return 'specs/'.$name.'.spec.php';
    }

    function addDescription($name) {
        $filename = $this->getDescriptionFilename($name);
        if(!file_exists($filename)) {
            throw new \InvalidArgumentException('Spec file not found: ' .$filename);
        }
        $this->descriptions[] = $name;
        return $this;
    }

    function hasDescription($name) {
        foreach($this->descriptions as $descName) {
            if($name == $name) return true;
        }
        return false;
    }
    /**
     * @return PSpec
     */
    function clearDescriptions() {
        $this->descriptions = array();
        return $this;
    }
    
    static function addExampleGroupToActual(ExampleGroup $exampleGroup) {
        self::$actualInstance->addExampleGroup($exampleGroup);
    }
    
    function addExampleGroup(ExampleGroup $exampleGroup) {
        $this->exampleGroups[] = $exampleGroup;
        return $this;
    }

    static function getActualSpecData() {
        return self::$actualSpecData;
    }

    static function setActualSpecData(SpecData $actualSpecData) {
        self::$actualSpecData = $actualSpecData;
    }

    function run() {
        // code that allows a PSpec::run() to be called inside a spec.
        // used to test the PSpec code.
        if(self::$actualInstance) {
            self::$beforeInstance = self::$actualInstance;
        }

        self::$actualInstance = $this;
        foreach($this->descriptions as $description) {
            $filename = $this->getDescriptionFilename($description);
            self::setActualSpecData(new SpecData($filename, $description));
            include( $filename );
        }
        $resultGroup = new ResultGroup('all specs');
        foreach($this->exampleGroups as $exampleGroup) {
            $resultGroup->addResult($exampleGroup->run());
        }
        
        // code that allows a PSpec::run() to be called inside a spec.
        // used to test the PSpec code.
        if(self::$beforeInstance) {
            self::$actualInstance = self::$beforeInstance;
        }
        $this->exampleGroups = array();
        return $resultGroup;
    }

    function __toString() {
        $s = "";
        foreach($this->exampleGroups as $group) {
            $s .= $group->toString(1);
        }
        return $s;
    }

}