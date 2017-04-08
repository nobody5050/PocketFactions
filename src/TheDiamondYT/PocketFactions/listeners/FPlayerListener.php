<?php
/*
 *  _____           _        _   ______         _   _                 
 * |  __ \         | |      | | |  ____|       | | (_)                
 * | |__) |__   ___| | _____| |_| |__ __ _  ___| |_ _  ___  _ __  ___ 
 * |  ___/ _ \ / __| |/ / _ \ __|  __/ _` |/ __| __| |/ _ \| '_ \/ __|
 * | |  | (_) | (__|   <  __/ |_| | | (_| | (__| |_| | (_) | | | \__ \
 * |_|   \___/ \___|_|\_\___|\__|_|  \__,_|\___|\__|_|\___/|_| |_|___/
 * 
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.     
 *
 * PocketFactions v1.0.1 by Luke (TheDiamondYT)
 * All rights reserved.                         
 */
 
namespace TheDiamondYT\PocketFactions\listeners;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\struct\Relation;
use TheDiamondYT\PocketFactions\struct\ChatMode;

class FPlayerListener implements Listener {

    private $plugin;
    
    public function __construct(PF $plugin) {
        $this->plugin = $plugin;
    }
    
    public function onPlayerJoin(PlayerJoinEvent $event) {
        $this->plugin->getProvider()->addPlayer($event->getPlayer());
    }
    
    public function onPlayerQuit(PlayerQuitEvent $event) {
        $this->plugin->getProvider()->removePlayer($event->getPlayer());
    }
    
    public function onPlayerChat(PlayerChatEvent $event) {
        $fme = $this->plugin->getPlayer($event->getPlayer());
        foreach($this->plugin->getProvider()->getOnlinePlayers() as $player)
            switch($fme->getChatMode()) {
                case ChatMode::PUBLIC:
                    return;
                case ChatMode::FACTION:
                    $colour = TF::GREEN;
                    break;
                case ChatMode::ALLY:
                    $colour = TF::LIGHT_PURPLE;
            }
            $event->setCancelled(true);
            $this->plugin->getServer()->broadcastMessage($colour . $fme->getTitle() . " " . $fme->getName() . " " . $event->getMessage());
        }
}
