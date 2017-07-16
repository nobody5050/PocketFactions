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
namespace TheDiamondYT\PocketFactions;
 
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\commands\Registry as CommandRegistry;
use TheDiamondYT\PocketFactions\provider\JSONProvider;
 
class Loader extends PluginBase {
	/** @var Loader */
	private static $instance;
	
	private $language;
	
	private $prefix;
	
	private $provider;
	private $commandRegistry;
	
	public static function getInstance(): Loader {
		return self::$instance;
	}
	
	public function onLoad() {
		self::$instance = $this;
	}
	
	public function onEnable() {
		define("START_TIME", microtime(true));
		
		$this->saveDefaultConfig();
		$this->setLanguage();
		$this->setProvider();
		
		$this->prefix = $this->getConfig()->get("prefix");
		
		$this->commandRegistry = new CommandRegistry($this);
		$this->getServer()->getCommandMap()->register(CommandRegistry::class, $this->commandRegistry);
		$this->log($this->translate("console.data-loaded", [
			round(microtime(true) - START_TIME, 2), 
			round(microtime(true) * 1000) - round(START_TIME * 1000)
		]));
	}
	
	private function setLanguage() {
		$lang = $this->getConfig()->get("language", "en");
		$this->language = new Config($this->getFile() . "resources/languages/$lang.yml", Config::YAML);
	}
	
	private function setProvider() {
		$this->provider = new JSONProvider($this);
		$this->provider->load();
	}
	
	public function getProvider() {
		return $this->provider;
	}
	
	public function getFactionMember(string $name) {
	
	}

	public function translate(string $text, array $params = []): string {
		if(!empty($params)) {
			return vsprintf($this->language->getNested($text), $params);
		}
		return $this->language->getNested($text);
	}
	
	public function log(string $text) {
		$this->getServer()->getLogger()->info($this->prefix . TF::YELLOW . " $text");
	}
}
