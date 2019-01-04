<?php

namespace Dmattern\Http\Tests\Unit;

use Dmattern\Http\FiftySixKayModemRequest;
use PHPUnit\Framework\TestCase;

class DownloadTest extends TestCase
{
    public function testDownloadTakesLongEnough(
        $url = "google.com",
        $method = "get",
        $data = [],
        $skip_assertion = false,
        $show_details = false
    ) {
        $startTime = microtime(true);
        $response  = FiftySixKayModemRequest::$method(['url' => $url, 'data' => $data]);
        $endTime   = microtime(true);
        if ($show_details) {
            echo "Transfer time: " . ($endTime - $startTime) . "\n";
            echo "File size: " . mb_strlen($response) / 1024 . "\n";
            echo "Expected time in seconds: " . mb_strlen($response) / 1024 / 56 . "\n";
            echo "Baud: " . (int)(mb_strlen($response) / ($endTime - $startTime)) . "\n";
        }
        $result = $endTime - $startTime > mb_strlen($response) / 1024 / 56;
        if (!$skip_assertion) {
            $this->assertTrue($result);
        } else {
            return $result;
        }
    }

    public function test200x300TakesLongEnough()
    {
        $this->assertTrue(
            $this->testDownloadTakesLongEnough(
                "https://picsum.photos/200/300/?random",
                "get",
                [],
                true
            )
        );
    }

    public function test500x500TakesLongEnough()
    {
        $this->assertTrue(
            $this->testDownloadTakesLongEnough(
                "https://picsum.photos/500/500/?random",
                "get",
                [],
                true
            )
        );
    }

    public function test1000x1000TakesLongEnough()
    {
        $this->assertTrue(
            $this->testDownloadTakesLongEnough(
                "https://picsum.photos/1000/1000/?random",
                "get",
                [],
                true
            )
        );
    }

    public function test2000x2000TakesLongEnough()
    {
        $this->assertTrue(
            $this->testDownloadTakesLongEnough(
                "https://picsum.photos/2000/2000/?random",
                "get",
                [],
                true
            )
        );
    }

    public function test5000x5000TakesLongEnough()
    {
        $this->assertTrue(
            $this->testDownloadTakesLongEnough(
                "https://picsum.photos/5000/5000/?random",
                "get",
                [],
                true
            )
        );
    }

    public function testPostToURL()
    {
        $this->assertTrue(
            $this->testDownloadTakesLongEnough(
                "http://msn.com",
                "post",
                [
                    'foo' => 'bar'
                ],
                true)
        );
    }

}