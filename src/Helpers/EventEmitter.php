<?php

namespace App\Helpers;

interface EventEmitter
{
    /**
     * Executes a callback on an emitted event
     * @param String $event
     * @param \Closure $callback
     * @param int $priority highest priority is notified first
     * @return mixed
     */
    public function on(String $event, \Closure $callback, int $priority = 0);

    /**
     * Executes a callback on an emitted event and only once
     * @param String $event
     * @param \Closure $callback
     * @return mixed
     */
    public function once(String $event, \Closure $callback);

    /**
     * Emits an event
     * @param String $event
     * @param mixed ...$args
     * @internal param \Closure $callback
     * @internal param $args
     */
    public function emit(String $event, ...$args);

    /**
     * Detaches a callback from an event
     * @param String $event
     * @param \Closure $callback
     * @return
     * @internal param $args
     * @internal param \Closure $callback
     * @internal param $args
     */
    public function detach(String $event, \Closure $callback);

    /**
     * Detaches all callback from an event
     * @param String $event
     * @return
     * @internal param $args
     * @internal param \Closure $callback
     * @internal param $args
     */
    public function detachAll(String $event);
}