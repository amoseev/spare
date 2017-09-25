<?php


namespace Infrastructure\MessageBag\Interfaces;


interface MessageBagInterface
{
    /**
     * Add a message to the bag.
     *
     * @param  string $key
     * @param  string $message
     * @return $this
     */
    public function add($key, $message);

    /**
     * Determine if the message bag has any messages.
     *
     * @return bool
     */
    public function isEmpty();

    /**
     * Get the number of messages in the container.
     *
     * @return int
     */
    public function count();

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray();
}