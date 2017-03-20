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
 
namespace TheDiamondYT\PocketFactions\provider;

use TheDiamondYT\PocketFactions\Main;
use TheDiamondYT\PocketFactions\Faction;

class YamlProvider implements Provider {

    private $plugin;
    private $data;
    
    private $factions = [];

    public function __construct(Main $plugin) {
        $plugin->saveResource("factions.yml");
        $this->data = yaml_parse_file($plugin->getDataFolder() . "factions.yml");
        $this->plugin = $plugin;
    }
    
    public function loadFactions() {
        foreach($this->data as $facs) {
            $faction = new Faction;
            $faction->setTag($facs["tag"]);
            $faction->setDescription($facs["desc"]);
            $this->factions[strtolower($facs["tag"])] = $faction; // TODO: numeric id instead of tag?
        }
    }
    
    public function getFaction($id) {
        if(!$this->factionExists($id)) 
            return false;
            
        return $this->factions[(strtolower($id))];
    }
    
    public function createFaction(Faction $faction) {
        // You should have your own checks using YamlProvider::factionExists($tag)
        // before calling this function.
        // TODO: Maybe remove exception and just return false?
        if($this->factionExists($faction->getTag()))
            throw new \Exception("Error while creating faction: already exists.");
    }
    
    public function setFactionTag($tag) {
        
    }
    
    public function factionExists($tag) {
        return isset($this->data[strtolower($tag)]);
    }
}
