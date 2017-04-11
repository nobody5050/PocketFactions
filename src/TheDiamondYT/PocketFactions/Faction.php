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
 
namespace TheDiamondYT\PocketFactions;

use pocketmine\utils\UUID;

use TheDiamondYT\PocketFactions\struct\Role;

/**
 * Represents a Faction.
 */
class Faction {

    const WILDERNESS_ID = "7a3ee880-46ba-38df-844e-e073ad0713d4";
    const WARZONE_ID = "4aacbf95-ac8b-3f68-898a-372ee8a818e3";

    private $id;
    private $tag;
    private $description;
    private $leader;
    
    private $permanent = false;
    private $open = false;
    
    private $players = [];
    private $allies = [];
    
    /**
     * Constructor.
     * TODO: check if the id exists.
     *
     * @param string|(nothing)
     */
    public function __construct(string $uuid = "") {
        if($uuid === "") {
            $this->id = UUID::fromRandom()->toString(); 
            return;
        }
        $this->id = $uuid;
    }
    
    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }
    
    /**
     * @return string
     */
    public function getTag() {     
        return $this->tag;
    }
    
    /**
     * Set the faction tag.
     *
     * @param string
     * @param bool
     */
    public function setTag(string $tag, bool $update = true) {
        $this->tag = $tag;
        if($update)
            PF::get()->getProvider()->setFactionTag($this);
    }
    
    /**
     * Set the faction description.
     *
     * @param string
     * @param bool
     */
    public function setDescription(string $description, bool $update = true) {
        $this->description = $description;
        if($update)
            PF::get()->getProvider()->setFactionDescription($this);
    }
    
    /**
     * @return string
     */
    public function getDescription() {
        return $this->description ?? "Default faction description :(";
    }
    
    /**
     * Set whether or not the faction is permanent.
     *
     * @param bool
     */
    public function setPermanent(bool $value) {
        $this->permanent = $value;
    }
    
    /**
     * @return bool
     */
    public function isPermanent(): bool {
        return $this->permanent;
    }
    
    /**
     * Set whether or not a faction is joinable without invitation.
     *
     * @param bool
     */
    public function setOpen(bool $value) {
        $this->open = $value;
    }
    
    /**
     * @return bool
     */
    public function isOpen(): bool {
        return $this->open;
    }
    
    /**
     * @return FPlayer[]
     */
    public function getOnlinePlayers() {
        return $this->players;
    }
    
    /**
     * Add a player to the faction.
     *
     * @param FPlayer
     */
    public function addPlayer(FPlayer $player) {
        if($player->isLeader())
            $this->setLeader($player);
            
        $this->players[$player->getName()] = $player;
    }
    
    /**
     * Remove a player from the faction.
     *
     * @param FPlayer
     */
    public function removePlayer(FPlayer $player) {
        unset($this->players[$player->getName()]);
    }
    
    /**
     * Add an alliance with another faction.
     *
     * @param Faction
     * @param bool
     */
    public function addAlliance(Faction $faction, bool $update = true) {
        $this->allies[$faction->getTag()] = $faction; // TODO: use faction id
        if($update)
            PF::get()->getProvider()->setFactionAlliance($this);
    }
   
   /**
    * Remove an alliance with another faction.
    *
    * @param Faction
    */
    public function removeAlliance(Faction $faction) {
        unset($this->allies[$faction->getTag()]);
    }
    
    /**
     * Returns true if in an alliance with the specified faction.
     *
     * @param Faction
     * @return bool
     */
    public function isAllyWith(Faction $faction): bool {
        if(in_array($faction, $this->allies))
            return true;
        
        return false;
    }
    
    /**
     * Set the faction leader.
     *
     * @param FPlayer
     * @param bool
     */
    public function setLeader(FPlayer $player, bool $update = true) {
        $this->leader = $player;
        if($update)
            PF::get()->getProvider()->setFactionLeader($this);
    }
    
    /** 
     * @return FPlayer
     */
    public function getLeader() {
        return $this->leader;
    }
    
    /**
     * Creates a new faction.
     */
    public function create() {
        PF::get()->getProvider()->createFaction($this);
    }
    
    /**
     * Disbands the current faction.
     */
    public function disband() {
        PF::get()->getProvider()->disbandFaction($this);
    }
}
