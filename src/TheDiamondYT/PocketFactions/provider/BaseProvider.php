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
namespace TheDiamondYT\PocketFactions\provider;

use pocketmine\Player;

use TheDiamondYT\PocketFactions\Loader;

abstract class BaseProvider {
	/** @var Loader */
	protected $loader;
	
	/** @var FactionMember[] */
	protected $players = [];
	
	/** @var Faction[] */
	protected $factions = [];
	
	public abstract function load();
	
	public function getPlayers(): array {
		return $this->players;
	}
	
	public function getFactions(): array {
		return $this->factions;
	}
	
	public function getPlayer($param) {
		$name = $param instanceof Player ? $param->getName() : $param;
		foreach($this->players as $player) {
			if($player->getName() === $name) {
				return $player;
			}
		}
		return null;
	}
	
	public function getFaction(string $tag) {
		foreach($this->factions as $faction) {
			if($faction->getTag() === $tag) {
				return $faction;
			}
		}
		return null;
	}
	
	public function playerExists($param): bool {
		return $this->getPlayer($param) !== null;
	}
	
	public function factionExists(string $tag): bool {
		return $this->getFaction($tag) !== null;
	}
	
	public function getLoader(): Loader {
		return $this->loader;
	}
}
