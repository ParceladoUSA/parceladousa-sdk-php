<?php

    $patches = array(
        'Parceladousa\\' => __DIR__ . '/src/',
        'klebervmv\\' => __DIR__ . '/vendor/klebervmv/easycurl/src/',
    );

    foreach ($patches as $prefix => $path){

        spl_autoload_register(function($class) use ($prefix, $path){

            $length = strlen($prefix);

            if (strncmp($prefix, $class, $length) !== 0) {
                return;
            }

            $relative_class = substr($class, $length);
            $file = $path . str_replace ('\\', '/', $relative_class) . '.php';
            if(file_exists($file)) {
                require $file;
            }
        });
    }