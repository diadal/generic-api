<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi\Tests;

use Toplib\GenericApi\ApiFactory;
use Toplib\GenericApi\ApiInterface;
use Toplib\GenericApi\GenericApi;
use Toplib\GenericApi\GenericApiMock;
use Toplib\GenericApi\GenericApiService;

/**
 * Class GenericApiMockTest
 */
class GenericApiTest extends \PHPUnit_Framework_TestCase
{

    public function testMode()
    {
        $api = new GenericApi(ApiInterface::MODE_MOCK);
        $this->assertTrue($api->isModeMock());
        $api->setMode(ApiInterface::MODE_SANDBOX);
        $this->assertTrue($api->isModeSandBox());
        $api->setMode(ApiInterface::MODE_LIVE);
        $this->assertTrue($api->isModeLive());
    }

    public function testGenericApi()
    {
        $api = new GenericApi(ApiInterface::MODE_MOCK); //can use MODE_LIVE

        $request = ApiFactory::createRequest('get', 'http://jsonplaceholder.typicode.com/posts/1');

        $mockCallback = function () {
            return ApiFactory::createResponse(file_get_contents(__DIR__ . '/../sample/Fixtures/post1.json'));
        };
        $request->setMock(new GenericApiMock($mockCallback));

        $service = new GenericApiService($request);
        $response = $api->process($service);

        $this->assertEquals('200', $response->getStatusCode());
        $this->assertEquals(1, json_decode($response->getBody()->getContents(), true)['id']);
    }
}
