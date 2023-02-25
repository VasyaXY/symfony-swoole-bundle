<?php

namespace vasyaxy\Swoole\Tests\Feature;

use vasyaxy\Swoole\Client\HttpClient;
use vasyaxy\Swoole\Tests\Fixtures\Symfony\TestBundle\Test\ServerTestCase;

final class SymfonyProfilerTest extends ServerTestCase
{
    protected function setUp(): void
    {
        // problem with messenger support in symfony profiler in symfony 4.3
        $this->markTestSkippedIfSymfonyVersionIsLoverThan('6.2.0');
        $this->markTestSkippedIfXdebugEnabled();
    }

    public function testAdvancedStaticFilesServerWithAutoRegistration(): void
    {
        $serverRun = $this->createConsoleProcess([
            'swoole:server:run',
            '--host=localhost',
            '--port=9999',
        ], ['APP_ENV' => 'profiler']);

        $serverRun->setTimeout(10);
        $serverRun->start();

        $this->runAsCoroutineAndWait(function (): void {
            $client = HttpClient::fromDomain('localhost', 9999, false);
            $this->assertTrue($client->connect());

            $response = $client->send('/twig')['response'];

            $this->assertSame(200, $response['statusCode']);
            $this->assertNotEmpty($response['headers']['x-debug-token']);
            $debugToken = $response['headers']['x-debug-token'];

            $profilerResponse = $client->send('/_wdt/'.$debugToken)['response'];

            $this->assertStringContainsString('sf-toolbar-block-logger sf-toolbar-status-red', $profilerResponse['body']);
        });

        $serverRun->stop();
    }
}
