<?php
namespace pd\core;
class lists extends \pd\main {
  
  private $results;
  private $data;
  public $cur_result = array();
  public $last_result = array();
  
  public function start($data) {
    $this->set_default($data, 'page', 1);
    $this->set_default($data, 'num', 10);
    
    //define match
    //define order
    
    if (!empty($data['select'])) {
      //perform list query
      $list = pd($this->pd_parent->get_pd(), 'query')->select($data);
    }
    else {
      $this->set_default($data, 'table', pd($this->pd_parent->get_pd(), 'tables')->get_default());
      $this->set_default($data, 'order', array('time_stamp' => 'desc'));
      $list = pd('lists', 'query')->select(array('select' => 'lists', 'table' => $data['table'], 'list' => $data));
    }
    //store total results
    $data['total'] = pd('query')->get_count();
    
    //build link ary for all items in ary that are necessary for page to build
    
    $data['link'] = $this->get_link_ary($data);
    
    $this->cur_result[$this->get_parent()] = 0;
    $this->last_result[$this->get_parent()] = 0;
    
    $this->results[$this->get_parent()] = $list;
    $this->data[$this->get_parent()] = $data;
  }
  
  public function get_next() {
    if (!empty($this->results[$this->get_parent()][$this->cur_result[$this->get_parent()]])) {
      $next = $this->results[$this->get_parent()][$this->cur_result[$this->get_parent()]];
      $this->cur_result[$this->get_parent()]++;
      return $next;
    }
    return false;
  }
  
  public function get_last() {
    $result = count($this->results[$this->get_parent()]) - $this->last_result[$this->get_parent()] - 1;

    if (!empty($this->results[$this->get_parent()][$result])) {
      $next = $this->results[$this->get_parent()][$result];
      $this->last_result[$this->get_parent()]++;
      return $next;
    }
    return false;
  }
  
  public function control($data) {
    $this->set_default($data, 'file', 'pages');
    
    $data['list'] = $this->data[$this->get_parent()];

    pd('lists')->build('html', $data);
  }
  
  public function get_link_ary($data) {
    //return array_diff_key($data, );
  }
  public function build_link($data, $label) {
		return '<a href="'.pd(pd('lists')->get_parent(), 'urls')->get_url($data, $data['list']['url']).'">'.$label.'</a>';
	}
  
  public function is_empty() {
    if (empty($this->results[$this->get_parent()])) {
      return true;
    }
    return false;
  }

}
?>