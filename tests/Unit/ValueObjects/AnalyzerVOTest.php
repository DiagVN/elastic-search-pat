<?php
namespace Tests\Unit\ValueObjects;
use Diag\Patient\ElasticSearch\ValueObjects\AnalyzerVO;
use Tests\TestCase;

class AnalyzerVOTest extends TestCase
{
    public function testAnalyzerVO():void
    {
        $analyzerVO = new AnalyzerVO(analyzerName: 'name',analyzerTokenizer: 'text',analyzerFilter: ['ABC123']);
        $this->assertEquals('name',$analyzerVO->getAnalyzerName());
        $this->assertEquals('text',$analyzerVO->getAnalyzerTokenizer());
        $this->assertEquals(['ABC123'],$analyzerVO->getAnalyzerFilter());
    }

    public function testAnalyzerVOInvalidFilter():void
    {
        $this->expectException(\InvalidArgumentException::class);
        $analyzerVO = new AnalyzerVO(analyzerName: 'name',analyzerTokenizer: 'text',analyzerFilter: [[1]]);
    }
}
