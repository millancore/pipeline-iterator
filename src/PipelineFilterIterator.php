<?php

namespace Millancore\PipelineIterator;

use ArrayIterator;
use FilterIterator;
use InvalidArgumentException;
use Iterator;
use IteratorAggregate;
use SplStack;

/**
 * @implements IteratorAggregate<mixed>
 */
class PipelineFilterIterator implements IteratorAggregate
{
    /** @var SplStack<Filter> */
    private SPlStack $stack;

    public function __construct(
        private readonly Iterator $iterator
    ) {
        $this->stack = new SplStack();
    }

    public static function create(Iterator $iterator): self
    {
        return new self($iterator);
    }

    /**
     * @param array<mixed> $array
     * @return self
     */
    public static function createFromArray(array $array) : self
    {
        return new self(new ArrayIterator($array));
    }

    /**
     * @param class-string<FilterIterator<mixed, mixed, Iterator>> $filter
     * @param array<mixed> $args
     * @return PipelineFilterIterator
     */
    public function filter(string $filter, array $args = []): self
    {

        if (!is_subclass_of($filter, FilterIterator::class)) {
            throw new InvalidArgumentException('Filter must be a subclass of FilterIterator');
        }

        $this->stack->push(new Filter($filter, $args));

        return $this;
    }

    public function getIterator(): Iterator
    {
        $iterator = $this->iterator;

        while (!$this->stack->isEmpty()) {
            $filter = $this->stack->pop();

            /** @var FilterIterator<mixed, mixed, Iterator> $iterator */
            $iterator = $filter->create($iterator);
        }

        return $iterator;

    }
}
