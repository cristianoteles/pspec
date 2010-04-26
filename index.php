<?php namespace PSpec; ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<script type="text/javascript" src="jquery.min.js"></script>
<style>
    body{
        font-family: arial,verdana, sans-serif;
    }
    .resultGroup{
        padding:10px;
        padding-left: 15px;
        border: solid 1px #eee;
    }
    .exampleResult{
        padding:5px;
        padding-left: 15px;
    }
    .expectationText{
        background-color: #ccc;
    }
    .expectationNumber{
        font-size: 0.7em;
    }
    .failures{
        background-color: #eee;
        margin: 10px;
        padding:3px;
    }
    .errors{
        background-color: #eee;
        margin: 10px;
        padding:3px;
    }
    .innerResults{
        margin-top: 5px;
        border-left: solid 1px;
    }
    .resultGroupTitle{
        color: #003;
    }
    .resultGroupData{
        margin-left: 20px;
        font-size: 0.8em;
        color: #555;
    }
    .FAILURE{
        background-color: #ee3;
    }
    .INCOMPLETE{
        background-color: #efe;
    }
    .SUCCESS{
        background-color: #fff;
    }
    .ERROR{
        background-color: #922;
    }
</style>
</head>
<?php

require_once 'lib/PSpec.php';

$descriptions = array('programador');
try {
    $resultGroup =
        PSpec::getInstance()
        ->addDescription('atributos')
        ->addDescription('heranca')
        ->run();
}
catch(\Exception $e) {
    echo nl2br($e);
}

?>
<body>
<?php echo ResultReporter::build()->report($resultGroup); ?>
</body>
</html>