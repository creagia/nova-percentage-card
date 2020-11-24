# Nova Percentage Card
A Laravel Nova card to display percentages

![alt text](screenshot.png)

## Installation:
```bash
composer require creagia/nova-percentage-card
```

## Usage:
- Create a Class extending \Creagia\NovaPercentageCard\NovaPercentageCard
- Add a new Object to the cards() method

### Basic example
```php
class SpentBudget extends \Creagia\NovaPercentageCard\NovaPercentageCard
{
    /**
     * Get the total of filtered records
     *
     * @return float
     */
    function getCount(): float
    {
        return Order::sum('total');
    }

    /**
     * Get the number of the total records
     *
     * @return float
     */
    function getTotal(): float
    {
        return config('app.total_budget');
    }
}
```

```php
class NovaServiceProvider extends NovaApplicationServiceProvider

...

/**
 * Get the cards that should be displayed on the default Nova dashboard.
 *
 * @return array
 */
protected function cards()
{
    return [
        new SpentBudget,
    ];
}

```
### Full example
```php
class SpentBudget extends \Creagia\NovaPercentageCard\NovaPercentageCard
{
    /**
     * The displayable name of the metric.
     *
     * @var string
     */
    protected $name = 'Spent budget';
    
    /**
     * The label for the total entries.
     *
     * @var string|null
     */
    protected $label = '€';

    /**
     * The number of decimal points
     *
     * @var int
     */
    protected $percentagePrecision = 2;

    /**
     * The width of the card (1/3, 1/2, or full).
     *
     * @var string
     */
    public $width = '1/3';

    /**
     * Get the total of filtered records
     *
     * @return float
     */
     function getCount(): float
    {
        return Order::sum('total');
    }

    /**
     * Get the number of the total records
     *
     * @return float
     */
    function getTotal(): float
    {
        return config('app.total_budget');
    }
    
    /**
     * Determine for how many minutes the metric should be cached.
     *
     * @return  int
     */
    public function cacheFor(): int
    {
        return 0;
    }

    /**
     * Determine the cache key
     *
     * @return  string
     */
    public function cacheKey(): string
    {
        return 'spent-budget-percentage-card';
    }
}
```
