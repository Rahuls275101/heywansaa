<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Dmailer {

  private $CI;

  public function __construct() {

    $this->CI = &get_instance();
    $config = array(
        'protocol' => 'smtp',
        'smtp_host' => 'email-smtp.us-east-1.amazonaws.com',
        'smtp_port' => 587,
        'smtp_user' => 'AKIA5MPCN64FNOYRPXGG',
        'smtp_pass' => 'BMrpcpiDBxQpxmhp8fMRur7AlBhKWStcx2Ace6Ta3xJY',
        'smtp_crypto' => 'tls'
    );
    

    
    
    $this->CI->load->library('email');
    //$this->CI->email->initialize($config);
  }

  public function mail_notify($mail_conf = array()) {

    if (is_array($mail_conf) && !empty($mail_conf)) {

      $mail_to = $mail_conf['to_email'];
      $mail_subject = $mail_conf['subject'];
      $from_email = $mail_conf['from_email'];
      $from_name = $mail_conf['from_name'];
      $body = $mail_conf['body_part'];
      $file = @$mail_conf['attachment'];
      $cc = @$mail_conf['cc'];
      $bcc = @$mail_conf['bcc'];
      $alternative_msg = @$mail_conf['alternative_msg'];
      $debug = @$mail_conf['debug'];


      $this->CI->email->set_newline("\r\n");
      $this->CI->email->set_mailtype('html');
      $this->CI->email->from('info@weblieu.com', $from_name);
      $this->CI->email->reply_to('info@weblieu.com', $from_name);
      $this->CI->email->to($mail_to);

      if ($cc != '') {
        $this->email->cc($cc);
      }
      if ($bcc != '') {
        $this->email->cc($bcc);
      }

      if ($alternative_msg != '') {
        $this->email->set_alt_message($alternative_msg);
      }
      if ($file != '' && file_exists($file)) {
        $this->CI->email->attach($file);
      }
      $this->CI->email->subject($mail_subject);
      $this->CI->email->message($body);
      @$this->CI->email->send();

      if ($debug) {
        $this->CI->email->print_debugger();
      }

      $this->CI->email->clear(TRUE);
    }
  }

}

// END Form Email mailer  Class
/* End of file Dmailer.php */
/* Location: ./application/libraries/Dmailer.php */