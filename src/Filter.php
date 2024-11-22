<?php

namespace Millancore\PipelineIterator;

use Iterator;
use FilterIterator;

readonly class Filter
{
    /**
     * @param class-string<FilterIterator<mixed, mixed, Iterator>> $filter
     * @param array<mixed> $args
     */
    public function __construct(
        public string $filter,
        public array $args = []
    ) {
        //
    }


    /**
     * @param Iterator $iterator
     * @return FilterIterator<mixed, mixed, Iterator>
     */
    public function create(Iterator $iterator): FilterIterator
    {
        return new $this->filter($iterator, ...$this->args);
    }

}
