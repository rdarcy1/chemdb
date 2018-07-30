<?php

namespace App;

class Checkmol
{
    protected $binary = "/usr/local/bin/checkmol";
    protected $output = "";
    protected $molfile;

    public function __construct($molfile)
    {
        $this->molfile = $molfile;        
    }

    public static function propertiesFor($molfile) {
        return (new self($molfile))->properties();
    }

    public function properties()
    {
        $pipe = popen('echo "' . $this->molfile . '" | ' . $this->binary . ' -x -', "r");
        while(!feof($pipe)) {
            $this->output .= fread($pipe, 1024);
        }
        pclose($pipe);

        $this->output = substr($this->output, 0, -2);

        $propertiesArray = collect(explode(';', $this->output))
           ->flatMap(function ($attribute) {
                $keyValuePairs = explode(':', $attribute);
                return [$keyValuePairs[0] => $keyValuePairs[1]];
            })->toArray();

        $propertiesArray['molfile'] = $this->molfile;

        return $propertiesArray;
    }
}
