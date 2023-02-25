<?php

namespace vasyaxy\Swoole\Component;

use Generator;
use IteratorAggregate;

/**
 * @template T
 * @implements IteratorAggregate<T>
 */
final class GeneratedCollection implements IteratorAggregate
{
    private $items;

    /**
     * @param iterable<T> $itemCollection
     * @param T ...$items
     */
    public function __construct(private readonly iterable $itemCollection, ...$items)
    {
        $this->items = $items;
    }

    /**
     * @return Generator<T>
     * @throws \Exception
     */
    public function each(callable $func): Generator
    {
        foreach ($this->getIterator() as $item) {
            yield $func($item);
        }
    }

    /**
     * @return GeneratedCollection<T>
     * @throws \Exception
     */
    public function map(callable $func): self
    {
        return new self($this->each($func));
    }

    /**
     * @return GeneratedCollection<T>
     * @throws \Exception
     */
    public function filter(callable $func): self
    {
        return new self($this->filterItems($func));
    }

    /**
     * {@inheritdoc}
     *
     * @return Generator<T>
     */
    public function getIterator(): Generator
    {
        yield from $this->itemCollection;

        yield from $this->items;
    }

    /**
     * @return Generator<T>
     * @throws \Exception
     */
    private function filterItems(callable $func): Generator
    {
        foreach ($this->getIterator() as $item) {
            if ($func($item)) {
                yield $item;
            }
        }
    }
}
