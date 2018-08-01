<?php

namespace App;

class Mol2SVG {

    protected $molfile;
    protected $id;
    protected $binary = "/usr/local/bin/mol2svg";
    protected $path = "molfiles/svg";
    protected $colorConfig = "molfiles/config/colors.conf";

    protected $bgColor = "white";

    public function __construct($molfile, $id)
    {
        $this->molfile = $molfile;
        $this->id = $id;
    }

    public static function create($molfile, $id)
    {
        return (new self($molfile, $id))->runMol2SVG();
    }

    private function runMol2SVG()
    {
        $prepend = '';

        if(config('app.env') == 'testing') {
            $prepend = 'public/';
        }

        $flags = '--bgcolor='. $this->bgColor .
            ' --color='. $prepend . $this->colorConfig .
            ' - > '. $prepend . $this->path .'/'. $this->id .'.svg';

        return BashCommand::run(
            $this->molfile,
            $this->binary,
            $flags,
            true);
    }
}