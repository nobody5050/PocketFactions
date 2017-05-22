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
use TheDiamondYT\PocketFactions\struct\Role;

class JSONProvider implements Provider {

    private $plugin;
    
    private $factions = [];
    private $players = [];
    
    private $fdata;
    private $pdata;

    public function __construct(PF $plugin) {
        $this->plugin = $plugin;
        @mkdir($plugin->getDataFolder() . "factions");
        @mkdir($plugin->getDataFolder() . "players");
    }
    
    public function save() {
       if($this->fdata !== null)
           $this->fdata->save();
           
       if($this->pdata !== null)
           $this->pdata->save();
    }
    
    public function loadFactions() {
        $directory = $this->plugin->getDataFolder() . "factions/";
        foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $factions) {
            $factions = json_decode($factions); 
            $faction = new Faction($factions["id"], [
                "tag" => $factions["tag"],
                "id" => $factions["id"],
                "description" => $factions["description"],
            ]);
            $this->factions[$faction->getId()] = $faction;
        }
    }
    
    public function loadPlayers() {
         $directory = $this->plugin->getDataFolder() . "players/";
         foreach(new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($directory)) as $players) {
             $players = json_decode($players);
             // TODO
         }
    }
    
    public function getOnlinePlayers() {
        return $this->players;
    }
    
    public function getPlayer($player) {
       if(!$this->playerExists($player))
           return null;
           
       foreach($this->players as $p) {
           if($player === $p->getName()) 
               return $this->players[$p->getName()];
       }
    }
    
    public function addNewPlayer(Player $player, bool $save = true) {
        $this->pdata = new Config($this->getPlayerFile($player->getUniqueId()), Config::JSON);
        $this->pdata->setAll($data = [
            "name" => $player->getName(),
            "displayName" => $player->getDisplayName(),
            "faction" => [
                "id" => Faction::WILDERNESS_ID,
                "role" => Role::get("Member"),
                "title" => ""
            ]
        ]);
        if($save)
            $this->pdata->save();
            
        $this->addPlayer($player);
    }
    
    public function updatePlayer(array $data) {
        $this->pdata->setAll($data);
    }
    
    public function addPlayer(Player $player) {
        $fplayer = new FPlayer($this->plugin, $player, (new Config($this->getPlayerFile($player->getUniqueId()), Config::JSON))->getAll());
        
        $this->players[$player->getName()] = $fplayer;
    }
    
    public function removePlayer(Player $player) {
        unset($this->players[$player->getName()]);
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
        if(!file_exists($file = $this->getFile($id))) 
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
    
    public function playerExists($player): bool {
        foreach($this->players as $p) {
            if($player === $p->getName())
                return true;
        }
        return false;
    }
    
    private function getFile($id) {
        return $this->plugin->getDataFolder() . "factions/" . $id . ".json";
    }
    
    private function getPlayerFile($id) {
        return $this->plugin->getDataFolder() . "players/" . $id . ".json";
    }
}