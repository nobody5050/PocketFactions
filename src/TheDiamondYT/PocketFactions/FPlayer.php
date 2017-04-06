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
 
namespace TheDiamondYT\PocketFactions;

use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\struct\Role;
use TheDiamondYT\PocketFactions\struct\Relation;
use TheDiamondYT\PocketFactions\struct\ChatMode;

class FPlayer {

    private $player;

    private $title;
    
    private $faction;
    private $role;
    private $chatMode;
    
    public function __construct(Player $player) {
        $this->player = $player;
    }
    
    /**
     * @return string
     */
    public function getName(): string {
        return $this->player->getName();
    }
    
    public function getNameAndTitle(FPlayer $him): string {
        return $this->title . " " . $this->getName();
    }
    
    public function getChatMode(): int {
        return $this->chatMode ?? ChatMode::PUBLIC;
    }
    
    public function setChatMode(int $mode) {
        $this->chatMode = $mode;
    }
    
    /** 
     * Sets the players title in the faction.
     *
     * @param string
     */
    public function setTitle(string $title) {
        $this->title = $title;
    }
  
    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }
    
    public function msg(string $text) {
        $this->player->sendMessage($text);
    }
    
    /**
     * Sets the players role in their faction
     *
     * @param int 
     */
    public function setRole($role) {
        if(Role::byName($role) === "unknown")
            throw new \Exception("Error when setting fplayer role: invalid role '$role'");
        
        $this->role = $role;
    }
    
    /**
     * @return int
     */
    public function getRole(): int {
        return $this->role;
    }
    
    /**
     * Sets the players faction.
     *
     * @param Faction 
     */
    public function setFaction(Faction $faction) { 
        if($this->getFaction() !== null)
            $this->getFaction()->removePlayer($this);
            
        $faction->addPlayer($this); 
        $this->faction = $faction;
    }
    
    /**
     * @return Faction|null
     */
    public function getFaction() {     
        return $this->faction;
    }
}
