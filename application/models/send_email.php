<?php 
class send_email extends CI_Model {
    public function send($to, $subject, $body) {
        $ci = get_instance();
        $ci->load->library('email');
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.gmail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = "test.alnaharsolutions@gmail.com";
        $config['smtp_pass'] = "654654123";
        $config['charset'] = "utf-8";
        $config['mailtype'] = "html";
        $config['newline'] = "
";
        $ci->email->initialize($config);
        $ci->email->from("test.alnaharsolutions@gmail.com", 'Test Email');
        $list = array($to);
        $ci->email->to($list);
        $ci->email->subject($subject);
        $ci->email->message($body);
        $status = $ci->email->send();
        return $status;
    }
}