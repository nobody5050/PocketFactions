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

use TheDiamondYT\PocketFactions\Loader;
use TheDiamondYT\PocketFactions\entity\IMember;

class CommandHelp extends FactionCommand {

	public function __construct(Loader $loader) {
		parent::__construct($loader, "help");
	}
	
	public function perform(IMember $sender, array $args) {
		$page = ($args[0] ?? 1);
		if($page < 1) {
			$page = 1;
		}
		$commands = [];
		foreach($this->getLoader()->getCommandRegistry()->getCommands() as $command) {
			$commands[] = $command;
		}
		ksort($commands, SORT_NATURAL | SORT_FLAG_CASE);
		$commands = array_chunk($commands, 5);
		$page = (int) min(count($commands), $page);
		
		foreach($commands[$page - 1] as $command) {
			$sender->sendMessage($this->getLoader()->translate("templates.help-page", [
				$command->getUsage(),
				$command->getDescription()
			]));
		}
	}
	
	public function getArguments(): string {
		return "[page]";
	}
}
