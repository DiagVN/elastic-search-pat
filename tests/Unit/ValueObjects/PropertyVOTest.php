<?php
namespace Tests\Unit\ValueObjects;

use Diag\Patient\ElasticSearch\ValueObjects\PropertyVO;
use Tests\TestCase;

class PropertyVOTest extends TestCase
{
    public function testPropertyVO():void
    {
        $propertyVO = new PropertyVO(name: 'name',type: 'text',value: 'ABC123');
        $this->assertEquals('name',$propertyVO->getName());
        $this->assertEquals('text',$propertyVO->getType());
        $this->assertEquals('ABC123',$propertyVO->getValue());

    }
}
