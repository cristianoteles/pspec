<?php
namespace PSpec;

class ResultReporter {

    private function  __construct() {}

    /**
     * @param ResultGroup $resultGroup
     * @return ResultReporter
     */
    static function build() {
        return new ResultReporter();
    }

    function report($resultGroup) {
        $html = "";
        if($resultGroup instanceof ExampleResult) {
            $html .= $this->reportExampleResult($resultGroup);
        }
        else if($resultGroup instanceof ResultGroup) {
            $html .= $this->reportResultGroup($resultGroup);
        }
        return $html;
    }

    function reportExampleResult(ExampleResult $exampleResult) {
        $name = self::slugify($exampleResult->getExampleGroupName()) . rand(1,5000);
        $html =
            "<div class='exampleResult'>" . $this->getStatusBox($exampleResult)
            . "<span class='resultGroupTitle'>" . $exampleResult->getExampleGroupName() 
            . "</span>";
        switch($exampleResult->calculateStatus()) {
            case ResultGroup::STATUS_ERROR:
                $html .= 
                    "<a href='javascript:;' onclick='$(\"#$name\").toggle()'>+++</a>"
                    ."<br/><div id='$name' class='errors' style='display:none';>" .nl2br($exampleResult->getError()) . '</div>';
                break;
            case ResultGroup::STATUS_FAILURE:
                $html .=
                    "<a href='javascript:;' onclick='$(\"#$name\").toggle()'>+++</a>"
                    . "<br/><div id='$name' class='failures' style='display:none;'>";
                foreach($exampleResult as $num=>$expectationResult) {
                    if($expectationResult->failed()) {
                        $html .= $expectationResult->getMessage() . '<span class="expectationNumber"> - expectation # '. ( $num + 1) . '</span>';
                    }
                }
                $html .= '</div>';
                break;
            case ResultGroup::STATUS_SUCCESS:

                break;

        }
        $html .= "</div>";
        return $html;
    }

    

    private function reportResultGroup(ResultGroup $resultGroup) {
        $name = self::slugify($resultGroup->getExampleGroupName()) . rand(1,5000);
        $html =
            "<div class='resultGroup'>" . $this->getStatusBox($resultGroup)
            ."<span class='resultGroupTitle'>" . $resultGroup->getExampleGroupName() . "</span>"
            ."<span class='resultGroupData'>"
            ."examples: " . $resultGroup->countExamples() . " | "
            ."failures: " . $resultGroup->countFailures() . " | "
            ."incomplete: " . $resultGroup->countIncomplete()
            ."&nbsp;&nbsp;&nbsp;<a href='javascript:;' onclick='$(\"#$name\").toggle()'>(show / hide inner examples)</a>"
            ."</span>";

        if($resultGroup instanceof SpecResult) {
            $html .= "<span>";

            $specData = $resultGroup->getSpecData();
            $html .= " || file:" . $specData->getFilename();
            $html .= " || spec:" . $specData->getName();

            $html .= "</span>";
        }

        $html .= "<div class='innerResults' id='$name'>";
        foreach($resultGroup as $innerResultGroup) {
            $html .= $this->report($innerResultGroup);
        }
        $html .= "</div></div>";
        return $html;
    }

    function calculateHtmlClass(ResultGroup $resultGroup) {
        return $resultGroup->calculateStatus();
    }

    function getStatusBox($resultGroup) {
        return "<div style='width:20px; border:solid 1px; margin-right: 5px; display:inline;' class='" . $this->calculateHtmlClass($resultGroup) . "'>...</div>";
    }

    
    static public function slugify($text)
    {
        $text = preg_replace('~[^\\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        if (function_exists('iconv'))
        {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        $text = strtolower($text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        {
            return 'n-a';
        }
        return $text;
    }
    
}