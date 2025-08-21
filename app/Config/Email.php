<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use Config\Database;

class Email extends BaseConfig
{
    public string $fromEmail  = '';
    public string $fromName   = '';
    public string $recipients = '';

    public string $userAgent = 'CodeIgniter';
    public string $protocol = 'smtp';
    public string $mailPath = '/usr/sbin/sendmail';
    public string $SMTPHost = '';
    public string $SMTPUser = '';
    public string $SMTPPass = '';
    public int    $SMTPPort = 587;
    public int    $SMTPTimeout = 10;
    public bool   $SMTPKeepAlive = false;
    public string $SMTPCrypto = 'tls';
    public bool   $wordWrap = true;
    public int    $wrapChars = 76;
    public string $mailType = 'html';
    public string $charset = 'UTF-8';
    public bool   $validate = false;
    public int    $priority = 3;
    public string $CRLF = "\r\n";
    public string $newline = "\r\n";
    public bool   $BCCBatchMode = false;
    public int    $BCCBatchSize = 200;
    public bool   $DSN = false;

    public function __construct()
    {
        parent::__construct();

        // Ambil data pertama dari tabel email_settings
        $db = Database::connect();
        $query = $db->table('email_settings')->get()->getRowArray();

        if ($query) {
            $this->fromEmail  = $query['from_email'];
            $this->fromName   = $query['from_name'];
            $this->SMTPHost   = $query['smtp_host'];
            $this->SMTPUser   = $query['smtp_user'];
            $this->SMTPPass   = $query['smtp_pass'];
            $this->SMTPPort   = (int) $query['smtp_port'];
            $this->SMTPCrypto = $query['smtp_crypto'];
        }
    }
}
