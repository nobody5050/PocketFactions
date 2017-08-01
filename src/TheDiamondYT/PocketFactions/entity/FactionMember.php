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
 * PocketFactions by Luke (TheDiamondYT)
 * All rights reserved.
 */
namespace TheDiamondYT\PocketFactions\entity;

use pocketmine\Player;

use TheDiamondYT\PocketFactions\relation\Relation;
use TheDiamondYT\PocketFactions\relation\RelationParticipator;

class FactionMember implements IMember {
	/** @var array */
	private $data;
	
	/** @var Faction[] */
	private $factions = [];
	
	/** @var Player */
	private $player;
	
	public function __construct(array $data) {
		$this->data = $data;
	}
	
	public function setPlayer(Player $player) {
		$this->player = $player;
	}
	
	public function getName(): string {
		return $this->data["name"];
	}
	
	public function isOnline(): bool {
		return $this->data["online"] ?? false;
	}
	
	public function setOnline(bool $online) {
		$this->data["online"] = $online;
	}
	
	public function getTitle(string $faction): string {
		return $this->data["factions"][$faction]["title"] ?? "";
	}
	
	public function setTitle(string $faction, $string $title) {
		$this->data["factions"][$faction]["title"] = $title;
	}
	
	public function getFactions(): array {
		return $this->factions;
	}
	
	public function getFaction(string $faction) {
		return $this->factions[$faction] ?? null!
	}
	
	public function describeTo(RelationParticipator $object) {
		return Relation::describeTo($this, $object);
	}
	
	public function getColorTo(RelationParticipator $object) {
		return Relation::getColorTo($this, $object);
	}
	
	public function hasPermission(string $permission): bool {
		if($this->player->hasPermission("pf." . $permission)) {
			return true;
		}
		return false;
	}
	
	public function sendMessage(string $text) {
		$this->player->sendMessage($text);
	}
}
