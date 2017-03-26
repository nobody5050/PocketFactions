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

class Faction {

    private $tag;
    private $description = "";
    private $leader;
    
    private $permanent = false;
    
    private $players = [];
    
    public function getId() {
        return strtolower($this->tag); // TODO: numeric id?
    }
    
    public function getTag() {     
        return $this->tag;
    }
    
    public function setTag($tag) {
        $this->tag = $tag;
    }
    
    public function updateTag($tag) {
        $this->tag = $tag;
        PF::get()->getProvider()->setFactionTag($this);
    }
    
    public function setDescription($description) {
        $this->description = $description;
    }
    
    public function getDescription() {
        return $this->description;
    }
    
    public function setPermanent($value) {
        $this->permanent = $value;
    }
    
    public function isPermanent() {
        return $this->permanent === true;
    }
    
    public function getOnlinePlayers() {
        return $this->players;
    }
    
    public function addPlayer(FPlayer $player) {
        if($player->getRole() === Role::LEADER) 
            $this->leader = $player;
            
        $this->players[$player->getName()] = $player;
    }
    
    public function removePlayer(FPlayer $player) {
        unset($this->players[$player->getName()]);
    }
    
    public function setLeader(FPlayer $player) {
        $this->leader = $player;
    }
    
    public function getLeader() {
        return $this->leader;
    }
}
