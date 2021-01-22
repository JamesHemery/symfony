<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Notifier\Bridge\SpotHit\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Notifier\Message\MessageInterface;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Notifier\Bridge\SpotHit\SpotHitTransport;

final class SpotHitTransportTest extends TestCase
{
    public function testToString(): void
    {
        $transport = $this->getTransport();

        $this->assertSame('spothit://host.test', (string)$transport);
    }

    public function testToStringContainsProperties(): void
    {
        $transport = $this->getTransport('MyCompany');

        $this->assertSame('spothit://host.test?from=MyCompany', (string)$transport);
    }

    public function testSupportsMessageInterface(): void
    {
        $transport = $this->getTransport('MyCompany');

        $this->assertTrue($transport->supports(new SmsMessage('0612345678', 'Hi !')));
        $this->assertFalse($transport->supports($this->createMock(MessageInterface::class)));
    }

    private function getTransport(?string $from = null): SpotHitTransport
    {
        return (new SpotHitTransport('api_token', $from, $this->createMock(HttpClientInterface::class)))
            ->setHost('host.test');
    }
}
