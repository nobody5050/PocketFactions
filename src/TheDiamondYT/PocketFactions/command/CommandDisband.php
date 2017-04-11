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
use TheDiamondYT\PocketFactions\FPlayer;
use TheDiamondYT\PocketFactions\struct\Role;
use TheDiamondYT\PocketFactions\struct\Relation;

class CommandDisband extends FCommand {

    public function __construct(PF $plugin) {
        parent::__construct($plugin, "disband", $plugin->translate("commands.disband.description"));
    }

    public function execute(CommandSender $sender, $fme, array $args) {
        //if(!$sender instanceof Player) {
        //    $this->msg($sender, TF::RED . $this->plugin->translate("commands.only-player"));
        //    return;
        //}
        if($fme->getFaction() === null && !$fme->isAdminBypassing()) {
            $this->msg($sender, $this->plugin->translate("player.no-faction"));
            return;
        }
        if(!$fme->isLeader() && !$fme->isAdminBypassing()) {
            $this->msg($sender, $this->plugin->translate("player.only-leader"));
            return;
        }
        if($fme->getFaction()->isPermanent()) {
            $this->msg($sender, $this->plugin->translate("faction.permanent"));
            return;
        }
        
        $faction = $fme->getFaction();
        
        if(!empty($args)) {
            if($fme->isAdminBypassing()) {
                $faction = $this->plugin->getFaction($args[0]);
                if($faction === null)
                    $faction = $fme->getFaction();
            }
        }
        
        foreach($faction->getOnlinePlayers() as $player)
            $player->setFaction($this->plugin->getFaction("Wilderness"));
        
        $faction->disband();

        foreach($this->plugin->getProvider()->getOnlinePlayers() as $player) 
            $this->msg($player, $this->plugin->translate("commands.disband.success", [Relation::describeToPlayer($fme, $player), Relation::getColorToPlayer($fme, $player) . $faction->getTag()]));
        
        if($this->cfg["faction"]["logFactionDisband"] === true) 
            PF::log(TF::GRAY . $sender->getName() . " disbanded the faction " . $faction->getName());
    }
}
