<?php

namespace spec\Crummy\Phlack\Bridge\Guzzle;

use Crummy\Phlack\Bridge\Guzzle\PhlackPlugin;
use Guzzle\Common\Event;
use Guzzle\Http\Message\Request;
use Guzzle\Http\QueryString;
use Guzzle\Http\Url;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhlackPluginSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith('username', 'token');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Crummy\Phlack\Bridge\Guzzle\PhlackPlugin');
    }

    function it_is_an_event_subscriber()
    {
        $this->shouldImplement('\Symfony\Component\EventDispatcher\EventSubscriberInterface');
    }

    function it_subscribes_to_guzzle_events()
    {
        $this->getSubscribedEvents()->shouldHaveKey('request.before_send');
    }

    function it_dispatches_before_send(Event $e, Request $request, Url $url, QueryString $q)
    {
        $e->offsetGet('request')->willReturn($request);
        $request->getUrl(true)->willReturn($url);
        $url->setHost(sprintf(PhlackPlugin::BASE_URL, 'username'))->willReturn($url);
        $url->setScheme('https')->willReturn($url);
        $request->setUrl($url)->shouldBeCalled()->willReturn($request);
        $request->getQuery()->shouldBeCalled()->willReturn($q);

        $this->onRequestBeforeSend($e)->shouldReturn(null);
    }

    public function getMatchers()
    {
        return [
            'haveKey' => function($subject, $key) {
                return array_key_exists($key, $subject);
            },
            'haveValue' => function($subject, $value) {
                return in_array($value, $subject);
            },
        ];
    }
}
