<?php

namespace TheDiamondYT\PocketFactions\subscription;

use TheDiamondYT\PocketFactions\entity\FPlayer;

use TheDiamondYT\PocketFactions\PF;

class SubscriptionManager {
    private $plugin;
    
    private $callbacks = [];
    private $subscriptions = [];

    public function __construct(PF $plugin) {
        $this->plugin = $plugin;
    }
    
    /**
     * Subscribe to a channel.
     *
     * @param  FPlayer  $player
     * @param  string   $sub
     * @param  function $callback
     *
     * @return Subscription
     */
    public function subscribe(FPlayer $player, $sub, $callback = null): Subscription {
        $sub = new $sub;
        
        $this->subscriptions[$player->getName()][$sub->getName()] = $sub;  
        if($callback) {
            $this->callbacks[$player->getName()][$sub->getName()] = $callback;
        }
        
        return $sub;
    }
    
    /**
     * Unsubscribe from a channel.
     *
     * @param FPlayer      $player
     * @param Subscription $sub
     */
    public function unsubscribe(FPlayer $player, Subscription $sub) {
        unset($this->subscriptions[$player->getName()][$sub->getName()]);
        unset($this->callbacks[$player->getName()][$sub->getName()]);
    }
    
    /**
     * Returns the specified subscription.
     *
     * @param  FPlayer $player
     * @param  string  $sub
     *
     * @return Subscription
     */
    public function getSubscription(FPlayer $player, string $sub): Subscription {
        $sub = new $sub;
        return $this->subscriptions[$player->getName()][$sub->getName()];
    }
    
    public function subscriptionExists(FPlayer $player, string $name) {
        foreach($this->subscriptions[$player->getName()] as $sub) {  
            if($sub->getName() === $name) {
                return true;
            }
        }
        return false;
    }
    
    /**
     * Send a message to the channel.
     *
     * @param FPlayer      $player
     * @param Subscription $sub
     * @param string       $text
     */
    public function send(FPlayer $player, Subscription $sub, string $text) {
        $this->callbacks[$player->getName()][$sub->getName()]($text);
    }
} 
