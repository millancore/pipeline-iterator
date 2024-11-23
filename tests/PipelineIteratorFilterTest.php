<?php

namespace Millancore\tests;

use ArrayIterator;
use CallbackFilterIterator;
use InvalidArgumentException;
use Millancore\PipelineIterator\Filter;
use Millancore\PipelineIterator\PipelineFilterIterator;
use Millancore\tests\Filters\EvenFilter;
use Millancore\tests\Filters\RangeFilter;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use RegexIterator;
use stdClass;

#[CoversClass(PipelineFilterIterator::class)]
#[UsesClass(Filter::class)]
#[UsesClass(EvenFilter::class)]
#[UsesClass(RangeFilter::class)]
class PipelineIteratorFilterTest extends TestCase
{
    public function test_it_can_stack_filters(): void
    {
        $iterator = new ArrayIterator([1,2,3,4,5,6,7,8,9,10]);

        $result = PipelineFilterIterator::create($iterator)
            ->filter(EvenFilter::class)
            ->filter(RangeFilter::class, 1,5);

        $this->assertEquals([2,4], array_values(
            iterator_to_array($result)
        ));
    }

    public function test_it_can_use_callback_filter(): void
    {
        $iterator = new ArrayIterator([1,2,3,4,5,6,7,8,9,10]);

        $result = PipelineFilterIterator::create($iterator)
            ->filter(CallbackFilterIterator::class, fn($value) => $value % 2 == 0);

        $this->assertEquals([2,4,6,8,10], array_values(
            iterator_to_array($result)
        ));

    }

    public function test_it_can_use_regex_filter(): void
    {
        $names = [
            'Juan',
            'Pedro',
            'Carlos',
            'Luis',
        ];

        $iterator = new ArrayIterator($names);

        $result = PipelineFilterIterator::create($iterator)
            ->filter(RegexIterator::class, '/^J/');

        $this->assertEquals(['Juan'], array_values(
            iterator_to_array($result)
        ));

    }

    public function test_it_can_create_from_array() : void
    {
        $iterator = PipelineFilterIterator::createFromArray([1, 2, 3])
            ->filter(EvenFilter::class)
            ->getIterator();

        $this->assertEquals([2], array_values(
            iterator_to_array($iterator)
        ));

    }


    public function test_throws_exception_when_filter_is_not_a_filter_class(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Filter must be a subclass of FilterIterator');

        $iterator = new ArrayIterator([1,2,3,4,5,6,7,8,9,10]);

        PipelineFilterIterator::create($iterator)
            ->filter(StdClass::class)
            ->getIterator();
    }



}
