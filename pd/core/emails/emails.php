<?php
namespace pd\core;
class emails extends \pd\main {
  public $tables = array(
    'emails' => array(
      'fields' => array(
        'to_email' => array('type' => 'varchar', 'length' => 255, 'required' => true),
        'subject' => array('type' => 'varchar', 'length' => 255),
        'message' => array('type' => 'text', 'length' => 50000)
      ),
      'connections' => array()
    )
  );
  
  private function open_email($data) {
    if ($contents = pd($this->get_parent())->get_contents('emails', $data)){
      return $contents;
    }
    else if ($contents = pd('emails')->get_contents('emails', $data)) {
      return $contents;
    }
    return false;
  }
  
  private function get_email(&$data) {
    
    if ($contents = $this->open_email($data)) {
      libxml_use_internal_errors(true);
      $email = simplexml_load_string($contents);
      $xml = explode("\n", $contents);
      $data['subject'] = $email->subject;
      $data['message'] = $email->message;
      
      if (!$email) {
        $errors = libxml_get_errors();
    
        foreach ($errors as $error) {
            //print_r($error);
            echo $this->display_xml_error($error, $xml);
        }
    
        libxml_clear_errors();
      }
      
      return true; 
    }
    else {
      $this->err('email not found');
      return false;
    } 
  }
  
  function display_xml_error($error, $xml)
  {
      $return  = $xml[$error->line - 1] . "\n";
      $return .= str_repeat('-', $error->column) . "^\n";
  
      switch ($error->level) {
          case LIBXML_ERR_WARNING:
              $return .= "Warning $error->code: ";
              break;
           case LIBXML_ERR_ERROR:
              $return .= "Error $error->code: ";
              break;
          case LIBXML_ERR_FATAL:
              $return .= "Fatal Error $error->code: ";
              break;
      }
  
      $return .= trim($error->message) .
                 "\n  Line: $error->line" .
                 "\n  Column: $error->column";
  
      if ($error->file) {
          $return .= "\n  File: $error->file";
      }
  
      return "$return\n\n--------------------------------------------\n\n";
  }
  
  
  public function send_email($data) {    
    $this->set_default($data, 'file', 'test');
    $this->req(array('to_email'), $data);
  
    if ($this->get_email($data)) {
      if (!$this->was_sent($data)) {
        $this->send($data);
        $this->store($data);
      }
    }
  }
  
  private function was_sent($data) {
    $match = $this->pd('query')->select(array(
      'select' => 'match',
      'fields' => array(
        'subject' => $data['subject'],
        'message' => $data['message'],
        'to_email' => $data['to_email']
      )
    ));
    if (!empty($match)) {
      return true;
    }
    return false;
  }
  
  private function store($data) {
    $data['action'] = 'add';
    $this->pd('actions')->execute($data);
  }
  
  private function send($data) {
    //require_once('Mail.php');
    /* mail setup recipients, subject etc */
    /*
    $headers = array(
      'From' => EMAIL_FROM,
      'To' => $to_email,
      'Subject' => $data['subject'],
      'MIME-Version' => '1.0',
      'Content-Transfer-Encoding' => '8bit',
      'Content-Type' => 'text/plain; charset=UTF-8');
    */
   
    $data['headers'] = 'From: '.EMAIL_FROM."\r\n" .
      'Reply-To: '.EMAIL_FROM."\r\n" .
      'X-Mailer: PHP/' . phpversion();
     
    mail(
      pd('filter')->output_str($data['to_email'], 'email'), 
      pd('filter')->output_str($data['subject'], 'email'), 
      pd('filter')->output_str($data['message'], 'email'), 
      $data['headers']);  
      
      
    /*
    $smtp = array(
      'host' => EMAIL_HOST,
      'port' => EMAIL_PORT,
      'auth' => true,
      'username' => EMAIL_NAME,
      'password' => EMAIL_PASSWORD);

    $mail_object =& Mail::factory('smtp', $smtp);
    
    return $mail_object->send($to_email, $headers, $data['message']);
    */
  }
  
  
}
?>