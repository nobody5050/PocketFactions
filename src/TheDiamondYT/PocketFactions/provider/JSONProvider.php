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
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\entity\Faction;
use TheDiamondYT\PocketFactions\entity\FPlayer;

// TODO: reimplement provider
class JSONProvider {

    private $plugin;
    
    private $factions = [];
    private $fplayers = [];
    
    private $fdata;

    public function __construct(PF $plugin) {
        $this->plugin = $plugin;
        @mkdir($plugin->getDataFolder() . "factions");
        @mkdir($plugin->getDataFolder() . "players");
    }
    
    public function save() {
       $this->fdata->save();
    }
    
    public function loadFactions() {
        // TODO: fix
        foreach(scandir($this->plugin->getDataFolder() . "factions") as $facs) {
            $facs = json_decode($facs); 
            $faction = new Faction($facs["id"], [
                "tag" => $facs["tag"],
                "id" => $facs["id"],
                "description" => $facs["description"],
            ]);
            $this->factions[$faction->getId()] = $faction;
        }
    }
    
    public function loadPlayers() {
         
    }
    
    public function getOnlinePlayers() {
        return $this->fplayers;
    }
    
    public function getPlayer($player) {
        if($player instanceof Player) 
            return $this->fplayers[$player->getName()];
            
        return $this->fplayers[$player];
    }
    
    public function addPlayer(Player $player) {
        $fplayer = new FPlayer($this->plugin, $player);
        $this->fplayers[$player->getName()] = $fplayer;
    }
    
    public function removePlayer(Player $player) {
        unset($this->fplayers[$player->getName()]);
    }
    
    public function getFaction(string $tag) {
        if(!$this->factionExists($tag)) 
            return null;
        
        foreach($this->factions as $facs) {
            if($facs->getTag() === $tag)
                return $this->factions[$facs->getId()];
        }
    }

    public function createFaction(Faction $faction, array $data, bool $save = false) {
        $this->fdata = new Config($this->getFile($faction->getId()), Config::JSON);
        $this->fdata->setAll($data);
        
        $configSave = $this->plugin->getConfig()["faction"]["saveOnCreate"];
        if($save === true or $configSave === true) 
            $this->fdata->save();
            
        $this->factions[$faction->getId()] = $faction; 
    }
    
    public function disbandFaction(string $id) {
        if(!file_exists($file = $this->getFile($id, ".json"))) 
            return;
                
        unlink($file);
        unset($this->factions[$id]);
    }
    
    public function updateFaction(array $data) {
        $this->fdata->setAll($data);
    }
    
    public function factionExists(string $faction): bool {
        foreach($this->factions as $facs) {
            if($facs->getTag() === $faction or $facs->getId() === $faction)
                return true;
        }
        return false;
    }
    
    public function playerExists(string $name): bool {
        /*foreach($this->fplayers as $player) {
            if($player->getName() === $name) 
                return true;
        }*/
        return false;
    }
    
    private function getFile($id){
        return $this->plugin->getDataFolder() . "factions/" . $id . ".json";
    }
}
