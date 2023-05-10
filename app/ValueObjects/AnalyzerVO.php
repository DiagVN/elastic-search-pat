<?php
namespace Diag\Patient\ElasticSearch\ValueObjects;

class AnalyzerVO
{


    public function __construct(
        private readonly string $analyzerName,
        private readonly string $analyzerTokenizer,
        private readonly array $analyzerFilter
    ) {
        foreach ($this->analyzerFilter as $filter) {
            if (!is_string($filter)) {
                throw new \InvalidArgumentException('Analyzer filter must be string');
            }
        }
    }

    public function getAnalyzerName(): string
    {
        return $this->analyzerName;
    }


    public function getAnalyzerTokenizer(): string
    {
        return $this->analyzerTokenizer;
    }

    public function getAnalyzerFilter(): array
    {
        return $this->analyzerFilter;
    }
}
