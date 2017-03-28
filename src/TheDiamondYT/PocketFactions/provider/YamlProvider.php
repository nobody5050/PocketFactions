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
        $this->checkDefaultFactions();
        foreach($this->fdata->getAll() as $facs) {
            $faction = new Faction;
            $faction->setTag($facs["tag"], false);
            $faction->setDescription($facs["desc"] ?? "", false);
            //$faction->setLeader($this->getPlayer($this->plugin->getServer()->getPlayer($facs["leader"])), false); 
            $this->factions[$faction->getId()] = $faction;
        }
    }
    
    // TODO: move to main class?
    private function checkDefaultFactions() {
        if(!$this->factionExists("Wilderness")) {
            $faction = new Faction;
            $faction->create();
            $faction->setTag("Wilderness");
            $faction->setPermanent(true);
        }
        if(!$this->factionExists("WarZone")) {
            $faction = new Faction;
            $faction->create();
            $faction->setTag("WarZone");
            $faction->setDescription("Not the safest place to be.");
            $faction->setPermanent(true);
        }
    }
    
    public function loadPlayers() {
        foreach($this->pdata->getAll() as $player) {
            $this->addPlayer($player);
        }
    }
    
    public function getOnlinePlayers() {
        return $this->fplayers;
    }
    
    public function getPlayer(Player $player) {
        return $this->fplayers[$player->getName()];
    }
    
    public function addPlayer(Player $player) {
        $this->fplayers[$player->getName()] = new FPlayer($player);
    }
    
    public function removePlayer(Player $player) {
        unset($this->fplayers[$player->getName()]);
    }
    
    public function getFaction(string $faction) {
        if(!$this->factionExists($faction)) 
            return null;
                  
        return $this->factions[strtolower($faction)];
    }

    public function createFaction(Faction $faction) {
        $this->factions[$faction->getId()] = $faction; // TODO: numeric id instead of tag?
    }
    
    public function disbandFaction(Faction $faction) {
        unset($this->factions[$faction->getId()]);
        // TODO: remove from file too, but idk how
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
    
    public function factionExists(string $faction) {
        return isset($this->fdata->getAll()[strtolower($faction)]);
    }
}
