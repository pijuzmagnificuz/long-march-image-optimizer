<?php

if (php_sapi_name() !== 'cli') {
    throw new \Exception('This script should only be launched in terminal!');
}

$params = $GLOBALS['argv'];
array_shift($params);

if (empty($params)) {
    throw new \Exception('Usage: php optimize.php <folder1> <folder2> <folder3> ...');
}

function rglob($pattern, $flags = 0) {
    $files = glob($pattern, $flags); 
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, rglob($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}


require_once 'lib/Command.php';
use ImgOptimizer\Command as Command;

foreach($params as $directory) {
    $dir = realpath($directory);
    if (!is_readable($dir)) {
        echo $directory . ' has not read permissions, skipping' . PHP_EOL;
    } else if (is_file($dir)) {
        echo Command::compress($dir, false, Command::DEFAULT_COMMAND_PRIORITY);
    } else {
        $files = 
                array_merge(rglob($dir . "/*.jpg"),
                rglob($dir . "/*.jpeg"),
                rglob($dir . "/*.jpe"), 
                rglob($dir . "/*.png"), 
                rglob($dir . "/*.gif"));
        $nFiles = count($files);
        echo sprintf('Found %s images in %s' . PHP_EOL, 
            $nFiles,
            $directory);

        if ($nFiles) {
            Command::compressMultiple($files, false, Command::DEFAULT_COMMAND_PRIORITY);
        }
    }
}

