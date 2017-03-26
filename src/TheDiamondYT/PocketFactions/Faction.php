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

use TheDiamondYT\PocketFactions\struct\Role;

/**
 * Represents a Faction.
 */
class Faction {

    private $tag;
    private $description;
    private $leader;
    
    private $permanent = false;
    
    private $players = [];
    
    public function getId() {
        return strtolower($this->tag); // TODO: numeric id?
    }
    
    /**
     * @return string
     */
    public function getTag() {     
        return $this->tag;
    }
    
    /**
     * Set the faction tag.
     *
     * @param string
     */
    public function setTag(string $tag) {
        $this->tag = $tag;
    }
    
    /**
     * Set the faction description.
     *
     * @param string
     */
    public function setDescription(string $description) {
        $this->description = $description;
    }
    
    /**
     * @return string
     */
    public function getDescription() {
        return $this->description;
    }
    
    /**
     * Set whether or not the faction is permanent.
     *
     * @param bool
     */
    public function setPermanent(bool $value) {
        $this->permanent = $value;
    }
    
    /**
     * @return bool
     */
    public function isPermanent() {
        return $this->permanent === true;
    }
    
    /**
     * @return FPlayer[]
     */
    public function getOnlinePlayers() {
        return $this->players;
    }
    
    /**
     * Add a player to the faction.
     *
     * @param FPlayer
     */
    public function addPlayer(FPlayer $player) {
        if($player->getRole() === Role::LEADER) 
            $this->leader = $player;
            
        $this->players[$player->getName()] = $player;
    }
    
    /**
     * Remove a player from the faction.
     *
     * @param FPlayer
     */
    public function removePlayer(FPlayer $player) {
        unset($this->players[$player->getName()]);
    }
    
    /**
     * Set the faction leader.
     *
     * @param FPlayer
     */
    public function setLeader(FPlayer $player) {
        $this->leader = $player;
    }
    
    /** 
     * @return FPlayer
     */
    public function getLeader() {
        return $this->leader;
    }
}
