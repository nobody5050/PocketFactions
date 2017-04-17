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
use pocketmine\Player;
use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\PF;
use TheDiamondYT\PocketFactions\entity\IPlayer;
use TheDiamondYT\PocketFactions\struct\ChatMode;
use TheDiamondYT\PocketFactions\struct\Role;
use TheDiamondYT\PocketFactions\struct\Relation;

class CommandChat extends FCommand {

    public function __construct(PF $plugin) {
        parent::__construct($plugin, "chat", $plugin->translate("commands.chat.description"), ["c"]);
        $this->addRequiredArgument("mode"); 
        
        $this->senderMustBePlayer = true;
    }

    public function perform(IPlayer $fme, array $args) {
        if(!$sender instanceof Player) {
            $this->msg($sender, TF::RED . $this->plugin->translate("commands.only-player"));
            return;
        }
        if($fme->getFaction() === null) {
            $this->msg($sender, $this->plugin->translate("player.no-faction"));
            return;
        }  
        if(empty($args)) {
            $this->msg($sender, $this->getUsage());
            return;
        }
        
        switch($args[0]) {
            case "p":
            case "public":
                $mode = ChatMode::PUBLIC;
                $text = "Public chat mode.";
                break;
            case "f":
            case "faction":
                $mode = ChatMode::FACTION;
                $text = "Faction only chat mode.";
                break;
            case "a":
            case "ally":
                $mode = ChatMode::ALLY;
                $text = "Alliance only chat mode.";
                break;
            default:
                $this->msg($this->plugin->translate("chat.fail"));
                return;
        }
        $fme->setChatMode($mode);
        $this->msg($text);
    }
}
