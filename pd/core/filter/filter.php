<?php
namespace pd\core;
class filter extends \pd\main {
  
  public function init() {
    $this->input_ary($_POST);
    $this->input_ary($_GET);
    $this->input_ary($_COOKIE);
    $this->input_ary($_REQUEST);
  }
 
  public function input_ary(&$source) {
		// clean all elements in this array
    if (is_array($source)) {
  		foreach ($source as $i => $source_a) {
  				$source[$i] = $this->input_str($source_a);
      }
		  return $source;
    }
	}
  
  public function input_str(&$source, $data = array()) {
    //removes \ chars
		$source = str_replace('\\', '', $source);	
    //remove html tags
    if (!$data['tags']) {
      $source = strip_tags($source);
    }
    //$source = str_replace('<script', '', $source);
		// url decode
		$source = html_entity_decode($source, ENT_QUOTES, "ISO-8859-1");
		// convert decimal
		$source = preg_replace('/&#(\d+);/me',"chr(\\1)", $source);  // decimal notation
		// convert hex
		$source = preg_replace('/&#x([a-f0-9]+);/mei',"chr(0x\\1)", $source);  // hex notation
		// replace & with a more stable character set
    $source = str_replace('&', '-[n]-', $source);
    //adds slashes before all ' chars
		$source = addslashes($source);
    //remove extra space
    $source = trim($source);
		
		return $source;
  }
  
  
  public function output_str($source, $document = 'html') {
    switch($document) {
      case 'html':
        // put in html special chars &ensp;
        $source = htmlspecialchars($source);       
        //remove all \ characters before quotes
        $source = stripslashes($source);
        $source = str_replace('-[n]-', '&', $source);
        break;
      case 'email':
        //remove all \ characters before quotes
        $source = stripslashes($source);
        $source = str_replace('-[n]-', '&', $source);
        break;
    }
    return $source;
  }
  
}

?>