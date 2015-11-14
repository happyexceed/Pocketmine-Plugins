<?php
namespace Light;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\Listener;
use pocketmine\network\protocol\AddEntityPacket;
use pocketmine\network\protocol\SetTimePacket;
use pocketmine\network\protocol\TextPacket;
use pocketmine\network\protocol\AddPlayerPacket;
use pocketmine\entity\Entity;
class Main extends PluginBase implements Listener {
    public function onEnable(){
    	$this->getLogger()->info("LightingJoin enabled!");
    	$this->getServer()->getPluginManager()->registerEvents($this, $this);
    }
   public function onCommand(CommandSender $sender,Command $cmd,$label,array $args) {
    if((strtolower($cmd->getName()) == "strike") && isset($args[0])) {
      if($this->getServer()->getPlayer($args[0]) instanceof Player) {
        $sender->sendMessage("Player not connected");
       } else {
        $player = $this->getServer()->getPlayer($args[0]);
        $level = $player->getLevel();
        $light = new AddEntityPacket();
        $light->type = 93;
        $light->eid = Entity::$entityCount++;
        $light->metadata = array();
        $light->speedX = 0;
        $light->speedY = 0;
        $light->speedZ = 0;
        $light->yaw = $player->getYaw();
        $light->pitch = $player->getPitch();
        $light->x = $player->x;
        $light->y = $player->y;
        $light->z = $player->z;
        foreach($level->getPlayers() as $pl){
            $pl->dataPacket($light);
        }
      }
      return true;
    }
  }    
      
    public function onJoin(PlayerJoinEvent $e){
	$p = $e->getPlayer();
        $level = $p->getLevel();
	$light = new AddEntityPacket();
        $light->type = 93;
        $light->eid = Entity::$entityCount++;
        $light->metadata = array();
        $light->speedX = 0;
        $light->speedY = 0;
        $light->speedZ = 0;
        $light->yaw = $p->getYaw();
        $light->pitch = $p->getPitch();
        $light->x = $p->x;
        $light->y = $p->y;
        $light->z = $p->z;
        foreach($level->getPlayers() as $pl){
            $pl->dataPacket($light);
        } 
     }
  }
