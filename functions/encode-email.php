<?php
  function encode_email($e) {
  	for ($i = 0; $i < strlen($e); $i++) { $output .= '&#'.ord($e[$i]).';'; }
  	return $output;
  }
?>
