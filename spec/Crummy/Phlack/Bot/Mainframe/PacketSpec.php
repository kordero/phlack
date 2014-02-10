<?php

namespace spec\Crummy\Phlack\Bot\Mainframe;

use Crummy\Phlack\WebHook\CommandInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PacketSpec extends ObjectBehavior
{
    function let(CommandInterface $command)
    {
        $this->beConstructedWith(['command' => $command]);
    }

    function it_is_an_encodable_guzzle_event_with_an_options_resolver()
    {
        $this->shouldHaveType('Crummy\Phlack\Bot\Mainframe\Packet');
        $this->shouldBeAnInstanceOf('\Guzzle\Common\Event');
        $this->shouldImplement('\Crummy\Phlack\Common\Encodable');
    }
}
