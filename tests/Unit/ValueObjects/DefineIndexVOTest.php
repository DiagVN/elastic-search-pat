<?php
namespace Tests\Unit\ValueObjects;
use Diag\Patient\ElasticSearch\ValueObjects\AnalyzerVO;
use Diag\Patient\ElasticSearch\ValueObjects\DefineIndexVO;
use Diag\Patient\ElasticSearch\ValueObjects\PropertyVO;
use Tests\TestCase;

class DefineIndexVOTest extends TestCase
{
    public function testDefineIndexVO():void
    {
        $analyzerVO = new AnalyzerVO(analyzerName: 'name',analyzerTokenizer: 'text',analyzerFilter: ['ABC123']);
        $propertyVO = new PropertyVO(name: 'name',type: 'text');
        $defineIndexVO = new DefineIndexVO(
            indexName: 'name',
            numberOfShards: 3,
            numberOfReplicas: 2,
            analyzerVO: $analyzerVO,
            properties: [$propertyVO]);
        $this->assertEquals('name',$defineIndexVO->getIndexName());
        $this->assertEquals($analyzerVO,$defineIndexVO->getAnalyzerVO());
        $this->assertEquals([$propertyVO],$defineIndexVO->getProperties());
        $this->assertEquals(3,$defineIndexVO->getNumberOfShards());
        $this->assertEquals(2,$defineIndexVO->getNumberOfReplicas());
    }

    public function testDefineIndexVOInvalidProperty():void
    {
        $this->expectException(\InvalidArgumentException::class);
        $analyzerVO = new AnalyzerVO(analyzerName: 'name',analyzerTokenizer: 'text',analyzerFilter: ['ABC123']);
        $defineIndexVO = new DefineIndexVO(
            indexName: 'name',
            numberOfShards: 3,
            numberOfReplicas: 2,
            analyzerVO: $analyzerVO,
            properties: [1]);
    }
}
