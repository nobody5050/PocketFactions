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
namespace TheDiamondYT\PocketFactions\command;

use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\Configuration;
use TheDiamondYT\PocketFactions\Loader;
use TheDiamondYT\PocketFactions\entity\IMember;

class VersionCommand extends FactionCommand {

	public function __construct(Loader $loader) {
		parent::__construct($loader, "version");
	}
	
	public function perform(IMember $sender, array $args) {
		$sender->sendMessage(Configuration::get("templates.header", [
			$this->getLoader()->translate("commands.version.header-text")
		]));
		$sender->sendMessage($this->getLoader()->translate("commands.version.name", ["PocketFactions"]));
		$sender->sendMessage($this->getLoader()->translate("commands.version.version", [
			$this->getLoader()->getDescription()->getVersion()
		]));
		$sender->sendMessage("");
		$sender->sendMessage(TF::GOLD . "By TheDiamondYT");
		return true;
	}
	
	public function getArguments(): string {
		return "";
	}
}
