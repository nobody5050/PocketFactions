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

use pocketmine\Player;

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\Faction;

class YamlProvider implements Provider {

    private $plugin;
    private $data;
    
    private $factions = [];
    private $fplayers = [];

    public function __construct(PF $plugin) {
        $this->plugin = $plugin;
        $plugin->saveResource("factions.yml");
        $this->data = yaml_parse_file($plugin->getDataFolder() . "factions.yml");
    }
    
    public function load() {
        $startTime = round(microtime(true) * 1000);
        $this->loadFactions();
        $this->loadPlayers();
        $endTime = round(microtime(true) * 1000) - $startTime;
        $this->plugin->getLogger()->info(sprintf("Loaded faction and player data, took %sms.", $endTime)); // TODO: Translation
    }
    
    public function loadFactions() {
        foreach($this->data as $facs) {
            $faction = new Faction;
            $faction->setTag($facs["tag"]);
            $faction->setDescription($facs["desc"]);
            $this->factions[strtolower($facs["tag"])] = $faction; // TODO: numeric id instead of tag?
        }
    }
    
    public function loadPlayers() {
    
    }
    
    public function getPlayer() {
        
    }
    
    public function addPlayer(Player $player) {
        $this->fplayers[$player->getName()] = new FPlayer($player);
    }
    
    public function getFaction($faction) {
        if(!$this->factionExists($faction)) 
            return false;
            
        return $this->factions[(strtolower($faction))];
    }
    
    public function createFaction(Faction $faction) {
        // You should have your own checks using YamlProvider::factionExists($tag)
        // before calling this function.
        // TODO: Maybe remove exception and just return false?
        if($this->factionExists($faction->getId()))
            throw new \Exception("Error while creating faction: already exists.");
            
        //$this->setFactionTag($faction->getTag());
        //$this->setFactionDescription($faction->getDescription());
    }
    
    public function disbandFaction(Faction $faction) {
        
    }
    
    public function setFactionTag($tag) {
        
    }
    
    public function setFactionDescription($description) {
    
    }
    
    public function factionExists($faction) {
        return isset($this->data[strtolower($faction)]);
    }
}
