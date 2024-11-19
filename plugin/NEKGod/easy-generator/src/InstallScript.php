<?php

namespace Plugin\NEK\CodeGenerator;

use Mine\Support\Filesystem;

class InstallScript {

    public function __invoke(){
        Filesystem::copy(
            dirname(__DIR__).'/languages',
            BASE_PATH.'/storage/languages',
            false
        );
    }

}