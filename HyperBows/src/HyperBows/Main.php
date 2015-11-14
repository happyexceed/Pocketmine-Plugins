<?php
namespace HyperBows;
use pocketmine\utils\TextFormat as MT;
use pocketmine\event\Listener;
use pocketmine\event\inventory\InventoryPickupArrowEvent;
use pocketmine\plugin\PluginBase;
use pocketmine\Server;
class Main extends PluginBase implements Listener{
public function onEnable(){
	$this->getServer()->getPluginManager()->registerEvents($this,$this);
    $this->getServer()->getLogger()->info(MT::BOLD . MT::GOLD . "M" . MT::AQUA . "HyperBows " . MT::GREEN . "Enabled" . MT::RED . "!!!!!");
$this->getServer()->getLogger()->info(MT::BOLD . MT::GOLD . "Hyper" . MT::AQUA . "Developers " . MT::BLUE . "Hyper Devlopers Team");
    }
public function onPickUp(\pocketmine\event\inventory\InventoryPickupArrowEvent $event){
    $event->setCancelled(true);
}
}
