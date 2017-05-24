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
 * PocketFactions v1.0.1 by Luke (TheDiamondYT)
 * All rights reserved.                         
 */
 
namespace TheDiamondYT\PocketFactions\command;

use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\entity\IPlayer;

class CommandVersion extends FCommand {

    public function __construct(PF $plugin) {
        parent::__construct($plugin, "version", $plugin->translate("commands.version.description"), ["ver", "v"]);
    }
    
    public function getRequirements(): array {
        return [];
    }

    public function perform(IPlayer $fme, array $args) {
        $this->msg($this->plugin->translate("commands.version.success", [$this->plugin->getDescription()->getFullName()]));
        $this->msg(TF::GOLD . "https://github.com/TheDiamondYT1/PocketFactions");
        $this->msg(TF::DARK_PURPLE . "By Luke (TheDiamondYT)");
    }
}
