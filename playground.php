<?php

require "vendor/autoload.php";

$path = __DIR__ . "/tests/stubs/basic-example.vtt";

var_dump(\App\Transcription::load($path)->lines());