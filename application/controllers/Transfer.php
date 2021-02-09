<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Transfer extends CI_Controller {

    // setting aid
    public $aid_ip        = '202.158.99.123'; // aid.digdaya.co.id
    public $aid_port      = '8210';
    public $aid_usn       = 'root';
    public $aid_pwd       = 'D3nsh3r0';
    public $aid_video_dir = '/var/www/html/aid.digdaya.co.id/uploads/videos/20191220/';
    // settings storage
    public $vod_ip        = '210.210.155.78'; // vod.dens.tv
    public $vod_port      = '5758';
    public $vod_usn       = 'root';
    public $vod_pwd       = 'D3nsh3r0';
    public $vod_video_dir = '/var/www/html/livestyle/';

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        // create connection
        $sftp = new \phpseclib\Net\SFTP($this->vod_ip, $this->vod_port);
        if (! $sftp->login($this->vod_usn, $this->vod_pwd))
        {
            exit('Login Failed');
        }

        $local_dir  = $this->aid_video_dir;
        $remote_dir = $this->vod_video_dir;

        // echo $sftp->exec('cd /var/');
        // echo 'current dir: ' . $sftp->pwd() . PHP_EOL;exit;

        // save all the filenames in the following array
        $files_data = array();

        // Open the local directory and store all file names in $filesToUpload array
        if ($handle = $sftp->chdir($local_dir))
        {
            //loop the local source directory
            while (false !== ($file = $sftp->nlist($handle)))
            {
                if ($file != '.' && $file != '..')
                {
                    $files_data[] = $file;
                }
            }
        }

        print_r($files_data);

        if (! empty($files_data))
        {
            foreach ($files_data as $file)
            {
                $success = $sftp->put($remote_dir . $file, $local_dir . $file, \phpseclib\Net\SFTP::SOURCE_LOCAL_FILE | \phpseclib\Net\SFTP::RESUME);
            }
        }

    }

    public function do_curl()
    {
        $dataFile      = $this->aid_video_dir . '201912200856400.ts';
        $sftpServer    = $this->vod_ip;
        $sftpUsername  = $this->vod_usn;
        $sftpPassword  = $this->vod_pwd;
        $sftpPort      = $this->vod_port;
        $sftpRemoteDir = $this->vod_video_dir;

        $ch = curl_init('sftp://' . $sftpServer . ':' . $sftpPort . $sftpRemoteDir . '/' . basename($dataFile));

        $fh = fopen($dataFile, 'r');

        if ($fh)
        {
            curl_setopt($ch, CURLOPT_USERPWD, $sftpUsername . ':' . $sftpPassword);
            curl_setopt($ch, CURLOPT_UPLOAD, true);
            curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_SFTP);
            curl_setopt($ch, CURLOPT_INFILE, $fh);
            curl_setopt($ch, CURLOPT_INFILESIZE, filesize($dataFile));
            curl_setopt($ch, CURLOPT_VERBOSE, true);

            $verbose = fopen('php://temp', 'w+');
            curl_setopt($ch, CURLOPT_STDERR, $verbose);

            $response = curl_exec($ch);
            $error    = curl_error($ch);
            curl_close($ch);

            if ($response)
            {
                echo "Success";
            }
            else
            {
                echo "Failure";
                rewind($verbose);
                $verboseLog = stream_get_contents($verbose);
                echo "Verbose information:\n" . $verboseLog . "\n";
            }
        }
    }

}