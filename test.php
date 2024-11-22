<?php

require_once __DIR__ . '/vendor/autoload.php';

use Millancore\PipelineIterator\PipelineFilterIterator;


$dir = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator(__DIR__)
);

$iterator = PipelineFilterIterator::create($dir)
    ->filter(CallbackFilterIterator::class, [fn($value) => $value->isFile()])
    ->filter(CallbackFilterIterator::class, [fn($value) => $value->getExtension() !== 'php'])
    ->getIterator();

foreach ($iterator as $value) {
    echo $value->getPathname() . PHP_EOL;
}