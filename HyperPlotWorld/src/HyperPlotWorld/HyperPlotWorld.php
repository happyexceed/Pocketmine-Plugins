<?php
namespace FilipeBR\OwnWorld;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\TextFormat;
use pocketmine\Player;
use pocketmine\level\generator\Generator;
use pocketmine\level\generator\GenerationTask;
use pocketmine\level\Level;
use onebone\economyapi\EconomyAPI;
class OwnWorld extends PluginBase{
	
	public function onEnable(){
		$this->getLogger()->info(TextFormat::YELLOW . "enabled!");
		Generator::addGenerator(OwnWorld::class, Gen::NAME);
	}
	
	public function onDisable(){
		$this->getLogger()->info(TextFormat::RED . "disabled!");
	}
	
	public function onCommand(CommandSender $sender, Command $command, $label, array $args){
		if(strtolower($command->getName()) === "buyworld"){
			if (count($args) < 1 || count($args)>4) return false;
			if(EconomyAPI::getInstance()->myMoney($sender->getName()) < 10000){
				$sender->sendMessage(TextFormat::RED ."[HyperPlot] You don't have enought money. It cost $10000");
				return true;
			}
			
			$world = array_shift($args);
			if(strlen($world) < 3){
				$sender->sendMessage(TextFormat::RED ."[HyperPlot] Small World name");
				return true;
			}
			if ($this->getServer()->isLevelGenerated($world)) {
				$sender->sendMessage(TextFormat::RED ."[HyperPlot] A world named ".$world." already exists");
				return true;
			}
			EconomyAPI::getInstance()->reduceMoney($sender->getName(), 10000);
				$this->getServer()->broadcastMessage(
				$sender->sendMessage(TextFormat::RED ."[HyperPlot]  Creating level ".$sender->getName() . "-". $world . "..."));
				$generator = Generator::getGenerator("ownworld");
				$this->getServer()->generateLevel($sender->getName() . "-".$world,null,$generator,[]);
				$this->getServer()->loadLevel($sender->getName() . "-" . $world);
				
				
			return true;
		}	
		return false;
	}
	
}
