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

use pocketmine\IPlayer;

class FactionMember implements IMember {
	/** @var array */
	private $data;
	
	/** @var IPlayer */
	private $player;
	
	public function __construct(IPlayer $player, array $data) {
		$this->player = $player;
		$this->data = $data;
	}
	
	public function getName(): string {
		return $this->data["name"];
	}
	
	public function getTitle(): string {
		return $this->data["title"] ?? "";
	}
	
	public function setTitle(string $title) {
		$this->data["title"] = $title;
	}
	
	public function hasPermission(string $permission): bool {
		if($this->player->hasPermission("pf." . $permission)) {
			return true;
		}
		return false;
	}
}
