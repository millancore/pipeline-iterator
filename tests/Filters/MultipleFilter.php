<?php

namespace Millancore\tests\Filters;

use FilterIterator;
use Iterator;

class MultipleFilter extends FilterIterator
{
    public function __construct(
        Iterator             $iterator,
        private readonly int $divisor
    ) {
        parent::__construct($iterator);
    }

    public function accept(): bool
    {
        return $this->current() % $this->divisor === 0;
    }
}
