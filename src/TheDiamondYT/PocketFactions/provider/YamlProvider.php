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
        foreach($this->pdata->getAll() as $player) {
            //$this->addPlayer($player);
        }
    }
    
    public function getOnlinePlayers() {
        return $this->fplayers;
    }
    
    public function getPlayer(Player $player) {
        return $this->fplayers[$player->getName()];
    }
    
    public function addPlayer(Player $player) {
        $fplayer = new FPlayer($player);
        $fplayer->setFaction($this->getFaction("Wilderness")); // TODO: check for faction
        $this->fplayers[$player->getName()] = $fplayer;
    }
    
    public function removePlayer(Player $player) {
        unset($this->fplayers[$player->getName()]);
    }
    
    public function getFaction(string $tag) {
        if(!$this->factionExists($tag)) // is this even needed?
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
        $this->fdata->save();
    }
    
    public function setFactionTag(Faction $faction) {
        $this->fdata->setNested($faction->getId() . ".tag", $faction->getTag());
        $this->fdata->save();
    }
    
    public function setFactionDescription(Faction $faction) {
        $this->fdata->setNested($faction->getId() . ".desc", $faction->getDescription());
        $this->fdata->save();
    }
    
    public function setFactionLeader(Faction $faction) {
        $this->fdata->setNested($faction->getId() . ".leader", $faction->getLeader()->getName());
        $this->fdata->save();
    }
    
    public function factionExists(string $faction): bool {
        foreach($this->factions as $facs) {
            if($facs->getTag() === $faction)
                return true;
        }
        return false;
    }
    
    public function playerExists(string $name): bool {
        foreach($this->fplayers as $player) {
            if($player->getName() === $name) 
                return true;
        }
        return false;
    }
}
