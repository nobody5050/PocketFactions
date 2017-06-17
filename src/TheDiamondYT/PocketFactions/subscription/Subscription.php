<?php

namespace TheDiamondYT\PocketFactions\subscription;

use TheDiamondYT\PocketFactions\PF;

abstract class Subscription {

    /**
     * Short-hand for sending a message to the channel.
     *
     * @param string $text
     */
    public function send(string $text) {
        PF::getInstance()->getSubscriptionManager()->send($this, $text);
    }

    abstract function getName(): string;
}
