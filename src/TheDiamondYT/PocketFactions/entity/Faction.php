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

class Faction {
	/** @var array */
	private $data;
	
	/** @var string */
	private $id;
	
	/** @var IMember */
	private $leader;

	public function __construct(string $id, array $data) {
		$this->id = $id;
		$this->data = $data;
	}
	
	public function getId(): string {
		return $this->id;
	}
	
	public function getTag(): string {
		return $this->data["tag"];
	}
	
	public function setTag(string $tag) {
		$this->data["tag"] = $tag;
	}
	
	public function getDescription(): string {
		return $this->data["description"];
	}
	
	public function setDescription(string $value) {
		$this->data["description"] = $value;
	}
	
	public function save() {
		//Loader::getInstance()->getProvider()->saveAll();
	}
}
