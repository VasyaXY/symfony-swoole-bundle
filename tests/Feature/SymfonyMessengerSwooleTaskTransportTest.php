<?php

namespace vasyaxy\Swoole\Tests\Feature;

use vasyaxy\Swoole\Client\HttpClient;
use vasyaxy\Swoole\Tests\Fixtures\Symfony\TestBundle\Test\ServerTestCase;
use Swoole\Coroutine;

final class SymfonyMessengerSwooleTaskTransportTest extends ServerTestCase
{
    protected function setUp(): void
    {
        $this->markTestSkippedIfXdebugEnabled();
    }

    public function testStartServerDispatchMessage(): void
    {
        $testFile = $this->generateNotExistingCustomTestFile();
        $testFilePath = self::FIXTURE_RESOURCES_DIR.\DIRECTORY_SEPARATOR.$testFile;
        $testFileContent = $this->generateUniqueHash(16);

        $serverRun = $this->createConsoleProcess([
            'swoole:server:run',
            '--host=localhost',
            '--port=9999',
        ], ['APP_ENV' => 'messenger']);

        self::assertFileDoesNotExist($testFilePath);

        $serverRun->setTimeout(10);
        $serverRun->start();

        $this->runAsCoroutineAndWait(function () use ($testFile, $testFileContent): void {
            $client = HttpClient::fromDomain('localhost', 9999, false);
            $this->assertTrue($client->connect());

            $response = $client->send('/message/dispatch', 'POST', [
                'Content-Type' => 'application/x-site-form-urlencoded',
            ], \http_build_query([
                'fileName' => $testFile,
                'content' => $testFileContent,
            ]))['response'];

            $this->assertSame(200, $response['statusCode']);
            $this->assertSame('OK', $response['body']);

            Coroutine::sleep($this->coverageEnabled() ? 1 : 3);
        });

        $serverRun->stop();

        self::assertFileExists($testFilePath);
        self::assertSame($testFileContent, \file_get_contents($testFilePath));
    }

    private function generateNotExistingCustomTestFile(): string
    {
        return 'tfile-'.$this->generateUniqueHash(4).'-'.$this->currentUnixTimestamp().'.txt';
    }
}
