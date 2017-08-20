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
namespace TheDiamondYT\PocketFactions\listener;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;

use TheDiamondYT\PocketFactions\Loader;

class PlayerListener implements Listener {
	/** @var Loader */
	private $loader;
	
	public function __construct(Loader $loader) {
		$this->loader = $loader;
	}
	
	public function onJoin(PlayerJoinEvent $ev) {
		$player = $ev->getPlayer();
		if($this->getLoader()->playerExists($player)) {
			$member = $this->getLoader()->getPlayer($player);
		} else {
			$member = $this->getLoader()->getProvider()->addNewPlayer($player);
		}
		$member->setOnline(true);
		$member->setPlayer($player);
	}
	
	public function getLoader(): Loader {
		return $this->loader;
	}
}
