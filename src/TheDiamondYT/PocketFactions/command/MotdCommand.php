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

use TheDiamondYT\PocketFactions\Configuration;
use TheDiamondYT\PocketFactions\Loader;
use TheDiamondYT\PocketFactions\entity\Faction;
use TheDiamondYT\PocketFactions\entity\FactionMember;
use TheDiamondYT\PocketFactions\entity\IMember;

class MotdCommand extends FactionCommand {

	public function __construct(Loader $loader) {
		parent::__construct($loader, "motd");
	}
	
	public function perform(IMember $sender, array $args) {
		if(!$sender instanceof FactionMember) {
			//return true;
		}
		if(!$sender->hasFaction()) {
			$sender->sendMessage($this->getLoader()->translate("commands.not-in-faction"));
			return true;
		}
		$faction = $sender->getFaction();
		$faction->setMotd(($text = implode("", $args)));
		foreach($faction->getMembers() as $member) {
			$member->sendMessage($this->getLoader()->translate("commands.motd.success", [
				$sender->getName(),
				$text
			]));
		}
		return true;
	}
	
	public function getArguments(): string {
		return "<text>";
	}
}
