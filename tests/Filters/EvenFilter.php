<?php

namespace Millancore\tests\Filters;

use FilterIterator;

class EvenFilter extends FilterIterator
{
    public function accept(): bool
    {
        return $this->current() % 2 === 0;
    }
}
