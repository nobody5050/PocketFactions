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

class FactionRole {
	private $id;
	private $name;
	
	private $aliases = [];

	public function __construct(int $id, string $name, array $aliases = []) {
		$this->id = $id;
		$this->name = $name;
		$this->aliases = $aliases;
	}
	
	public function getId(): int {
		return $this->id;
	}
	
	public function getName(): string {
		$this->name = $name;
	}
	
	public function getAliases(): array {
		return $this->aliases;
	}
}
