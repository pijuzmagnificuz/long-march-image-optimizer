<?php 

namespace ImgOptimizer;

class Command {
    
    const NICE_COMMAND = 'nice -%s %s';
    const GIF_COMMAND = 'gifsicle -O100 -b %s';
    const JPEG_COMMAND = 'jpegoptim --max=100 -s -t %s';
    const PNG_COMMAND = 'optipng -o7 -strip all %s';
    const CONVERT_TO_JPEG_COMMAND = 'convert %s -quality 100 %s';
    const ERROR_MSG = 'No suitable command for \'%s\' extension file';
    const ERROR_FILE = 'File \'%s\' not exists or is not readable';
    const CLI_OUTPUT_FORMAT = 'Compression command:
    %s
    Compression result:
    %s
    ';
    const TIME_LIMIT = 60;
    const DEFAULT_COMMAND_PRIORITY = '20';
    const SLEEP_TIME = 10000;

    static private $EXTENSIONS_COMMAND_MAP = [
        'jpg'   =>  self::JPEG_COMMAND,
        'jpeg'  =>  self::JPEG_COMMAND,
        'jpe'   =>  self::JPEG_COMMAND,
        'gif'   =>  self::GIF_COMMAND,
        'png'   =>  self::PNG_COMMAND,
    ];

    static public function command(&$sourceImage, 
        $convertPngToJpeg = true, 
        $priority = false) {

        if (!is_file($sourceImage) || !is_readable($sourceImage)) {
            throw new \Exception(sprintf(self::ERROR_FILE, $sourceImage));
        }

        $extension = substr($sourceImage, strrpos($sourceImage,'.') + 1);

        if (!isset(self::$EXTENSIONS_COMMAND_MAP[$extension])) {
            throw new \Exception(sprintf(self::ERROR_MSG, $extension));
        }

        $command = self::$EXTENSIONS_COMMAND_MAP[$extension];

        if ($convertPngToJpeg && $command === self::PNG_COMMAND) {
            $jpegImage = str_replace('.' . $extension,'.jpg',$sourceImage);
            $convertCommand = sprintf(self::CONVERT_TO_JPEG_COMMAND,
                $sourceImage,
                $jpegImage);
            $command = $convertCommand . ' && ' . self::JPEG_COMMAND;
            $sourceImage = $jpegImage;
        }

        if ($priority) {
            $command = sprintf(self::NICE_COMMAND, 
                            $priority,
                            escapeshellcmd($command));
        }

        return sprintf($command, escapeshellarg(realpath($sourceImage)));
    }

    static public function compress(&$sourceImage, 
        $convertPngToJpeg = true, 
        $priority = false) {
        set_time_limit(self::TIME_LIMIT);
        $command = self::command($sourceImage, $convertPngToJpeg, $priority);
        $output = shell_exec($command);
        //yield this process
        usleep(self::SLEEP_TIME);

        return $output;
    }

    
    static public function compressMultiple(array $files, $convertPngToJpeg = true, 
        $priority = false) {
        $output = '';
        $outputFiles = [];

        foreach($files as $file) {
            $filename = $file;
            $comando = Command::command($filename, $convertPngToJpeg, $priority);
            $result = Command::compress($file, $convertPngToJpeg, $priority);

            if (!in_array($file, $outputFiles)) {
                $outputFiles [] = $file;
            }
            
            echo sprintf(self::CLI_OUTPUT_FORMAT,
                $comando,
                $result);
        }

        return $outputFiles;
    }
}
