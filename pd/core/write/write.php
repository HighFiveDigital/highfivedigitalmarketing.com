<?php

namespace pd\core;

class write extends \pd\main {
  
  public $document = 'html'; 
  public function start($document) {
    $this->document = $document;
  }
  
  public function finish() {
    $this->document = 'html';
  }
  
  public function pd_link($data, $type = '') {
    echo pd($this->get_parent(), 'urls')->get_url($data, $type);
  }
  
  public function a_tag($url, $label) {
    echo '<a href="'.$url.'">'.$label.'</a>';
  }
  
  public function full_link($data) {
    echo $this->get_url_prefix().pd($this->pd_parent->get_pd())->get_pd_link($data);
  }
  
  
  /**
   * Date
   * @return 
   * @param object $output
   * @param object $data[optional]
   */
  
  public function date($date, $format = 'ago', $data = array()) {
    switch($format) {
      case 'ago':
        return $this->build_ago($date);
    }
  }
  
  public function build_ago($date) {
    $unix = strtotime($date);
  	
  	$dif = time() - $unix; //local fix
  //		$dif = time() - $unix;
  	
  	if ($dif == 0) {
  	  echo 'now';
  	}
  	else if ($dif < 60) {
  		if ($dif == 1) {
  			echo "a second ago";
  		}
  		else {
  			echo "$dif seconds ago";
  		}
  	}
  	else if ($dif < 60*60) {
  		$mins = floor($dif/60);
  		
  		if ($mins == 1) {
  			echo "a minute ago";
  		}
  		else {
  			echo "$mins minutes ago";
  		}
  	}
  	else if ($dif < 60*60*24) {
  		$hours = floor($dif/(60*60));
  		
  		if ($hours == 1) {
  			echo "an hour ago";
  		}
  		else {
  			echo "$hours hours ago";
  		}
  	}
    else if ($dif < 60*60*24*6) {
  		$days = floor($dif/(60*60*24));
  		
  		if ($days == 1) {
  			echo "yesterday";
  		}
  		else {
  			echo 'on '.strtolower(date('l', $unix));
  		}
  	}
    else {
      echo 'on '.strtolower(date('F j, Y', $unix));
    }
  }
  
  
  
  public function str($output, $data = array()) {
    $this->set_default($data, 'format', 'line');
    echo $this->format($output, $data['format'], $data);
  }
  
  public function get($data, $field = '') {
    $this->set_default($data, 'format', 'line');
    
    $output = pd($this->pd_parent->get_pd())->get($data, $field);
    if (!empty($output)) {
      echo $this->format(pd('filter')->output_str($output, $this->document), $data['format'], $data);
    }
  }
  
  
  
  private $formats = array(
      'line' => array('remove_newlines', 'trim'),
      'paragraph' => array('trim', 'html_newlines', 'html_spaces', 'html_links'),
      'textarea' => array()
    );
  
  public function format($output, $format, $data = array()) {
    if (!empty($this->formats[$format])) {
      foreach ($this->formats[$format] as $filter) {
        $output = $this->apply_filter($output, $filter, $data);
      }
    }
    return $output;
  }
  
  public function apply_filter($output, $filter, $data) {
    switch($filter) {
      case 'remove_newlines':
        return str_replace(array("\r\n", "\r", "\n"), " ", $output);
      case 'trim':
        return $this->trim_str($output, $data['length']);
      case 'html_newlines':
        return str_replace(array("\r\n", "\r", "\n"), " <br/> ", $output);
      case 'html_spaces':
        return str_replace("  ", "&ensp; ", $source);
      case 'html_links':
        return $this->html_links($output);
    }
  }
  
  private function trim_str($source, $size) {
    if (strlen($source) > $size && !empty($size)) {
	    $source = substr($source, 0, $size).'...';
    }   
    return $source; 
  }
  
  private function html_links($string) {
    $ret = ' ' . $string;
    $ret = preg_replace("#(^|[\n \(\)])([\w]+?://[\w]+[^ \"\n\r\t\(\)<]*)#ise", "'\\1<a href=\"\\2\" target=\"_blank\">\\2</a>'", $ret);
    $ret = preg_replace("#(^|[\n \(\)])((www|ftp)\.[^ \"\t\n\r\(\)<]*)#ise", "'\\1<a href=\"http://\\2\" target=\"_blank\">\\2</a>'", $ret);
    $ret = preg_replace("#(^|[\n \(\)])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+\.)*[\w]+)#i", "\\1<a href=\"mailto:\\2@\\3\">\\2@\\3</a>", $ret);
    $ret = substr($ret, 1);

	  return $ret;
	}
  
  
  
}

?>