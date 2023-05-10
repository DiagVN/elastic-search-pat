<?php
namespace Tests\Unit;

use Diag\Patient\ElasticSearch\ElasticSearch;
use Diag\Patient\ElasticSearch\ValueObjects\PropertyVO;
use Elastic\Elasticsearch\ClientInterface;
use Mockery;
use Tests\TestCase;

class ElasticSearchServiceTest extends TestCase
{
    public function testCreateIndex():void
    {
        $clientMock = Mockery::mock(ClientInterface::class);
        $clientMock->shouldReceive('index')->once()
            ->with([
                'index' => 'name',
                'id' => 1,
                'body' => [
                    'reference_code' => 'ABC123',
                    'status' => 'confirmed',
                    'client_code' => 'CLIENT01',
                    'first_name' => 'John',
                    'date_of_birth' => '1990-01-01',
                    'address' => '123 Main St',
                    'city' => 'Anytown',
                    'patient_id' => 'PATIENT01',
                    'patient_number' => 'PAT001',
                    'document_number' => '123456789',
                    'document_type' => 'passport',
                    'phone_number' => '555-1234',
                    'email' => 'john@example.com',
                    'gender' => 'male',
                    'source_type' => 'website',
                    'note' => 'some note',
                ],
            ])->andReturnTrue();

        $properties = [];
        $properties[] = new PropertyVO(name: 'reference_code',type: 'text',value: 'ABC123');
        $properties[] = new PropertyVO(name: 'status',type: 'text',value: 'confirmed');
        $properties[] = new PropertyVO(name: 'client_code',type: 'text',value: 'CLIENT01');
        $properties[] = new PropertyVO(name: 'first_name',type: 'text',value: 'John');
        $properties[] = new PropertyVO(name: 'date_of_birth',type: 'text',value: '1990-01-01');
        $properties[] = new PropertyVO(name: 'address',type: 'text',value: '123 Main St');
        $properties[] = new PropertyVO(name: 'city',type: 'text',value: 'Anytown');
        $properties[] = new PropertyVO(name: 'patient_id',type: 'text',value: 'PATIENT01');
        $properties[] = new PropertyVO(name: 'patient_number',type: 'text',value: 'PAT001');
        $properties[] = new PropertyVO(name: 'document_number',type: 'text',value: '123456789');
        $properties[] = new PropertyVO(name: 'document_type',type: 'text',value: 'passport');
        $properties[] = new PropertyVO(name: 'phone_number',type: 'text',value: '555-1234');
        $properties[] = new PropertyVO(name: 'email',type: 'text',value: 'john@example.com');
        $properties[] = new PropertyVO(name: 'gender',type: 'text',value: 'male');
        $properties[] = new PropertyVO(name: 'source_type',type: 'text',value: 'website');
        $properties[] = new PropertyVO(name: 'note',type: 'text',value: 'some note');
        $esService = new ElasticSearch($clientMock);
        $esService->index(indexName: 'name',id: 1,properties: $properties);
    }

    public function testUpdateIndex():void
    {
        $clientMock = Mockery::mock(ClientInterface::class);
        $clientMock->shouldReceive('update')->once()
            ->with([
                'index' => 'name',
                'id' => 1,
                'body' => [
                    'doc' => [
                        'reference_code' => 'ABC123',
                        'status' => 'confirmed',
                        'client_code' => 'CLIENT01',
                        'first_name' => 'John',
                        'date_of_birth' => '1990-01-01',
                        'address' => '123 Main St',
                        'city' => 'Anytown',
                        'patient_id' => 'PATIENT01',
                        'patient_number' => 'PAT001',
                        'document_number' => '123456789',
                        'document_type' => 'passport',
                        'phone_number' => '555-1234',
                        'email' => 'john@example.com',
                        'gender' => 'male',
                        'source_type' => 'website',
                        'note' => 'some note',
                    ],
                ],
            ])->andReturnTrue();

        $properties = [];
        $properties[] = new PropertyVO(name: 'reference_code',type: 'text',value: 'ABC123');
        $properties[] = new PropertyVO(name: 'status',type: 'text',value: 'confirmed');
        $properties[] = new PropertyVO(name: 'client_code',type: 'text',value: 'CLIENT01');
        $properties[] = new PropertyVO(name: 'first_name',type: 'text',value: 'John');
        $properties[] = new PropertyVO(name: 'date_of_birth',type: 'text',value: '1990-01-01');
        $properties[] = new PropertyVO(name: 'address',type: 'text',value: '123 Main St');
        $properties[] = new PropertyVO(name: 'city',type: 'text',value: 'Anytown');
        $properties[] = new PropertyVO(name: 'patient_id',type: 'text',value: 'PATIENT01');
        $properties[] = new PropertyVO(name: 'patient_number',type: 'text',value: 'PAT001');
        $properties[] = new PropertyVO(name: 'document_number',type: 'text',value: '123456789');
        $properties[] = new PropertyVO(name: 'document_type',type: 'text',value: 'passport');
        $properties[] = new PropertyVO(name: 'phone_number',type: 'text',value: '555-1234');
        $properties[] = new PropertyVO(name: 'email',type: 'text',value: 'john@example.com');
        $properties[] = new PropertyVO(name: 'gender',type: 'text',value: 'male');
        $properties[] = new PropertyVO(name: 'source_type',type: 'text',value: 'website');
        $properties[] = new PropertyVO(name: 'note',type: 'text',value: 'some note');

        $esService = new ElasticSearch($clientMock);
        $esService->updateIndex(indexName: 'name',id: 1,properties: $properties);
    }
}
