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
use TheDiamondYT\PocketFactions\Faction;
use TheDiamondYT\PocketFactions\FPlayer;

class YamlProvider implements Provider {

    private $plugin;
    private $fdata;
    private $pdata;
    
    private $factions = [];
    private $fplayers = [];

    public function __construct(PF $plugin) {
        $this->plugin = $plugin;
        $this->fdata = new Config($plugin->getDataFolder() . "factions.yml", Config::YAML);
        $this->pdata = new Config($plugin->getDataFolder() . "players.yml", Config::YAML);
    }
    
    public function save() {
        $this->fdata->save();
        $this->pdata->save();
    }
    
    public function loadFactions() {
        foreach($this->fdata->getAll() as $id => $facs) {
            $faction = new Faction($id); 
            $faction->setTag($facs["tag"], false);
            $faction->setDescription($facs["desc"] ?? "", false);
            //$faction->setLeader($this->getPlayer($this->plugin->getServer()->getPlayer($facs["leader"])), false); 
            $this->createFaction($faction);
        }
    }
    
    public function loadPlayers() {
        /*foreach($this->pdata->getAll() as $name => $player) {
            $p = $this->plugin->getServer()->getPlayer($name);
            $fplayer = new FPlayer($this->plugin, $p);
            $fplayer->setFaction($this->getFaction($player["faction"]) ?? $this->getFaction("Wilderness"));
            $this->fplayers[$name] = $fplayer;
        }*/
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
        $fplayer->setFaction($this->getFaction("Wilderness"));
        $this->fplayers[$player->getName()] = $fplayer;
        //$this->setPlayerFaction($fplayer);
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

    public function createFaction(Faction $faction) {
        $this->factions[$faction->getId()] = $faction; 
    }
    
    public function disbandFaction(Faction $faction) {
        unset($this->factions[$faction->getId()]);
        $this->fdata->remove($faction->getId());
    }
    
    public function setFactionTag(Faction $faction) {
        $this->fdata->setNested($faction->getId() . ".tag", $faction->getTag());
    }
    
    public function setFactionDescription(Faction $faction) {
        $this->fdata->setNested($faction->getId() . ".desc", $faction->getDescription());
    }
    
    public function setFactionLeader(Faction $faction) {
        $this->fdata->setNested($faction->getId() . ".leader", $faction->getLeader()->getName());
    }
    
    public function setPlayerFaction(FPlayer $player) {
        $this->pdata->setNested($player->getName() . ".faction", $player->getFaction()->getTag());
    }
    
    public function factionExists(string $faction): bool {
        foreach($this->factions as $facs) {
            if($facs->getTag() === $faction)
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
}
