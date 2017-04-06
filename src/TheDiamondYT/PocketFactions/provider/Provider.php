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
 
namespace TheDiamondYT\PocketFactions\provider;

use pocketmine\Player;

use TheDiamondYT\PocketFactions\Faction;

interface Provider {
    public function loadFactions();
    
    public function loadPlayers();
    
    public function getPlayer(Player $player);
    
    public function addPlayer(Player $player);
    
    public function getFaction(string $faction);
    
    public function createFaction(Faction $faction); 
    
    public function disbandFaction(Faction $faction);
    
    public function setFactionTag(Faction $faction);
    
    public function setFactionDescription(Faction $faction);
    
    public function setFactionLeader(Faction $faction);
     
    public function factionExists(string $faction);
}
