<?php
namespace PSpec;

class SpecResult extends ResultGroup {
    protected $specData;

    function setSpecData(SpecData $specData) {
        $this->specData = $specData;
    }

    function getSpecData() {
        return $this->specData;
    }
}