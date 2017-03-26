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
 * PocketFactions v1.0.0 by Luke (TheDiamondYT)
 * All rights reserved.                         
 */
 
namespace TheDiamondYT\PocketFactions;

use pocketmine\Player;

use TheDiamondYT\PocketFactions\struct\Role;

class FPlayer {

    private $player;

    private $title;
    
    private $faction;
    private $role;
    
    public function __construct(Player $player) {
        $this->player = $player;
    }
    
    /**
     * @return string
     */
    public function getName(): string {
        return $this->player->getName();
    }
    
    public function msg(string $text) {
        $this->player->sendMessage($text);
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
