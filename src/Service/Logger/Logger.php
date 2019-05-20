<?php

namespace App\Service\Logger;


class Logger
{
    private $basePath;
    private $resource;

    public function __construct(String $filename, String $basePath)
    {
        $this->basePath = $basePath;
        $filename = $basePath . DIRECTORY_SEPARATOR . $filename;
        $dirName = dirname($filename);
        if (!is_dir($dirName)) {
            mkdir($dirName, 0755, true);
        }
        $this->resource = fopen($filename, 'a');
    }

    public function info(String $data)
    {
        $this->log($data);
    }

    public function warning(String $data)
    {
        $this->log($data);
    }

    public function error(String $data)
    {
        $this->log($data);
    }

    private function log(String $data)
    {
        fwrite(
            $this->resource,
            "[" . strtoupper(debug_backtrace()[1]['function']) . "]" . "[" . date("Y-m-d H:i:s") . "] " . $data . PHP_EOL);
    }

    public function setDestination(String $filename)
    {
        $filename = $this->basePath . DIRECTORY_SEPARATOR . $filename;
        $dirName = dirname($filename);
        if (!is_dir($dirName)) {
            mkdir($dirName, 0755, true);
        }
        $this->resource = fopen($filename, 'a');
    }
}