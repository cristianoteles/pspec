<?php
class Dbg {

	static public $quietMode = false;
	static public $cliMode = false;

	static function includeJqueryJs() {
		echo "<script type='text/javascript' src='/js/extlibs/jquery.js'></script>";
	}

	static function func($print = true, $numStackSteps = 1) {
		$ar = debug_backtrace();
		$ret = '';

		for($a = $numStackSteps; $a >= 1; $a--) {
			$line = $ar[$a]['line'];
			$file = $ar[$a]['file'];
			$step = $ar[$a];
			if(self::$cliMode) {
				$ret .= str_repeat('   ',$a).self::showStep($step,$print,$line,$file);
			}
			else {
				$ret .= str_repeat('&nbsp;&nbsp;&nbsp;',$a).self::showStep($step,$print,$line,$file);
			}
		}
		if($print && !self::$quietMode) echo $ret;
		return $ret;
	}

	static function mark($title, $print = true) {
	//if(self::$cliMode) return self::markCli($title,$print);
		$ar = debug_backtrace();
		$ret = '';
		$line = $ar[0]['line'];

		$ret = "\n[MARK]" . $title . '(class:' . $ar[1]['class'] . ', line ' . $line . ')<br/>'."\n";
		if($print && !self::$quietMode) echo $ret;
		return $ret;
	}



	static function object($object,$linkTitle = 'object',$varDump = false,$print = true) {
		static $divCount = 0;
		$divCount++;
		$ar = debug_backtrace();
		$ret = '';
		$line = $ar[0]['line'];
		$ret = '[OBJECT]<a href="javascript:void(0);" onclick="$(\'#div-obj-'.$divCount.'\').toggle()">'.$linkTitle.'</a>';
		$ret .= '(line '.$line.')<br/>';
		$ret .= '<div id=\'div-obj-'.$divCount.'\' style="display:none;"><pre>';
		if($varDump) {
			$ret .= self::getVarDump($object);
		}
		else {
			$ret .= print_r($object,true);
		}
		$ret .= '</pre></div>';
		if($print && !self::$quietMode) echo $ret;
		return $ret;
	}

	static function x($object,$varDump = false,$die = true) {
		if($object instanceof Doctrine_Record) {
			echo "<b> DOCTRINE RECORD - CALLING toArray()</b>";
			$object = $object->toArray();
		}
		if($object instanceof Doctrine_Collection) {
			echo "<b> DOCTRINE COLLECTION - CALLING toArray()</b>";
			$object = $object->toArray();
		}
		$ar = debug_backtrace();
		$ret = '';
		$line = $ar[0]['line'];
		//print_r($ar[0]);
		$ret = $ar[0]['file'];
		$ret .= '(line '.$line.')<br/>';
		$ret .= '<div><pre>';
		if($varDump) {
			$ret .= self::getVarDump($object);
		}
		else {
			$ret .= print_r($object,true);
		}
		$ret .= '</pre></div>';

		echo $ret;
		if($die) die();
	}

	static function getVarDump($obj) {
		ob_start();
		var_dump($obj);
		return ob_get_clean();
	}

	static function showStep($step,$print,$line,$file) {
		static $divCount = 0;
		$ret = '[STEP]'.$step['class'] . $step['type'] . $step['function'];
		if(count($step['args'])) {
			$ret .= '(';
			$comma = '';
			$exp = array();
			foreach($step['args'] as $num=>$arg) {
				$divCount++;
				if(in_array(gettype($arg),array('object','array'))) {
					if(is_object($arg)) {
						$type = get_class($arg);
					}
					else {
						$type = gettype($arg);
					}
					if(self::$cliMode) {
						$argVal = 'see below';
					//$exp[] = "\n------------\n" . print_r($arg,true) . "\n------------\n";
					//$exp[] = "\n------------\n" . print_r($arg,true) . "\n------------\n";
					}
					else {
						$argVal = '<a href="javascript:void(0);" onclick="$(\'#div-step-'.$divCount.'\').toggle()">click to see</a>';
						$exp[] =
						    '<div id=\'div-step-'.$divCount.'\' style="display:none;">'
						    .print_r($arg,true)
						    .'</div>';
					}
				}
				else {
					$type = gettype($arg);
					if($type == 'string') {
						$argVal = "'".$arg."'";
					}
					else {
						$argVal = $arg;
					}
					if(!self::$cliMode) {
						$argVal = '<font style="color:#060">'.$argVal.'</font>';
					}
				}
				$ret .= $comma.' <i>' . $type . "</i> " . $argVal;
				$comma = ',';
			}
			$ret .= ')  (file:' . $file . ', line '.$line.')<br/>'."\n";
			foreach($exp as $text) {
				$ret .= '<pre>' . $text . '</pre>';
			}
		}
		return $ret;
	}
}
?>