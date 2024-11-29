
# Pipeline Iterator Filter

`PipelineFilterIterator` library provides a flexible and powerful way to filter
and manipulate [PHP Iterators](https://www.php.net/manual/en/spl.iterators.php)
using a pipeline-based approach. It allows developers to apply multiple filters sequentially 
in a clean and readable manner.

You can use SPL filters like 
`CallbackFilterIterator`, `RegexIterator` or create your own filter by extending the 
[FilterIterator](https://www.php.net/manual/en/class.filteriterator.php) in simple way.

```php
class EvenFilter extends FilterIterator
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

$arrayData = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];

/** 
* Use with Iterator
* $iterator = PipelineFilterIterator::create(new ArrayIterator($arrayData))
*/

// Use with Array directly
$iterator = PipelineFilterIterator::createFromArray($arrayData)
    ->filter(EvenFilter::class)
    ->filter(CallbackFilterIterator::class, fn($value) => $value > 3)
    ->filter(RangeFilter::class, 5, 10);

foreach ($iterator as $value) {
    echo $value; // Output: 6, 8, 10
}
```

## Filters with arguments
The first arguments MUST BE Iterator

```php
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
```

## Examples
[Filter CSV File using Generator](https://github.com/millancore/pipeline-iterator/wiki/Filter-CSV-File-using-Generator)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.




