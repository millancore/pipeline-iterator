<?php

namespace Millancore\tests;

use ArrayIterator;
use Millancore\PipelineIterator\Filter;
use Millancore\tests\Filters\EvenFilter;
use Millancore\tests\Filters\RangeFilter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(Filter::class)]
#[UsesClass(EvenFilter::class)]
#[UsesClass(RangeFilter::class)]
class FilterTest extends TestCase
{
    public function test_it_can_create_simple_filter(): void
    {
        $filter = new Filter(EvenFilter::class);
        $this->assertInstanceOf(
            EvenFilter::class,
            $filter->create(new ArrayIterator())
        );
    }

    public function test_it_can_create_filter_with_args(): void
    {
        $filter = new Filter(RangeFilter::class, [3,4,5]);

        $this->assertInstanceOf(
            RangeFilter::class,
            $filter->create(new ArrayIterator())
        );
    }

}
