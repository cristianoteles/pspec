<?php 
    namespace PSpec;
    require_once 'lib/PSpec.php';
    try {
        $resultGroup =
            PSpec::build()
            ->addDescription('pspec')
            ->addDescription('atributos')
            ->addDescription('heranca')
            ->run();
    }
    catch(\Exception $e) {
        echo nl2br($e);
    }
    $reportHtml = ResultReporter::build()->report($resultGroup);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <script type="text/javascript" src="jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="pspec.css" />
</head>
<body><?php echo $reportHtml ?></body>
</html>