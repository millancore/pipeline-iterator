
# Pipeline Iterator Filter

`PipelineFilterIterator` library provides a flexible and powerful way to filter
and manipulate [PHP Iterators](https://www.php.net/manual/en/spl.iterators.php)
using a pipeline-based approach. It allows developers to apply multiple filters sequentially 
in a clean and readable manner.

You can use SPL filters like 
`CallbackFilterIterator`, `RegexIterator` or create your own filter by extending the 
[FilterIterator](https://www.php.net/manual/en/class.filteriterator.php) in simple way.

```php
class EventFilter extends FilterIterator
{
    public function accept(): bool
    {
        return $this->current() % 2 === 0;
    }
}
```

## Installation

```bash
composer require millancore/pipeline-iterator
```

## Usage

```php
use Millancore\PipelineIterator\PipelineFilterIterator;

$iterator = new ArrayIterator([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]);

$iterator = PipelineFilterIterator::create($iterator)
    ->filter(EventFilter::class)
    ->filter(CallbackFilterIterator::class, [fn($value) => $value > 3])
    ->filter(RangeFilter::class, [5, 10])
    ->getIterator();

foreach ($iterator as $value) {
    echo $value; // Output: 6, 8, 10
}
```

You can also use the `fromArray` method to create a new iterator from an array:

```bash
$iterator = PipelineFilterIterator::fromArray([1, 2, 3])
    ->filter(EventFilter::class)
    ...
```




