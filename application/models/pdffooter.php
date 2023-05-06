<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class pdffooter extends CI_Model {
    public function generateHtmlFile($party_name, $foot_note, $footerType = "") {
        $footerData['party_name'] = $party_name;
        $footerData['foot_note'] = $foot_note;
        $footerData['footer_type'] = $footerType;
        $footerD = $this->load->view('template/report_footer', $footerData, true);
        $randFileName = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 10);
        $footerFileName = 'footer-' . $randFileName . '.html';
        file_put_contents('assets/temppdffooter/' . $footerFileName, $footerD);
        return $footerFileName;
    }
    public function generateHtmlFileHeader() {
        $footerData['party_name'] = '';
        $headerD = $this->load->view('template/report_header', $footerData, true);
        $randFileName = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyz", 5)), 0, 10);
        $headerFileName = 'header-' . $randFileName . '.html';
        file_put_contents('assets/temppdffooter/' . $headerFileName, $headerD);
        return $headerFileName;
    }
    public function deleteTempFile($footerFileName) {
        unlink($_SERVER['DOCUMENT_ROOT'] . '/cf/assets/temppdffooter/' . $footerFileName);
    }
}