<?php
namespace Diag\Patient\ElasticSearch\ValueObjects;

class DefineIndexVO
{

    public function __construct(
        private readonly string     $indexName,
        private readonly int        $numberOfShards,
        private readonly int        $numberOfReplicas,
        private readonly AnalyzerVO $analyzerVO,
        private readonly array $properties,
        private readonly ?string $indexAlias = null,
    ) {
        foreach ($this->properties as $property) {
            if (!$property instanceof PropertyVO) {
                throw new \InvalidArgumentException('PropertyVO is required');
            }
        }
    }
    public function getIndexName(): string
    {
        return $this->indexName;
    }

    public function getIndexAlias(): ?string
    {
        return $this->indexAlias;
    }

    public function getNumberOfShards(): int
    {
        return $this->numberOfShards;
    }

    public function getNumberOfReplicas(): int
    {
        return $this->numberOfReplicas;
    }

    public function getAnalyzerVO(): AnalyzerVO
    {
        return $this->analyzerVO;
    }

    public function getProperties(): array
    {
        return $this->properties;
    }
}
