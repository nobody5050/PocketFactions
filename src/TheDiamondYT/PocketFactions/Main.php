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
 * PocketFactions v1.0.0 by Luke (TheDiamondYT)
 * All rights reserved.                         
 */
                                                                                     
namespace TheDiamondYT\PocketFactions;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;

use TheDiamondYT\PocketFactions\provider\Provider;
use TheDiamondYT\PocketFactions\commands\FCommandManager;

class Main extends PluginBase {

    private $provider = null;
    private $cfg;

	public function onEnable() {
	    $this->saveResource("config.yml");
	    $this->cfg = yaml_parse_file($this->getDataFolder() . "config.yml");
	    $this->getServer()->getCommandMap()->register(FCommandManager::class, new FCommandManager($this));
	}
	
	private function setProvider() {
	    switch($this->cfg["provider"]) { 
	        case "sqlite":
	            $provider = new SQLiteProvider($this);
	            break;
	        default:
	            $provider = new SQLiteProvider($this);
	            break;
	    }
	    if($provider instanceof Provider) 
	        $this->provider = $provider;
	}
}
