<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uploader extends CI_Controller {

    public $dir_upload    = '';
    public $dir_transcode = '';

    /**
     * constructor class
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('cronvid_model');
        $this->load->helper('security');
        $this->load->library('form_validation');

        $this->dir_upload    = FCPATH . 'vod' . DS . 'uploads';
        $this->dir_transcode = FCPATH . 'vod' . DS . 'transcoded';
    }

    /**
     * Display the uploader view
     */
    public function index()
    {
        $this->load->view('uploader/index');
    }

    /**
     * Handle upload process using plupload handler library
     */
    public function upload()
    {
        $config = array(
            'target_dir'       => $this->dir_upload,
            'allow_extensions' => 'avi,mpg,mpeg,mp4'
        );
        $this->load->library('plupload', $config);

        $this->plupload->sendNoCacheHeaders();
        $this->plupload->sendCORSHeaders();

        if ($result = $this->plupload->handleUpload())
        {
            $data = array(
                'OK'        => 1,
                'info'      => $result,
                'next_csrf' => $this->security->get_csrf_hash()
            );
        }
        else
        {
            $data = array(
                'OK'    => 0,
                'error' => array(
                    'code'    => $this->plupload->getErrorCode(),
                    'message' => $this->plupload->getErrorMessage()
                )
            );
        }
        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($data));
    }

    /**
     * Save media file info into table cron
     */
    public function save_cron()
    {
        // set validation rule into input filename
        $this->form_validation->set_rules('filename', 'File name', 'trim|required|is_unique[tmp_cron_transcode.filename]');
        // run validation check
        if ($this->form_validation->run() == false)
        {
            $result = array(
                'error' => array(
                    'message' => validation_errors()
                )
            );
            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        // prepare data content for saving into table cron
        $name = $this->input->post('filename', true); // with xss filter enable
        $content = array(
            'filename'         => $this->sanitizeFileName($name),
            'status_transcode' => '0',
            'status_transfer'  => '0'
        );

        // run save data into table cron
        if (! $resp = $this->cronvid_model->save($content))
        {
            $result = array(
                'OK'    => 0,
                'error' => array(
                    'message' => 'Failed to save file video name'
                )
            );
        }
        else
        {
            $result = array(
                'OK'        => 1,
                'next_csrf' => $this->security->get_csrf_hash()
            );
        }

        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Handle media conversion into HLS format for streaming purpose
     */
    public function convert_media($filename = '')
    {
        @set_time_limit(30 * 60);

        if (empty($filename))
        {
            if (!is_cli())
            {
                $result = array(
                    'OK'    => 0,
                    'error' => array(
                        'message' => 'File name media is required, cannot be empty.'
                    )
                );
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
            else
            {
                echo 'File name media is required, cannot be empty.'; exit;
            }
        }

        $base_dir  = $this->dir_upload;
        $file_path = $base_dir . DS . $this->sanitizeFileName($filename);

        if (!file_exists($file_path))
        {
            if (!is_cli())
            {
                $result = array(
                    'OK'    => 0,
                    'error' => array(
                        'message' => 'Failed to open input stream.'
                    )
                );
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
            else
            {
                echo 'Failed to open input stream.'; exit;
            }
        }

        // settings
        $new_string      = $this->generate_string('', 20);
        $target_filename = 'MOV' . date('YmdHis') . '_' . $new_string;
        // target directory
        $target_dirvideo  = $this->dir_transcode . DS . $target_filename;
        $target_dirposter = $target_dirvideo . DS . 'thumbnail';

        // update process transcoding
        $content = array(
            'filename_transcode' => $target_filename,
            'date_transcode'     => date('Y-m-d H:i:s'),
            'status_transcode'   => '1'
        );
        $condition = array('filename' => $this->sanitizeFileName($filename));
        // run save data into table cron
        $save = $this->cronvid_model->update($content, $condition);

        // create target directory if not exists
        if (!file_exists($target_dirposter))
        {
            @mkdir($target_dirposter, 0777, true);
        }

        // define resolution will be created as the output media file
        $renditions = array(
            // array(
            //     'resolution' => '1920x1080',
            //     'bitrate'    => '5000k',
            //     'audio-rate' => '192k'
            // ),
            array(
                'resolution' => '1280x720',
                'bitrate'    => '2800k',
                'audio-rate' => '128k'
            ),
            array(
                'resolution' => '842x480',
                'bitrate'    => '1400k',
                'audio-rate' => '128k'
            ),
            array(
                'resolution' => '640x360',
                'bitrate'    => '800k',
                'audio-rate' => '96k'
            )
        );

        // ffmpeg -hide_banner -y -i beach.mkv \
            // -vf scale=w=640:h=360:force_original_aspect_ratio=decrease -c:a aac -ar 48000 -c:v h264 -profile:v main -crf 20 -sc_threshold 0 -g 48 -keyint_min 48 -hls_time 4 -hls_playlist_type vod  -b:v 800k -maxrate 856k -bufsize 1200k -b:a 96k -hls_segment_filename beach/360p_%03d.ts beach/360p.m3u8 \
            // -vf scale=w=842:h=480:force_original_aspect_ratio=decrease -c:a aac -ar 48000 -c:v h264 -profile:v main -crf 20 -sc_threshold 0 -g 48 -keyint_min 48 -hls_time 4 -hls_playlist_type vod -b:v 1400k -maxrate 1498k -bufsize 2100k -b:a 128k -hls_segment_filename beach/480p_%03d.ts beach/480p.m3u8 \
            // -vf scale=w=1280:h=720:force_original_aspect_ratio=decrease -c:a aac -ar 48000 -c:v h264 -profile:v main -crf 20 -sc_threshold 0 -g 48 -keyint_min 48 -hls_time 4 -hls_playlist_type vod -b:v 2800k -maxrate 2996k -bufsize 4200k -b:a 128k -hls_segment_filename beach/720p_%03d.ts beach/720p.m3u8 \
            // -vf scale=w=1920:h=1080:force_original_aspect_ratio=decrease -c:a aac -ar 48000 -c:v h264 -profile:v main -crf 20 -sc_threshold 0 -g 48 -keyint_min 48 -hls_time 4 -hls_playlist_type vod -b:v 5000k -maxrate 5350k -bufsize 7500k -b:a 192k -hls_segment_filename beach/1080p_%03d.ts beach/1080p.m3u8

        $segment_target_duration   = 5;                  // try to create a new segment every X seconds
        $max_bitrate_ratio         = 1.07;               // maximum accepted bitrate fluctuations
        $rate_monitor_buffer_ratio = 1.5;                // maximum buffer size between bitrate conformance checks
        $misc_params               = "-hide_banner -y";

        // extract fps and set the key frames
        $key_frames_interval = exec("ffmpeg {$misc_params} -i " . $file_path . ' 2>&1 | sed -n "s/.*, \(.*\) tbr.*/\1/p"');
        $key_frames_interval = $key_frames_interval == '' ? 50 : floatval($key_frames_interval) * 2;
        $key_frames_interval = floor($key_frames_interval * 10.0) / 10.0;
        $key_frames_interval = intval($key_frames_interval);

        $static_params  = "-c:a aac -ar 48000 -c:v h264 -profile:v main -crf 20 -sc_threshold 0";
        $static_params .= " -g 48 -keyint_min 48 -hls_time {$segment_target_duration}";
        $static_params .= " -hls_playlist_type vod";

        $master_playlist  = "#EXTM3U\r\n";
        $master_playlist .= "#EXT-X-VERSION:3\r\n";

        $cmd_video  = '';
        $poster_list = array();

        foreach ($renditions as $item)
        {
            $resolution = $item['resolution'];
            $bitrate    = $item['bitrate'];
            $audiorate  = $item['audio-rate'];
            // calculation
            $explode_str          = explode('x', $resolution);
            $width                = $explode_str[0];
            $height               = $explode_str[1];
            $maxrate              = intval($bitrate) * $max_bitrate_ratio;
            $bufsize              = intval($bitrate) * $rate_monitor_buffer_ratio;
            $bandwidth            = intval($bitrate) * 1000;
            $size                 = $height . 'p';
            $target_dirvideo_size = $target_dirvideo . DS . $size;

            // create target directory if not exists
            if (!file_exists($target_dirvideo_size))
            {
                @mkdir($target_dirvideo_size, 0777, true);
            }

            // build command for ffmpeg conversion multi bitrate
            $cmd_video .= "-vf scale=w={$width}:h={$height}:force_original_aspect_ratio=decrease {$static_params}";
            $cmd_video .= " -b:v {$bitrate} -maxrate {$maxrate}k -bufsize {$bufsize}k -b:a {$audiorate} -hls_base_url {$size}/";
            $cmd_video .= " -hls_segment_filename {$target_dirvideo_size}" . DS . "index_{$size}_%03d.ts {$target_dirvideo}" . DS . "index_{$size}.m3u8 ";
            // create poster
            $cmd_poster = "ffmpeg {$misc_params} -itsoffset -5 -i {$file_path} -vcodec mjpeg -vframes 5 -an -f rawvideo -s {$resolution} {$target_dirposter}" . DS . "index_{$resolution}.jpg 2>&1";
            $poster = exec($cmd_poster);
            $poster_list[] = "index_{$resolution}.jpg";

            // master playlist m3u8
            $master_playlist .= "#EXT-X-STREAM-INF:BANDWIDTH={$bandwidth},RESOLUTION={$resolution}\r\nindex_{$size}.m3u8\r\n";
        }

        // start conversion
        $video  = exec("ffmpeg {$misc_params} -i {$file_path} {$cmd_video} 2>&1", $hls, $var);

        if ($hls)
        {
            // create master playlist
            $indexfile = file_put_contents($target_dirvideo . DS . 'index.m3u8', $master_playlist);

            if ($indexfile)
            {
                // if (file_exists($file_path))
                // {
                //  unlink($file_path);
                // }

                $content = array(
                    // 'filename_transcode' => $target_filename,
                    // 'date_transcode'     => date('Y-m-d H:i:s'),
                    // 'status_transcode'   => '1',
                    'date_transfer'      => date('Y-m-d H:i:s'),
                    'status_transfer'    => '1'
                );
                $condition = array('filename' => $this->sanitizeFileName($filename));
                // run save data into table cron
                $save = $this->cronvid_model->update($content, $condition);

                $result = array(
                    'OK'   => 1,
                    'data' => array(
                        'filename' => basename($file_path),
                        'name'     => $target_filename,
                        'playlist' => 'index.m3u8',
                        'poster'   => $poster_list
                    ),
                    'next_csrf' => $this->security->get_csrf_hash()
                );

                if (!is_cli())
                {
                    return $this->output->set_status_header(200)
                        ->set_content_type('application/json')
                        ->set_output(json_encode($result));
                }
                else
                {
                    echo json_encode($result); exit;
                }
            }
            else
            {
                if (!is_cli())
                {
                    $result = array(
                        'OK'    => 0,
                        'error' => array(
                            'message' => 'Failed to convert file video'
                        )
                    );
                    return $this->output->set_status_header(200)
                        ->set_content_type('application/json')
                        ->set_output(json_encode($result));
                }
                else
                {
                    echo 'Failed to convert file video'; exit;
                }
            }
        }
        else
        {
            if (!is_cli())
            {
                $result = array(
                    'OK'    => 0,
                    'error' => array(
                        'message' => 'Failed to convert file video'
                    )
                );
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
            else
            {
                echo 'Failed to convert file video'; exit;
            }
        }
    }

    /**
     * Handle media conversion into HLS format for streaming purpose using aminyazdanpanah/php-ffmpeg-video-streaming
     */
    public function convert_media2($filename = '')
    {
        @set_time_limit(30 * 60);

        if (empty($filename))
        {
            if (!is_cli())
            {
                $result = array(
                    'OK'    => 0,
                    'error' => array(
                        'message' => 'File name media is required, cannot be empty.'
                    )
                );
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
            else
            {
                echo 'File name media is required, cannot be empty.'; exit;
            }
        }

        $base_dir  = $this->dir_upload;
        $file_path = $base_dir . DS . $this->sanitizeFileName($filename);

        if (!file_exists($file_path))
        {
            if (!is_cli())
            {
                $result = array(
                    'OK'    => 0,
                    'error' => array(
                        'message' => 'Failed to open input stream.'
                    )
                );
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
            else
            {
                echo 'Failed to open input stream.'; exit;
            }
        }

        $config = [
            // 'ffmpeg.binaries'  => '/usr/bin/ffmpeg',
            // 'ffprobe.binaries' => '/usr/bin/ffprobe',
            'timeout'          => 3600, // The timeout for the underlying process
            'ffmpeg.threads'   => 12,   // The number of threads that FFmpeg should use
        ];

        $ffmpeg = Streaming\FFMpeg::create($config);
        $video  = $ffmpeg->open($file_path);

        // settings
        $new_string       = $this->generate_string('', 20);
        $target_filename  = 'MOV' . date('YmdHis') . '_' . $new_string;
        $target_dirvideo  = $this->dir_transcode . DS . $target_filename;
        $target_dirposter = $target_dirvideo . DS . 'thumbnail';

        // update process transcoding
        $content = array(
            'filename_transcode' => $target_filename,
            'date_transcode'     => date('Y-m-d H:i:s'),
            'status_transcode'   => '1'
        );
        $condition = array('filename' => $this->sanitizeFileName($filename));
        // run save data into table cron
        $save = $this->cronvid_model->update($content, $condition);

        // create target directory if not exists
        if (!file_exists($target_dirposter))
        {
            @mkdir($target_dirposter, 0777, true);
        }

        // Extract image
        $frame = $video->frame(FFMpeg\Coordinate\TimeCode::fromSeconds(10));
        $frame->save($target_dirposter . DS . 'index.jpg');

        $hls = $video->HLS()
            ->X264()
            // ->setHlsBaseUrl(base_url('uploads/videos')) // Add a base URL
            ->setTsSubDirectory('ts_files')// put all ts files in a subdirectory
            ->autoGenerateRepresentations([360, 480, 720])
            ->setHlsTime(5); // Set Hls Time. Default value is 10
            // ->setHlsAllowCache(false) // Default value is true
        extract($hls->save($target_dirvideo . DS . 'index.m3u8'));

        if ($filename)
        {
            // if (file_exists($file_path))
            // {
            //  unlink($file_path);
            // }

            $content = array(
                // 'date_transcode'   => date('Y-m-d H:i:s'),
                // 'status_transcode' => '1',
                'date_transfer'    => date('Y-m-d H:i:s'),
                'status_transfer'  => '1'
            );
            $condition = array('filename' => $this->sanitizeFileName($filename));
            // run save data into table cron
            $save = $this->cronvid_model->update($content, $condition);

            // Metadata Extraction
            $data = array(
                'name'     => $target_filename,
                'playlist' => 'index.m3u8',
                'poster'   => 'index.jpg',
                'metadata' => $metadata
            );

            $result = array(
                'OK'        => 1,
                'data'      => $data,
                'next_csrf' => $this->security->get_csrf_hash()
            );

            if (!is_cli())
            {
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
            else
            {
                echo json_encode($result); exit;
            }
        }
        else
        {
            if (!is_cli())
            {
                $result = array(
                    'OK'    => 0,
                    'error' => array(
                        'message' => 'Failed to convert file video'
                    )
                );
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
            else
            {
                echo 'Failed to convert file video'; exit;
            }
        }
    }

    public function transfer_media($filename = '')
    {
        @set_time_limit(30 * 60);

        if (empty($filename))
        {
            if (!is_cli())
            {
                $result = array(
                    'OK'    => 0,
                    'error' => array(
                        'message' => 'File name media is required, cannot be empty.'
                    )
                );
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
            else
            {
                echo 'File name media is required, cannot be empty.'; exit;
            }
        }

        // ex: MOV20200111161726_IQ1Wpg8vgHCuvv6ZlrIr
        $name           = $this->sanitizeFileName($filename);
        $str_first      = strtoupper(substr($name, 0, 3));     // MOV
        $str_datetime   = substr($name, 3, 14);                // 20200111161726
        $str_underscore = strpos($name, '_');                  // found in pos 17

        // check the given pattern
        if ((strlen($name) >= 3 || strlen($name) >= 17) && ($str_first !== 'MOV' || $str_first === 'MOV') && !is_numeric($str_datetime))
        {
            if (!is_cli())
            {
                $result = array(
                    'OK'    => 0,
                    'error' => array(
                        'message' => 'File name pattern wrong.'
                    )
                );
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
            else
            {
                echo 'File name pattern wrong.'; exit;
            }
        }

        // define pattern to collect all items in local directory
        $base_dir   = $this->dir_upload;
        $pattern    = $base_dir . DS . $name . "*";
        $items      = $this->rglob($pattern);
        $dir        = array();
        $dir_remote = "/var/www/html/livestyle";
        // var_dump($items);

        if (is_array($items) && count($items) === 0)
        {
            if (!is_cli())
            {
                $result = array(
                    'OK'    => 0,
                    'error' => array(
                        'message' => 'Failed to open input stream.'
                    )
                );
                return $this->output->set_status_header(200)
                    ->set_content_type('application/json')
                    ->set_output(json_encode($result));
            }
            else
            {
                echo 'Failed to open input stream.'; exit;
            }
        }

        $name_dir = '';
        // collect all items (file & dir)
        foreach ($items as $item)
        {
            // check if item is a directory
            if (is_dir($item))
            {
                $item_str     = explode(DS, $item);
                $item_strlast = end($item_str);
                $name_dir     = $item_strlast;
            }
            // check if item is not a directory
            else
            {
                $ext = pathinfo($item, PATHINFO_EXTENSION);
                $target_dirname = $item_strlast;

                if ($ext == 'm3u8')
                {
                    $dir[] = array(
                        'file_source' => $item,
                        'file_target' => $dir_remote . "/" . $target_dirname . "/" . basename($item),
                        'dir_source'  => pathinfo($item, PATHINFO_DIRNAME),
                        'dir_target'  => $dir_remote . "/" . $target_dirname,
                    );
                }

                if ($ext == 'jpg')
                {
                    $dir[] = array(
                        'file_source' => $item,
                        'file_target' => $dir_remote . "/" . $target_dirname . "/thumbnail/" . basename($item),
                        'dir_source'  => pathinfo($item, PATHINFO_DIRNAME),
                        'dir_target'  => $dir_remote . "/" . $target_dirname . "/thumbnail",
                    );
                }

                if ($ext == 'ts')
                {
                    $base       = pathinfo($item, PATHINFO_DIRNAME);
                    $base_split = explode(DS, $base);
                    $base_size  = end($base_split);
                    $dir[] = array(
                        'file_source' => $item,
                        'file_target' => $dir_remote . "/" . $target_dirname . "/" . $base_size . "/" . basename($item),
                        'dir_source'  => pathinfo($item, PATHINFO_DIRNAME),
                        'dir_target'  => $dir_remote . "/" . $target_dirname . "/" . $base_size,
                    );
                }
            }
        }
        // var_dump($name_dir, $dir, count($dir));exit;

        if (is_array($dir) && count($dir) > 0)
        {
            $remote_ip   = '210.210.155.78';
            $remote_port = '5758';
            $remote_user = 'root';
            $remote_pass = 'D3nsh3r0';
            $remote_dir  = '/var/www/html/livestyle/';

            $sftp = new \phpseclib\Net\SFTP($remote_ip, $remote_port);
            if (! $sftp->login($remote_user, $remote_pass) )
            {
                if (!is_cli())
                {
                    $result = array(
                        'OK'    => 0,
                        'error' => array(
                            'message' => 'Login Failed to remote server.'
                        )
                    );
                    return $this->output->set_status_header(200)
                        ->set_content_type('application/json')
                        ->set_output(json_encode($result));
                }
                else
                {
                    echo 'Login Failed to remote server.'; exit;
                }
            }

            $sftp->chdir($remote_dir);
            // print_r($sftp->nlist());

            // make directory on remote target
            $row_data = count($dir);
            $numb = 0;
            foreach ($dir as $target_dir)
            {
                // var_dump($target_dir['dir_source']);exit;
                // check existing directory on remote server
                if (!$sftp->is_dir($target_dir['dir_target']))
                {
                    $sftp->mkdir($target_dir['dir_target'], -1, true);
                }
                // begin copying file to remote server
                $stat = $sftp->put($target_dir['file_target'], $target_dir['file_source'], \phpseclib\Net\SFTP::SOURCE_LOCAL_FILE | \phpseclib\Net\SFTP::RESUME);
                if ($stat)
                {
                    $numb = $numb + 1;
                    // if (file_exists($target_dir['file_source']))
                    // {
                    //  unlink($target_dir['file_source']);
                    // }
                }
            }
            // print_r($sftp->nlist('.', true));

            if ($row_data == $numb)
            {
                // delete all file and directory on local server
                // foreach ($dir as $target_dir)
                // {
                //  if (file_exists($target_dir['dir_source']))
                //  {
                //      @rmdir($target_dir['dir_source']);
                //  }
                // }
                // // delete parent directory on local server
                // if (file_exists($base_dir . DS . $name_dir))
                // {
                //  @rmdir($base_dir . DS . $name_dir);
                // }

                if (!is_cli())
                {
                    $result = array(
                        'OK'        => 1,
                        'next_csrf' => $this->security->get_csrf_hash()
                    );
                    return $this->output->set_status_header(200)
                        ->set_content_type('application/json')
                        ->set_output(json_encode($result));
                }
                else
                {
                    echo json_encode($result); exit;
                }
            }
        }
    }

    /**
     * Update status media file info into table cron
     */
    public function update_status_media()
    {
        // set validation rule into input filename
        $this->form_validation->set_rules('filename', 'File name', 'trim|required');
        $this->form_validation->set_rules('new_name', 'New file name', 'trim|required');
        $this->form_validation->set_rules('type', 'Status type', 'trim|required|in_list[convert,transfer]');
        // run validation check
        if ($this->form_validation->run() == false)
        {
            $result = array(
                'OK'    => 0,
                'error' => array(
                    'message' => validation_errors()
                )
            );
            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        // prepare data content for updating status transcoded file into table cron
        $filename = $this->input->post('filename', true);  // with xss filter enable
        $new_name = $this->input->post('new_name', true);  // with xss filter enable
        $type     = $this->input->post('type', true);      // with xss filter enable

        $base_dir  = $this->dir_upload;
        $file_path = $base_dir . DS . $this->sanitizeFileName($filename);

        if (!file_exists($file_path))
        {
            $result = array(
                'OK'    => 0,
                'error' => array(
                    'message' => 'Failed to open input stream.'
                )
            );
            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        // check type to set the correct data mapping into cron table
        if ($type == 'convert')
        {
            $content = array(
                'filename_transcode' => $this->sanitizeFileName($new_name),
                'date_transcode'     => date('Y-m-d H:i:s'),
                'status_transcode'   => '1'
            );
            $data = array_merge($content,
                array(
                    'filename'  => $this->sanitizeFileName($filename),
                    'next_step' => 'transfer'
                )
            );
        }
        else
        {
            $content = array(
                'date_transfer'   => date('Y-m-d H:i:s'),
                'status_transfer' => '1'
            );
            $data = array_merge($content,
                array(
                    'filename'           => $this->sanitizeFileName($filename),
                    'filename_transcode' => $this->sanitizeFileName($new_name),
                    'next_step'          => 'done'
                )
            );
        }

        $condition = array('filename' => $this->sanitizeFileName($filename));

        // run save data into table cron
        if (! $resp = $this->cronvid_model->update($content, $condition))
        {
            $result = array(
                'OK'    => 0,
                'error' => array(
                    'message' => 'Failed to save file video name'
                )
            );
        }
        else
        {
            if ($type == 'transfer')
            {
                if (file_exists($file_path))
                {
                    unlink($file_path);
                }
            }
            $result = array(
                'OK'        => 1,
                'data'      => $data,
                'next_csrf' => $this->security->get_csrf_hash()
            );
        }

        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Get status transcoded media file from table cron
     */
    public function check_transcode()
    {
        // set validation rule into input filename
        $this->form_validation->set_rules('filename', 'File name', 'trim|required');
        // run validation check
        if ($this->form_validation->run() == false)
        {
            $result = array(
                'OK'    => 0,
                'error' => array(
                    'message' => validation_errors()
                )
            );
            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        // prepare data content for checking status transcoded file into table cron
        $name = $this->input->post('filename', true); // with xss filter enable
        $content = array('filename' => $this->sanitizeFileName($name));

        // run check status transcoded file into table cron
        if (! $resp = $this->cronvid_model->checkMovie2Transcode($content))
        {
            $result = array(
                'OK'    => 0,
                'error' => array(
                    'message' => 'Failed to find file video'
                )
            );
        }
        else
        {
            $result = array(
                'OK'        => 1,
                'data'      => $resp,
                'next_csrf' => $this->security->get_csrf_hash()
            );
        }

        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * Get status transfered media file from table cron
     */
    public function check_transfer()
    {
        // set validation rule into input filename
        $this->form_validation->set_rules('filename', 'File name', 'trim|required');
        // run validation check
        if ($this->form_validation->run() == false)
        {
            $result = array(
                'OK'    => 0,
                'error' => array(
                    'message' => validation_errors()
                )
            );
            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }

        // prepare data content for checking status transfered file into table cron
        $name = $this->input->post('filename', true); // with xss filter enable
        $content = array('filename_transcode' => $this->sanitizeFileName($name));

        // run check status transfered file into table cron
        if (! $resp = $this->cronvid_model->checkMovie2Transfer($content))
        {
            $result = array(
                'OK'    => 0,
                'error' => array(
                    'message' => 'Failed to find file video'
                )
            );
        }
        else
        {
            $result = array(
                'OK'        => 1,
                'data'      => $resp,
                'next_csrf' => $this->security->get_csrf_hash()
            );
        }

        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function getMovie2Transcode()
    {
        if (!is_cli())
        {
            $result = array(
                'OK'    => 0,
                'error' => array(
                    'message' => 'Please run via CLI only.'
                )
            );
            return $this->output->set_status_header(200)
                ->set_content_type('application/json')
                ->set_output(json_encode($result));
        }
        else
        {
            $videos = $this->cronvid_model->getMovie2Transcode();

            if ($videos && count($videos) > 0)
            {
                foreach ($videos as $video)
                {
                    if (! empty($video->filename))
                    {
                        $this->convert_media($video->filename);
                    }
                }
            }
        }
    }

    public function getListMovie2($keyword = null)
    {
        if (!$keyword && empty($keyword))
        {
            $year    = date('Y');
            $keyword = "MOV{$year}";
        }

        // define pattern to collect all items in local directory
        $base_dir = $this->dir_transcode;
        $pattern  = $base_dir . DS . $keyword . "*";
        $path_items    = $this->rglob($pattern);
        $data      = array();
        $base_url = '//rr.digdaya.co.id/03/transcoded/';

        foreach ($path_items as $key_path => $path)
        {
            $file_items = $this->rglob($path . DS . '*');
            foreach ($file_items as $item)
            {
                // var_dump($item);exit;
                // check if item is a directory
                if (is_file($item))
                {
                    $item_ext  = pathinfo($item, PATHINFO_EXTENSION);
                    if ($item_ext === 'm3u8')
                    {
                        $data[$key_path]['url_video'][] = $item;
                    }
                    else if ($item_ext === 'jpg')
                    {
                        $data[$key_path]['url_video_poster'][] = $item;
                    }
                }
            }
        }

        $result = array(
            'OK'        => 1,
            'data'      => $data,
            'next_csrf' => $this->security->get_csrf_hash()
        );

        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function getListMovie($keyword = null)
    {
        if (!$keyword && empty($keyword))
        {
            $year = date('Y');
            $keyword = $year;
        }

        // run get list all video from table
        if (! $resp = $this->cronvid_model->getListMovie($keyword))
        {
            $result = array(
                'OK'    => 0,
                'error' => array(
                    'message' => 'Failed to find file video'
                )
            );
        }
        else
        {
            $base_url = 'http://rr.digdaya.co.id/03/transcoded/';
            $data     = array();
            // create mapping result
            foreach ($resp as $item)
            {
                $data[] = array(
                    'url_video'  => $base_url . $item->filename_transcode . "/index.m3u8",
                    'url_video_poster' => $base_url . $item->filename_transcode . "/thumbnail/index_1280x720.jpg"
                );
            }

            $result = array(
                'OK'        => 1,
                'data'      => $data,
                'next_csrf' => $this->security->get_csrf_hash()
            );
        }

        return $this->output->set_status_header(200)
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    /**
     * This function will generate random string
     *
     * @param  string  $input
     * @param  integer $length
     * @return string
     */
    protected function generate_string($input = '', $length = 20)
    {
        if (!$input || empty($input))
        {
            $input = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        $input_length  = strlen($input);
        $random_string = '';

        for ($i = 0; $i < $length; $i++)
        {
            $random_character = $input[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }

    /**
     * Sanitizes a filename replacing whitespace with dashes
     *
     * Removes special characters that are illegal in filenames on certain
     * operating systems and special characters requiring special escaping
     * to manipulate at the command line. Replaces spaces and consecutive
     * dashes with a single dash. Trim period, dash and underscore from beginning
     * and end of filename.
     *
     * @author WordPress
     *
     * @param string $filename The filename to be sanitized
     * @return string The sanitized filename
     */
    protected function sanitizeFileName($filename)
    {
        $special_chars = array("?", "[", "]", "/", "\\", "=", "<", ">", ":", ";", ",", "'", "\"", "&", "$", "#", "*", "(", ")", "|", "~", "`", "!", "{", "}");
        $filename      = str_replace($special_chars, '', $filename);
        $filename      = preg_replace('/[\s-]+/', '-', $filename);
        $filename      = trim($filename, '.-_');
        return $filename;
    }

    /**
     * Recursive directory listing, does not support flag GLOB_BRACE
     */
    protected function rglob($pattern, $flags = 0)
    {
        $files = glob($pattern, $flags);
        foreach (glob(dirname($pattern) . DS . '*', GLOB_ONLYDIR | GLOB_NOSORT) as $dir)
        {
            $files = array_merge($files, $this->rglob($dir . DS . basename($pattern), $flags));
        }
        return $files;
    }

    public function test_uri_segment($str = null)
    {
        $new_str = $this->input->get('str', true);
        $link = $_SERVER['PHP_SELF'];
        $link_array = explode('/',$link);

        var_dump($_REQUEST, $new_str, $str, $link, $link_array);exit;
    }

}
