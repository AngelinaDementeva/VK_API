<?php

use PHPUnit\Framework\TestCase;

class EventControllerTest extends TestCase
{
    private $client;
    
    protected function setUp(): void
    {
        $this->client = new GuzzleHttp\Client([
            'base_uri' => 'http://localhost:8000',
            'http_errors' => false,
        ]);
    }

    public function testCreateEvent(): void
    {
        $response = $this->client->post('/api/events', [
            'json' => [
                'name' => 'Test event',
                'authorized' => true,
            ]
        ]);
        
        $this->assertSame(201, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        
        $data = json_decode($response->getBody(), true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertGreaterThan(0, $data['id']);
    }

    public function testCreateEventWithInvalidData(): void
    {
        $response = $this->client->post('/api/events', [
            'json' => [
                'name' => '',
                'authorized' => 'yes',
            ]
        ]);
        
        $this->assertSame(400, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        
        $data = json_decode($response->getBody(), true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('errors', $data);
        $this->assertCount(2, $data['errors']);
    }

    public function testGetEvent(): void
    {
        $response = $this->client->get('/api/events/1');
        
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        
        $data = json_decode($response->getBody(), true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('id', $data);
        $this->assertSame(1, $data['id']);
    }

    public function testGetNonexistentEvent(): void
    {
        $response = $this->client->get('/api/events/100');
        
        $this->assertSame(404, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        
        $data = json_decode($response->getBody(), true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('error', $data);
        $this->assertSame('Event not found', $data['error']);
    }

    public function testGetEvents(): void
    {
        $response = $this->client->get('/api/events');
        
        $this->assertSame(200, $response->getStatusCode());
        $this->assertSame('application/json', $response->getHeaderLine('Content-Type'));
        
        $data = json_decode($response->getBody(), true);
        $this->assertIsArray($data);
        $this->assertArrayHasKey('events', $data);
        $this->assertIsArray($data['events']);
    }

    public function testGetEventsFilteredByName(): void
    {
        $response = $this->client->get('/api/events?name=Test');
        
        $this->assertSame(200, $response->getStatusCode());
        $
