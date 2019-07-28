<?php

require_once 'lib/Command.php';
use ImgOptimizer\Command as Command;

$curDir = __DIR__ . DIRECTORY_SEPARATOR;
$files = [];
foreach($_FILES as $file) {
    $newFile = $curDir . 'output/' . $file['name'];
    move_uploaded_file($file['tmp_name'], $newFile);
    $files [] = $newFile;
}

$outputFormat='%s
Compression command:
%s
Compression result:
%s';

try{

    $resultFiles = [];
    $initialPreviews = [];
    $initialPreviewConfig = [];
    $fileIds = $_POST['fileId'];
    if (!is_array($fileIds)){
        $fileIds = [$fileIds];
    }

    $count = 0;
    foreach($files as $file) {
        
        $filename = $file;
        $comando = Command::command($filename,false,Command::DEFAULT_COMMAND_PRIORITY);
        $result = Command::compress($file,false,Command::DEFAULT_COMMAND_PRIORITY);
        $relFile = str_replace($curDir, '', $file);
        $fileName = basename($file);
        $description = sprintf($outputFormat,
            $fileName,
            $comando,
            $result);
        clearstatcache(true, $file);
        $fileSize = filesize($file);
        $fileId = $fileIds[$count];
        $targetUrl = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $relFile;
        $initialPreviews [] = $targetUrl;
        $initialPreviewConfigs [] = [
            'type' => 'image',      // check previewTypes (set it to 'other' if you want no content preview)
            'caption' => $description, // caption
            'size' => $fileSize,    // file size,
            'fileId'=>$fileId,
            'previewAsData'=> true,
        ];
    }

    $resultFiles = [
        'initialPreview' => $initialPreviews, // the thumbnail preview data (e.g. image)
        'initialPreviewConfig' => $initialPreviewConfigs,
        'append' => true
    ];
    header('Content-Type: application/json');
    echo json_encode($resultFiles);
} catch(\Exception $e) {
    return [
        'error' =>  '' . $e
    ];
}
