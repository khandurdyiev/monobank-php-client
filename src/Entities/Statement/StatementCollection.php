<?php

declare(strict_types=1);

namespace Khandurdyiev\MonoClient\Entities\Statement;

class StatementCollection implements \JsonSerializable
{
    /** @var Statement[] */
    private array $collection = [];

    /**
     * @param array<int, array<string, mixed>> $statements
     */
    public function __construct(array $statements)
    {
        foreach ($statements as $statement) {
            $this->collection[] = Statement::create($statement);
        }
    }

    /**
     * @param array<int, array<string, mixed>> $statements
     *
     * @return StatementCollection
     */
    public static function create(array $statements): StatementCollection
    {
        return new self($statements);
    }

    /**
     * @return Statement[]
     */
    public function all(): array
    {
        return $this->collection;
    }

    public function jsonSerialize()
    {
        return $this->all();
    }
}
