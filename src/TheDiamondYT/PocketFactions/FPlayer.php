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

class FPlayer extends Player {

    private $title;
    
    private $factionRole;
    private $factionName;
   
    public function setTitle($title) {
        $this->title = $title;
    }
    
    public function getTitle() {
        return $this->title;
    }
    
    public function setRole(Role $role) {
        $this->role = $role;
    }
    
    public function getRole() {
        return $this->role;
    }
    
    public function setFaction(Faction $faction) { 
        $faction->addPlayer($this); 
        $this->factionName = $faction->getTag();
    }
    
    public function getFaction() {
        if($this->factionName === null)
            return null;
            
        return $this->factionName;
    }
}
