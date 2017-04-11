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
 
namespace TheDiamondYT\PocketFactions\entity;

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
    private $plugin;

    private $title = "";
    
    private $faction;
    private $role = Role::UNKNOWN;
    private $chatMode = ChatMode::PUBLIC; // TODO: move these to the functions,
    
    private $adminBypassing = false;
    
    public function __construct(PF $plugin, Player $player) {
        $this->plugin = $plugin;
        $this->player = $player;
    }
    
    public function getPlayer(): Player {
        return $this->player;
    }
    
    /**
     * @return string
     */
    public function getName(): string {
        return $this->player === null ? "Unknown" : $this->player->getName();
    }
    
    /**
     * @return int
     */
    public function getChatMode(): int {
        return $this->chatMode;
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
     * Return the players role prefix.
     *
     * @return string
     */
    public function getPrefix(): string { 
        if($this->role === Role::get("Leader")) {
            return "**";
        } elseif($this->role === Role::get("Moderator")) {
            return "*";
        } else {
            return "";
        }
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
     * Return the players title.
     *
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }
    
    /**
     * Return the players prefix, name and title.
     *
     * @return string
     */
    public function getNameAndTitle(): string {
        return $this->getPrefix() . ($this->title ?? $this->getPrefix()) . " " . $this->getName();
    }
    
    /**
     * Return the players prefix and name.
     *
     * @return string
     */
    public function getNameAndPrefix(): string {
        return $this->getPrefix() . " " . $this->getName();
    }
    
    /**
     * Sends a message to the player.
     *
     * @param string
     */
    public function msg(string $text) {
        if($this->player !== null)
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
     * Toggle admin bypass mode.
     *
     * @param bool 
     */
    public function setAdminBypassing(bool $value) {
        $this->adminBypassing = $value;
    }
    
    /**
     * @return bool
     */
    public function isAdminBypassing(): bool {
        return $this->adminBypassing;
    }
    
    /**
     * Returns true if the player is leader.
     *
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
    public function setFaction(Faction $faction, bool $update = true) { 
        if($this->faction !== null)
            $this->faction->removePlayer($this);
            
        $faction->addPlayer($this); 
        $this->faction = $faction; 
        if($update)
            $this->plugin->getProvider()->setPlayerFaction($this);
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
