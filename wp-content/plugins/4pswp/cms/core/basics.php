<?php
function debug($var = false, $showHtml = false, $showFrom = true) {
	if ($showFrom) {
		$calledFrom = debug_backtrace();
		echo '<strong>' . substr(str_replace(APP_PATH, '', $calledFrom[0]['file']), 1) . '</strong>';
		echo ' (line <strong>' . $calledFrom[0]['line'] . '</strong>)';
	}
	echo "\n<pre class=\"4pswp-debug\" style=\"background-color:#D4F1F9; border: 1px solid #2B6B7F;padding:5px;\">\n";

	$var = print_r($var, true);
	if ($showHtml) {
		$var = str_replace('<', '&lt;', str_replace('>', '&gt;', $var));
	}
	echo $var . "\n</pre>\n";
}