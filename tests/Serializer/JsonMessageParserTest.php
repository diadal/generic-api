<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Toplib\GenericApi\Tests\Serializer;


use GuzzleHttp\Message\Request;
use GuzzleHttp\Stream\Stream;
use Toplib\GenericApi\Serializer\JsonMessageParser;
use Toplib\SampleApi\Model\Post;

class JsonMessageParserTest extends \PHPUnit_Framework_TestCase
{
    public function testParseNative()
    {
        $message = '{"id":1,"title":"lorem"}';
        $request = new Request('get', '/', [], Stream::factory($message));

        $parser = new JsonMessageParser();
        $array = $parser->parse($request);
        $this->assertEquals(json_decode($message), $array);
    }

    public function testParseSerializer()
    {
        $message = '{"id":1,"title":"lorem"}';
        $request = new Request('get', '/', [], Stream::factory($message));

        /** @var Post $post */
        $parser = new JsonMessageParser(new Post());
        $post = $parser->parse($request);
        $this->assertEquals(1, $post->getId());
        $this->assertEquals('lorem', $post->getTitle());
    }
}
