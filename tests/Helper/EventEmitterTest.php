<?php

namespace tests\Helper;

use PHPUnit\Framework\TestCase;
use App\Helper\EventEmitter;

class EventEmitterTest extends TestCase
{
    public function testOnPriority()
    {
        $data = "";
        $eventEmitter = new EventEmitter();
        $eventEmitter->on("EVENT_1", function () use (&$data) {
            $data = "imam";
        });
        $eventEmitter->on("EVENT_1", function () use (&$data) {
            $data = "harir";
        }, 1);
        $eventEmitter->emit("EVENT_1", $eventEmitter);
        $this->assertSame($data, "imam");
    }

    public function testOnce()
    {
        $data = "";
        $eventEmitter = new EventEmitter();
        $eventEmitter->once("EVENT_1", function () use (&$data) {
            $data = "imam";
        });
        $eventEmitter->once("EVENT_1", function () use (&$data) {
            $data = "harir";
        });
        $eventEmitter->emit("EVENT_1", $eventEmitter);
        $this->assertSame($data, "imam");
    }

    public function testDetach()
    {
        $data = "";
        $imamCb = function () use (&$data) {
            $data = "imam";
        };
        $eventEmitter = new EventEmitter();
        $eventEmitter->on("EVENT_1", function () use (&$data) {
            $data = "harir";
        });
        $eventEmitter->on("EVENT_1", $imamCb);
        $eventEmitter->detach("EVENT_1", $imamCb);
        $eventEmitter->emit("EVENT_1", $eventEmitter);
        $this->assertSame($data, "harir");
    }

    public function testDetachOnce()
    {
        $data = "";
        $imamCb = function () use (&$data) {
            $data = "imam";
        };
        $eventEmitter = new EventEmitter();
        $eventEmitter->once("EVENT_1", $imamCb);
        $eventEmitter->detach("EVENT_1", $imamCb);
        $eventEmitter->emit("EVENT_1", $eventEmitter);
        $this->assertSame($data, "");
    }

    public function testDetachOnceAll()
    {
        $data = "";
        $imamCb = function () use (&$data) {
            $data = "imam";
        };
        $eventEmitter = new EventEmitter();
        $eventEmitter->on("EVENT_1", $imamCb);
        $eventEmitter->once("EVENT_1", $imamCb);
        $eventEmitter->detachAll("EVENT_1");
        $eventEmitter->emit("EVENT_1", $eventEmitter);
        $this->assertSame($data, "");
    }

    public function testDetachAll()
    {
        $data = "";
        $imamCb = function () use (&$data) {
            $data = "imam";
        };
        $eventEmitter = new EventEmitter();
        $eventEmitter->on("EVENT_1", function () use (&$data) {
            $data = "harir";
        });
        $eventEmitter->on("EVENT_1", $imamCb);
        $eventEmitter->detachAll("EVENT_1");
        $eventEmitter->emit("EVENT_1", $eventEmitter);
        $this->assertSame($data, "");
    }
}
