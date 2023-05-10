<?php

namespace Diag\Patient\ElasticSearch;

use Diag\Patient\ElasticSearch\ValueObjects\PropertyVO;
use Diag\Patient\ElasticSearch\ValueObjects\DefineIndexVO;
use Elastic\Elasticsearch\ClientInterface;

class ElasticSearch
{
    public function __construct(private readonly ClientInterface $client)
    {
    }

    public function defineIndex(DefineIndexVO $defineIndexVO, ?int $version = null, bool $makeAlias = false): void
    {
        $data = [];
        $data['index'] = $defineIndexVO->getIndexName().'.'.$version;
        $data['body'] = [];
        $data['body']['settings'] = [];
        $data['body']['settings']['number_of_shards'] = $defineIndexVO->getNumberOfShards();
        $data['body']['settings']['number_of_replicas'] = $defineIndexVO->getNumberOfReplicas();
        $data['body']['settings']['analysis'] = [];
        $data['body']['settings']['analysis']['analyzer'] = [];
        $data['body']['settings']['analysis']['analyzer'][$defineIndexVO->getAnalyzerVO()->getAnalyzerName()] = [];
        $data['body']['settings']['analysis']['analyzer'][$defineIndexVO->getAnalyzerVO()->getAnalyzerName()]['tokenizer'] = $defineIndexVO->getAnalyzerVO()->getAnalyzerTokenizer();
        $data['body']['settings']['analysis']['analyzer'][$defineIndexVO->getAnalyzerVO()->getAnalyzerName()]['filter'] = $defineIndexVO->getAnalyzerVO()->getAnalyzerFilter();
        $data['body']['mappings'] = [];
        $data['body']['mappings']['dynamic'] = false;
        $data['body']['mappings']['properties'] = [];
        /* @var PropertyVO $property */
        foreach ($defineIndexVO->getProperties() as $property) {
            $data['body']['mappings']['properties'][$property->getName()]['type'] = $property->getType();
        }

        $this->client->indices()->create($data);
        if ($makeAlias) {
            $this->client->indices()->updateAliases([
                'body' => [
                    'actions' => [
                        [
                            'add' => [
                                'index' => $defineIndexVO->getIndexName().'.'.$version,
                                'alias' => $defineIndexVO->getIndexAlias(),
                            ],
                        ],
                    ],
                ],
            ]);
        }
    }

    public function reindexIndex(int $oldVersion, int $newVersion, DefineIndexVO $defineIndexVO): void
    {
        $this->defineIndex(defineIndexVO: $defineIndexVO, version: $newVersion);
        $this->client->reindex([
            'body' => [
                'source' => [
                    'index' => $defineIndexVO->getIndexName().'.'.$oldVersion,
                ],
                'dest' => [
                    'index' => $defineIndexVO->getIndexName().'.'.$newVersion,
                ],
            ],
        ]);
        $this->client->indices()->updateAliases([
            'body' => [
                'actions' => [
                    [
                        'remove' => [
                            'index' => $defineIndexVO->getIndexName().'.'.$oldVersion,
                            'alias' => $defineIndexVO->getIndexAlias(),

                        ],
                    ],
                    [
                        'add' => [
                            'index' => $defineIndexVO->getIndexName().'.'.$newVersion,
                            'alias' => $defineIndexVO->getIndexAlias(),
                        ],
                    ],
                ],
            ],
        ]);
    }

    public function index(string $indexName,  ?int $id = null, array $properties = []): void
    {
        $data = [];
        $data['index'] = $indexName;
        $data['id'] = $id;
        /* @var  PropertyVO $property*/
        foreach ($properties as $property) {
            if (!$property instanceof PropertyVO) {
                throw new \Exception('PropertyVO is required');
            }
            $data['body'][$property->getName()] = $property->getValue();
        }
        $this->client->index($data);
    }

    public function updateIndex(string $indexName, int $id, array $properties = []): void
    {
        $data = [];
        $data['index'] = $indexName;
        $data['id'] = $id;
        $data['body']['doc'] = [];
        foreach ($properties as $property) {
            if (!$property instanceof PropertyVO) {
                throw new \Exception('PropertyVO is required');
            }
            $data['body']['doc'][$property->getName()] = $property->getValue();
        }
        $this->client->update($data);
    }

    public function dropIndex($indexName): void
    {
        $this->client->indices()->delete(['index' => $indexName]);
    }
}
