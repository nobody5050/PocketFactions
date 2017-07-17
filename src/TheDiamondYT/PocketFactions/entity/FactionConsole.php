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

use pocketmine\command\ConsoleCommandSender;

// Used to allow executing commands from the console
class FactionConsole implements IMember {
	/** @var ConsoleCommandSender */
	private $sender;
	
	public function __construct(ConsoleCommandSender $sender) {
		$this->sender = $sender;
	}
	
	public function getName(): string {
		return "Console";
	}
	
	public function isOnline(): bool {
		return true;
	}
	
	public function setOnline(bool $online) {
		// no
	}
	
	public function getTitle(): string {
		return "";
	}
	
	public function setTitle(string $title) {
		// no
	}
	
	public function hasPermission(string $permission): bool {
		return true;
	}
	
	public function sendMessage(string $text) {
		$this->sender->sendMessage($text);
	}
}
