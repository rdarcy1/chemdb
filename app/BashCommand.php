<?php

namespace App;


class BashCommand {
    public static function run($input, $binary, $flags, $ignoreOutput = false)
    {
        $output = '';

        $pipe = popen('echo "' . $input . '" | ' . $binary . ' ' . $flags, "r");

        if($ignoreOutput) {
            pclose($pipe);
            return;
        }

        while(!feof($pipe)) {
            $output .= fread($pipe, 1024);
        }
        pclose($pipe);

        return $output;
    }
}