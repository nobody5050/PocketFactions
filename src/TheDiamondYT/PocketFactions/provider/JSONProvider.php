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
use TheDiamondYT\PocketFactions\entity\Faction;
use TheDiamondYT\PocketFactions\entity\FactionMember;

class JSONProvider extends BaseProvider {

	public function __construct(Loader $loader) {
		$this->loader = $loader;
		@mkdir($loader->getDataFolder() . "players/");
		@mkdir($loader->getDataFolder() . "factions/");
	}

	public function load() {
		$dataPath = $this->getLoader()->getDataFolder();
		foreach(glob($dataPath . "factions/*.json") as $file) {
			$data = json_decode(file_get_contents($file), true);
			$this->factions[$data["id"]] = new Faction($data["id"], $data);
		}
		foreach(glob($dataPath . "players/*.json") as $file) {
			$data = json_decode(file_get_contents($file), true);
			$this->players[$data["id"]] = new FactionMember($data);
		}
	}
	
	public function addNewPlayer(Player $player) {
		$file = $this->getLoader()->getDataFolder() . "players/" . $player->getUniqueId() . ".json";
		file_put_contents($file, json_encode($data = [
			"id" => $player->getUniqueId(),
			"name" => $player->getName(),
			"faction" => [
				"id" => "wilderness",
				"role" => 0 // TODO
			]
		]));
		$this->players[$player->getUniqueId()] = new FactionMember($data);
	}
	
	public function addNewFaction(Faction $faction, array $data) {
		$file = $this->getLoader()->getDataFolder() . "factions/" . $faction->getId() . ".json";
		file_put_contents($file, json_encode(array_merge([
			"id" => $faction->getId()
		], $data)));
		$this->factions[$faction->getId()] = $faction;
	}
}
