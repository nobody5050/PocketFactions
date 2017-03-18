<?php

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
	    $this->getServer()->getCommandMap()->register(FCommandManager::class, new FCommandManager($this));
	}
	
	private function setProvider() {
	    /*switch($this->cfg["provider"]) { // Trying to decide on config format
	        case "sqlite":
	            $provider = new SQLiteProvider($this);
	            break;
	        default:
	            $provider = new SQLiteProvider($this);
	            break;
	    }
	    if($provider instanceof Provider) 
	        $this->provider = $provider;*/
	}
}
