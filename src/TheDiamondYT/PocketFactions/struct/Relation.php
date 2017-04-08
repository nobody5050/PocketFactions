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
 
namespace TheDiamondYT\PocketFactions\struct;

use TheDiamondYT\PocketFactions\Faction;
use TheDiamondYT\PocketFactions\FPlayer;

use pocketmine\utils\TextFormat as TF;

/**
 * TODO: some SERIOUS cleanup
 */
class Relation {
    const NEUTRAL = 0;
    const FACTION = 1;
    const ALLY = 2;
    const ENEMY = 3;
    
    public static function describeToPlayer($me, $him) {
        if($me === $him) {
            $text= "You";
        }
        elseif($me->getFaction() === $him->getFaction()) {
            $text = TF::GREEN . $me->getTitle() . " " . $me->getName();
        } else {
            $text = $me->getName();
        }
        return self::getColorToPlayer($me, $him) . $text . TF::YELLOW;
    }
   
    public static function describeToFaction($me, $him) {
        if($me->getFaction() === $him->getFaction()) {
            $text = "your faction";
        } else {
            $text = $faction->getTag();
        } 
        return self::getColorToFaction($me, $him->getFaction()) . $text . TF::YELLOW;
    }
    
    public static function getColorToPlayer($me, $him) {
        if($me->getFaction() === $him->getFaction()) {
            $colour = TF::GREEN;
        } elseif($him->getFaction() !== null && $me->getFaction()->isAllyWith($him->getFaction())) {
            $colour = TF::LIGHT_PURPLE;
        } else {
            $colour = TF::WHITE;
        }
        return $colour;
    }
    
    // This looks horrible lol
    public static function getColorToFaction($mine, $that) {
        if($that->getId() === Faction::WILDERNESS_ID) {
            return TF::DARK_GREEN;
        } elseif($that->getId() === Faction::WARZONE_ID) {
            return TF::DARK_RED;
        } elseif($mine->getFaction() === $that) {
            return TF::GREEN;
        } elseif($mine->getFaction() !== null && $mine->getFaction()->isAllyWith($that)) {
            return TF::LIGHT_PURPLE;
        } else {
            return TF::WHITE;
        }
        return $colour;
    }
}
