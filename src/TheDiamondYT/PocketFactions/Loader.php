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

use TheDiamondYT\PocketFactions\command\Registry as CommandRegistry;
use TheDiamondYT\PocketFactions\provider\JSONProvider;
use TheDiamondYT\PocketFactions\listener\PlayerListener;
 
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
		$this->getServer()->getPluginManager()->registerEvents(new PlayerListener($this), $this);
		
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
		switch($this->getConfig()->get("provider", "json")) {
			case "json":
				$this->provider = new JSONProvider($this);
				break;
		}
		$this->provider->load();
	}
	
	public function getProvider() {
		return $this->provider;
	}
	
	/**
	 * @param Player|string $param
	 */
	public function getPlayer($param) {
		return $this->getProvider()->getPlayer($param);
	}
	
	/**
	 * @param string $tag
	 */
	public function getFaction(string $tag) {
		return $this->getProvider()->getFaction($tag);
	}
	
	/**
	 * @param Player|string $param
	 */
	public function playerExists($param): bool {
		return $this->getProvider()->playerExists($param);
	}
	
	/**
	 * @param string $tag
	 */
	public function factionExists(string $tag): bool {
		return $this->getProvider()->factionExists($tag);
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
