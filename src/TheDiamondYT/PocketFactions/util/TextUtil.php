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
 
namespace TheDiamondYT\PocketFactions\util;

use pocketmine\utils\TextFormat as TF;

use TheDiamondYT\PocketFactions\PF;

class TextUtil {

    /**
     * Creates a title header.
     *
     * @param string
     * @return string
     */
    public static function titleize(string $text): string {
        $length = PF::getInstance()->getConfig()["faction"]["headerLength"] ?? 7;
        return TF::GOLD . str_repeat("_", $length) . ".[ " . TF::WHITE . $text . TF::RESET . TF::GOLD . " ]." . str_repeat("_", $length);
    }
    
    /**
     * Check if a string contains alphanumeric characters.
     *
     * @param string 
     * @return bool
     */
    public static function alphanum(string $text) {
        if(function_exists("ctype_alnum")) 
            return ctype_alnum($text);
                  
        return preg_match("/^[a-z0-9]+$/i", $text) > 0;
    }
 
    /**
     * Replaces colour codes.
     * DONT LOOK AT THIS! The over use of str_replace may harm you.
     *
     * @param string
     * @return string
     */
    public static function parse(string $text): string {
		// Colours
        $text = str_replace("<black>", TF::BLACK, $text);
		$text = str_replace("<darkblue>", TF::DARK_BLUE, $text);
		$text = str_replace("<darkgreen>", TF::DARK_GREEN, $text);
		$text = str_replace("<cyan>", TF::DARK_AQUA, $text);
		$text = str_replace("<darkred>", TF::DARK_RED, $text);
		$text = str_replace("<purple>", TF::DARK_PURPLE, $text);
		$text = str_replace("<gold>", TF::GOLD, $text);
		$text = str_replace("<gray>", TF::GRAY, $text);
		$text = str_replace("<darkgray>", TF::DARK_GRAY, $text);
		$text = str_replace("<blue>", TF::BLUE, $text);
		$text = str_replace("<green>", TF::GREEN, $text);
		$text = str_replace("<aqua>", TF::AQUA, $text);
		$text = str_replace("<red>", TF::RED, $text);
		$text = str_replace("<pink>", TF::LIGHT_PURPLE, $text);
		$text = str_replace("<yellow>", TF::YELLOW, $text);
		$text = str_replace("<white>", TF::WHITE, $text);
		
		// Extra
		$text = str_replace("<i>", TF::YELLOW, $text);
        return $text;
    }
}
