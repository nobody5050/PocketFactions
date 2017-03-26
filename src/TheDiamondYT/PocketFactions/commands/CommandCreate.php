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
 
namespace TheDiamondYT\PocketFactions\commands;

use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\Faction;
use TheDiamondYT\PocketFactions\FPlayer;
use TheDiamondYT\PocketFactions\struct\Role;

class CommandCreate extends FCommand {

    public function __construct(PF $plugin) {
        parent::__construct($plugin, "create", $plugin->translate("create.desc"), $plugin->translate("create.args"));
    }

    public function execute(CommandSender $sender, $fme, array $args) {
        if(!$sender instanceof Player) {
            $this->msg($sender, TF::RED . $this->plugin->translate("command.mustbeplayer"));
            return;
        }
        if(count($args) >= 2 or count($args) === 0) {
            $this->msg($sender, TF::RED . $this->getUsage());
            return;
        }
        if($this->plugin->factionExists($args[0])) {
            $this->msg($sender, $this->plugin->translate("tag.exists")); 
            return;
        }
        if(strlen($args[0]) > $this->cfg["faction"]["tag"]["maxLength"]) {
            $this->msg($sender, $this->plugin->translate("tag.toolong")); 
            return;
        }
        $faction = new Faction;
        $faction->setTag($args[0]); 
        $faction->create();
              
        $fme->setRole(Role::LEADER);
        $fme->setFaction($faction);
    }
}
