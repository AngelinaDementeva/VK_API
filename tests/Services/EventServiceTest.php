require_once 'EventService.php';

class EventServiceTest extends PHPUnit_Framework_TestCase
{
    private $eventService;

    public function setUp()
    {
        $this->eventService = new EventService();
    }

    public function testSaveEvent()
    {
        $result = $this->eventService->saveEvent('test', true);
        $this->assertTrue($result);

        $result = $this->eventService->saveEvent('', true);
        $this->assertFalse($result);

        $result = $this->eventService->saveEvent('test', 'invalid_param');
        $this->assertFalse($result);
    }

    public function testGetStatistics()
    {
        
        $this->eventService->saveEvent('test1', true);
        $this->eventService->saveEvent('test1', false);
        $this->eventService->saveEvent('test2', false);

        // aggregate = null
        $result = $this->eventService->getStatistics('test1');
        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]['count']);

        // aggregate = 'event'
        $result = $this->eventService->getStatistics('test1', null, 'event');
        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]['count']);
        $this->assertEquals('test1', $result[0]['name']);

        // aggregate = 'ip'
        $result = $this->eventService->getStatistics('test1', null, 'ip');
        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]['count']);
        $this->assertNotEmpty($result[0]['ip_address']);

        // aggregate = 'status'
        $result = $this->eventService->getStatistics('test1', null, 'status');
        $this->assertCount(2, $result);
        foreach ($result as $row) {
            if ($row['is_authorized']) {
                $this->assertEquals(1, $row['count']);
            } else {
                $this->assertEquals(1, $row['count']);
            }
        }

        // date = '2022-05-10'
        $result = $this->eventService->getStatistics('test1', '2022-05-10');
        $this->assertCount(0, $result);

        // date = '2023-05-10'
        $result = $this->eventService->getStatistics('test1', '2023-05-10');
        $this->assertCount(1, $result);
        $this->assertEquals(2, $result[0]['count']);
    }
}
