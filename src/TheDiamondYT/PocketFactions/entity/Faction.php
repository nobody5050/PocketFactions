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
 
namespace TheDiamondYT\PocketFactions\entity;

use pocketmine\utils\UUID;

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\struct\Role;
use TheDiamondYT\PocketFactions\struct\Relation;
use TheDiamondYT\PocketFactions\struct\RelationParticipator;

/**
 * Represents a Faction.
 */
class Faction implements RelationParticipator {

    const WILDERNESS_ID = "7a3ee880-46ba-38df-844e-e073ad0713d4";
    const WARZONE_ID = "4aacbf95-ac8b-3f68-898a-372ee8a818e3";

    private $leader;
    
    private $data;
    private $flags = [];
    
    private $players = [];
    private $allies = [];
    
    /**
     * Constructor.
     *
     * @param string
     * @param array
     */
    public function __construct($id, array $data) {
        $this->id = $id;
        $this->data = $data;
    }
    
    public static function randomId() {
        return UUID::fromRandom()->toString();
    }
    
    /**
     * @return string
     */
    public function getId() {
        return $this->id;
    }
    
    public function describeTo(RelationParticipator $that) {
        return Relation::describeThatToMe($this, $that);
    }
    
    public function getColorTo(RelationParticipator $that) {
        return Relation::getColorToMe($that, $this);
    }
    
    /**
     * @return string
     */
    public function getTag(FPlayer $player = null) {     
        if($player === null) {
            return $this->data["tag"];
        }
        return $this->getColorTo($player) . $this->data["tag"];
    }
    
    /**
     * Set the faction tag.
     *
     * @param string
     */
    public function setTag(string $tag) {
        $this->data["tag"] = $tag;
        $this->update();
    }
    
    /**
     * Set the faction description.
     *
     * @param string
     */
    public function setDescription(string $description) {
        $this->data["description"] = $description;
        $this->update();
    }
    
    /**
     * @return string
     */
    public function getDescription() {
        return $this->data["description"] ?? "";
    }
    
    /**
     * Set whether or not the faction is permanent.
     *
     * @param bool
     */
    public function setPermanent(bool $value) {
        $this->data["permanent"] = $value;
        $this->update();
    }
    
    /**
     * @return bool
     */
    public function isPermanent(): bool {
        return $this->data["permanent"] ?? false;
    }
    
    /**
     * Set whether or not a faction is joinable without invitation.
     *
     * @param bool
     */
    public function setOpen(bool $value) {
        $this->data["open"] = $value;
        $this->update();
    }
    
    /**
     * @return bool
     */
    public function isOpen(): bool {
        return $this->data["open"] ?? false;
    }
    
    /**
     * @return FPlayer[]
     */
    public function getOnlinePlayers() {
        return $this->players;
    }
    
    /**
     * 
     */
    public function getPlayers() {
        
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
     * Send a message to everyone in the faction.
     *
     * @param string
     */
    public function sendMessage(string $text) {
        foreach($this->getOnlinePlayers() as $player) {
            $player->sendMessage(TF::GREEN . $text);
        }
    }
    
    /**
     * Add an alliance with another faction.
     *
     * @param Faction
     */
    public function addAlliance(Faction $faction) {
        $this->allies[$faction->getId()] = $faction; 
    }
   
   /**
    * Remove an alliance with another faction.
    *
    * @param Faction
    */
    public function removeAlliance(Faction $faction) {
        unset($this->allies[$faction->getId()]);
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
     */
    public function setLeader(FPlayer $player) {
        $this->data["leader"] = $player->getName();
        $this->update();
    }
    
    /** 
     * @return FPlayer
     */
    public function getLeader() {
        return $this->data["leader"];
    }
    
    /**
     * Returns true if the current factions the wilderness.
     *
     * @return bool
     */
    public function isNone(): bool {
        return $this->getId() === self::WILDERNESS_ID;
    }
    
    /**
     * Creates a new faction.
     */
    public function create(bool $save = false) {
        PF::get()->getProvider()->createFaction($this, $this->data, $save);
    }
    
    /**
     * Disbands the current faction.
     */
    public function disband() {
        PF::get()->getProvider()->disbandFaction($this->getId());
    }
    
    /**
     * Updates the current faction information.
     */
    public function update() {
        PF::get()->getProvider()->updateFaction($this->data);
    }
}
