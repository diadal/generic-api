<?php

/**
 * This file is part of the GenericApi package.
 *
 * (c) RafaelSR <https://github.com/rafrsr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rafrsr\GenericApi\Tests\Serializer;

use GuzzleHttp\Psr7\Request;
use PHPUnit\Framework\TestCase;
use Rafrsr\GenericApi\Serializer\XMLMessageParser;
use Rafrsr\SampleApi\Model\Post;

class XMLMessageParserTest extends TestCase
{
    public function testParseNative()
    {
        $message = '<post><id>1</id><title>lorem</title></post>';
        $request = new Request('get', '/', [], $message);

        $parser = new XMLMessageParser();
        $xml = $parser->parse($request);
        static::assertEquals(simplexml_load_string($message), $xml);
    }

    public function testParseSerializer()
    {
        $message = '<post><id>1</id><title>lorem</title></post>';
        $request = new Request('get', '/', [], $message);

        /** @var Post $post */
        $parser = new XMLMessageParser(new Post());
        $post = $parser->parse($request);
        static::assertEquals(1, $post->getId());
        static::assertEquals('lorem', $post->getTitle());
    }
}
