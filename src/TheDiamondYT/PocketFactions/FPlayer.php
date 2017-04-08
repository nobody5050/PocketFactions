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

/**
 * Represents a faction player.
 */
class FPlayer {

    private $player;

    private $title;
    
    private $faction;
    private $role;
    private $chatMode;
    
    /**
     * Constructor.
     * 
     * @param Player 
     */
    public function __construct(Player $player) {
        $this->player = $player;
    }
    
    public function getPlayer(): Player {
        return $this->player;
    }
    
    /**
     * @return string
     */
    public function getName(): string {
        return $this->player->getName();
    }
    
    /**
     * @return int
     */
    public function getChatMode(): int {
        return $this->chatMode ?? ChatMode::PUBLIC;
    }
    
    /**
     * Sets the players chat mode.
     *
     * @param int
     */
    public function setChatMode(int $mode) {
        if(ChatMode::byName($mode) === "unknown")
            throw new \Exception("Invalid chat mode '$mode'");
            
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
     * TODO: tidy this up?
     *
     * @return string
     */
    public function getTitle(): string {
        if($this->role === Role::get("Leader"))
            $prefix = "**";
        elseif($this->role === Role::get("Moderator"))
            $prefix = "*";
        elseif($this->role === Role::get("Member"))
            $prefix = "";
            
        return $prefix . ($this->title ?? $prefix);
    }
    
    /**
     * Sends a message to the player.
     *
     * @param string
     */
    public function msg(string $text) {
        $this->player->sendMessage(TF::YELLOW . $text);
    }
    
    /**
     * Sets the players role in their faction
     *
     * @param int 
     */
    public function setRole($role) {
        //if(!Role::exists($role))
        //    throw new \Exception("Invalid role '$role'");
        
        $this->role = $role;
    }
    
    /**
     * @return int
     */
    public function getRole(): int {
        return $this->role;
    }
    
    /**
     * @return bool
     */
    public function isLeader(): bool {
        return $this->role === Role::get("Leader");
    }
    
    /**
     * Sets the players faction.
     *
     * @param Faction 
     */
    public function setFaction(Faction $faction) { 
        if($this->faction !== null)
            $this->faction->removePlayer($this);
            
        $faction->addPlayer($this); 
        $this->faction = $faction;
    }
    
    /**
     * Leave the current faction.
     */
    public function leaveFaction() {
        $this->faction->removePlayer($this);
        $this->faction = null;
    }
    
    /**
     * @return Faction|null
     */
    public function getFaction() {     
        return $this->faction;
    }
}
