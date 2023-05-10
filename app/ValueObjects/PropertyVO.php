<?php

namespace Diag\Patient\ElasticSearch\ValueObjects;

class PropertyVO
{
    public function __construct(
        private readonly string $name,
        private readonly string $type,
        private readonly mixed $value = null
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }
}
