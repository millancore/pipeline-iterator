<?php

namespace Millancore\tests\Filters;

use FilterIterator;
use Iterator;

class RangeFilter extends FilterIterator
{
    public function __construct(
        Iterator             $iterator,
        private readonly int $start,
        private readonly int $end
    ) {
        parent::__construct($iterator);
    }

    public function accept(): bool
    {
        return $this->current() >= $this->start && $this->current() <= $this->end;
    }
}
