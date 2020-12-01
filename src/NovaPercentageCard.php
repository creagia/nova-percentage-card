<?php

namespace Creagia\NovaPercentageCard;

use Illuminate\Support\Str;
use Laravel\Nova\Card;
use Laravel\Nova\Nova;

abstract class NovaPercentageCard extends Card
{
    /**
     * The displayable name of the metric.
     *
     * @var string
     */
    protected $name;

    /**
     * The label for the total entries.
     *
     * @var string|null
     */
    protected $label;

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
    abstract function getCount(): float;

    /**
     * Get the number of the total records
     *
     * @return float
     */
    abstract function getTotal(): float;

    /**
     * Get the component name for the element.
     *
     * @return string
     */
    public function component()
    {
        return 'nova-percentage-card';
    }

    public function getPercentagePrecision(): int
    {
        return $this->percentagePrecision;
    }

    /**
     * Get the displayable name of the metric.
     *
     * @return string
     */
    public function name(): string
    {
        return $this->name ?: Nova::humanize($this);
    }

    /**
     * Determine for how many time the metric should be cached.
     *
     * @return  \DateTimeInterface|\DateInterval|float|int
     */
    public function cacheFor()
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
        return Str::slug(static::class);
    }

    /**
     * Prepare the metric for JSON serialization.
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return array_merge(parent::jsonSerialize(), [
            'cardClass' => static::class,
            'cacheKey' => $this->cacheKey(),
            'name' => $this->name(),
            'label' => $this->label,
            'ttl' => $this->cacheFor(),
        ]);
    }
}
