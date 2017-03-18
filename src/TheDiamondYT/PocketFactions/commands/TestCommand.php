<?php

namespace TheDiamondYT\PocketFactions\commands;

use pocketmine\command\CommandSender;

class TestCommand extends FCommand {

    public function __construct(Main $plugin) {
        parent::__construct($plugin, "test", "Test command", "/test <player>");
        $this->setPermission("factions.test");
    }

    public function execute(CommandSender $sender, array $args) {
        $sender->sendMessage("Yay! It works du");
        return true;
    }
}
