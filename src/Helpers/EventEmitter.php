<?php

namespace App\Helpers;

class EventEmitter
{

    protected $events = [];
    protected $eventsOnce = [];

    /**
     * Executes a callback on an emitted event
     * @param String $event
     * @param \Closure $callback
     * @param int $priority
     * @return mixed
     */
    public function on(String $event, \Closure $callback, int $priority = 0): self
    {
        $this->events[$event][] = [$priority => $callback];
        return $this;
    }

    /**
     * Executes a callback on an emitted event and only once
     * @param String $event
     * @param \Closure $callback
     * @return mixed
     */
    public function once(String $event, \Closure $callback): self
    {
        if (!isset($this->eventsOnce[$event])) {
            $this->eventsOnce[$event] = $callback;
        }
        return $this;
    }

    /**
     * Emits an event
     * @param String $event
     * @param $emitter
     * @internal param \Closure $callback
     * @internal param $args
     */
    public function emit(String $event, self $emitter): void
    {
        if (isset($this->eventsOnce[$event])) {
            $this->eventsOnce[$event]($emitter);
            return;
        }
        if (isset($this->events[$event])) {
            $events = $this->events[$event];
            uasort($events, function ($a, $b) {
                return array_keys($a)[0] < array_keys($b)[0];
            });
            foreach ($events as $callbacks) {
                foreach ($callbacks as $k => $callback) {
                    $callback($emitter);
                }
            }
        }
    }

    public function detach(String $event, \Closure $callback): self
    {
        foreach ($this->events as &$ev) {
            foreach ($ev as $k => $cb) {
                if ($callback == array_values($cb)[0]) {
                    unset($ev[$k]);
                }
            }
        }
        unset($this->eventsOnce[$event]);
        return $this;
    }

    public function detachAll(String $event): self
    {
        foreach ($this->events as &$ev) {
            foreach ($ev as $k => $cb) {
                unset($ev[$k]);
            }
        }
        unset($this->eventsOnce[$event]);
        return $this;
    }
}