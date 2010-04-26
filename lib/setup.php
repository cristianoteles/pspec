<?php
function exception_error_handler($errno, $errstr, $errfile, $errline ) {
    $e = new ErrorException($errstr, 0, $errno, $errfile, $errline);
    throw $e;
}
set_error_handler("exception_error_handler");