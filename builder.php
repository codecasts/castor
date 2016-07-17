#!/usr/bin/env php
<?php

set_time_limit(36000);


// Include composer's autoloader when local.
if (file_exists(__DIR__.'/vendor/autoload.php')) {
    require __DIR__.'/vendor/autoload.php';
}

// Include composer's autoloader when global dependency.
if (file_exists(__DIR__.'/../../autoload.php')) {
    require __DIR__.'/../../autoload.php';
}

$builder = new \Castor\Command('ffmpeg');

$builder->addOption(new \Castor\Options\General\Input('~/Videos/v-in.mp4'))
    ->addOption(new \Castor\Options\Video\VideoCodec('libx264'))
    ->addOption(new \Castor\Options\General\AutoConfirm())
    ->addOption(new \Castor\Options\Video\FrameRate(15))
    ->addOption(new \Castor\Options\Video\BitRate('1000k'))
    ->addOption(new \Castor\Options\Video\MaxRate('1000k'))
    ->addOption(new \Castor\Options\Video\BufSize('2000k'))
    ->addOption(new \Castor\Options\Video\ScaleFilter('1280:720'))
    ->addOption(new \Castor\Options\Audio\AudioCodec('aac'))
    ->addOption(new \Castor\Options\Audio\AudioBitRate('128k'))
    ->addOption(new \Castor\Options\Video\FastStart())
    ->addOption(new \Castor\Options\General\Output('~/Videos/v-out.mp4'));

/*

$builder
    ->addArgument('-i', '~/Videos/editado.mp4')
    ->addArgument('-codec:v', 'libx264')
    ->addArgument('-y')
    ->addArgument('-r', '15')
    ->addArgument('-b:v', '1000k')
    ->addArgument('-maxrate', '1000k')
    ->addArgument('-bufsize', '2000k')
    ->addArgument('-vf', 'scale=1280:720')
    ->addArgument('-codec:a', 'aac')
    ->addArgument('-b:a', '128k')
    ->addArgument('-movflags', 'faststart')
    ->addArgument('~/Videos/php-out.mp4');
*/


$command = $builder->build(true, '/tmp/ffmpeg_log');

var_dump($command);


$descriptorspec = [
    0 => ['pipe', 'r'],
    1 => ['pipe', 'w'],
    2 => ['pipe', 'w']
];
$proc = proc_open($command, $descriptorspec, $pipes);
$proc_details = proc_get_status($proc);
$pid = $proc_details['pid'];

echo $pid;


while(proc_get_status($proc)) {
    $status = proc_get_status($proc);
    echo getProgress()."\n";
    if (!$status['running']) {
        return;
    }
    sleep(5);
}

function getProgress()
{

$content = @file_get_contents('/tmp/ffmpeg_log');

if($content){
//get duration of source
    preg_match("/Duration: (.*?), start:/", $content, $matches);

    $rawDuration = $matches[1];

//rawDuration is in 00:00:00.00 format. This converts it to seconds.
    $ar = array_reverse(explode(":", $rawDuration));
    $duration = floatval($ar[0]);
    if (!empty($ar[1])) $duration += intval($ar[1]) * 60;
    if (!empty($ar[2])) $duration += intval($ar[2]) * 60 * 60;

//get the time in the file that is already encoded
    preg_match_all("/time=(.*?) bitrate/", $content, $matches);

    $rawTime = array_pop($matches);

//this is needed if there is more than one match
    if (is_array($rawTime)){$rawTime = array_pop($rawTime);}

//rawTime is in 00:00:00.00 format. This converts it to seconds.
    $ar = array_reverse(explode(":", $rawTime));
    $time = floatval($ar[0]);
    if (!empty($ar[1])) $time += intval($ar[1]) * 60;
    if (!empty($ar[2])) $time += intval($ar[2]) * 60 * 60;

//calculate the progress
    $progress = round(($time/$duration) * 100);

    //echo "Duration: " . $duration . "<br>";
    //echo "Current Time: " . $time . "<br>";
    //echo "Progress: " . $progress . "%";
    return $progress;
}
}


//ffmpeg -i $SOURCE -codec:v libx264 -r 15 -b:v 1000k -maxrate 1000k
// -bufsize 2000k -vf scale=1280:720 -codec:a aac -b:a 128k -movflags faststart $TARGET