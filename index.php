<?php

/**
 * Kirby Chunky
 *
 * @version 1.0.0
 * @link https://github.com
 * @license MIT
 * @author DGTL.ONE
 */

@include_once __DIR__ . '/vendor/autoload.php';
load(['DGTLONE\Chunky' => __DIR__ . '/lib/chunky.php']);

Kirby::plugin('dgtlone/kirby-chunky', [
    'options' => [
        'chunk_size' => null,
    ],
    'api' => array(
        'routes' => \DGTLONE\Chunky::apiRoutes(),
    )
]);
