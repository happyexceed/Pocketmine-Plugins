<?php
namespace WarnMe;
use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\ConsoleCommandExecutor;
use pocketmine\Player;
use pocketmine\utils\Config;
class Main extends PluginBase implements CommandExecutor{
  public funtion onEnable(){
	$this->saveDefaultConfig();
	$this->getResource("config.yml");
	if(!file_exists($this->plugin->getDataFolder() . "Warns/")){
		@mkdir($this->plugin->getDataFolder() . "Warns/");
	}
    	$this->getLogger()->info("WarnMe Loaded!");
  }
  
  public function onCommand(CommandSender $sender, Command $cmd, $label, array $args){
	switch($cmd->getName()){
		case "warn":
			if(isset($args[0])){
				$player = $args[0];
        			if(($player->getServer()->getPlayer($name)) instanceof Player){
          				if(!file_exists($this->plugin->getDataFolder() . "Warns/$player.yml")){
						$warns = new Config($this->plugin->getDataFolder() . "Warns/$player.yml", Config::YAML);
		        			$warns->set("warns", "0");
	        				$warns->save();
		     			}else{
		        			$warns = new Config($this->plugin->getDataFolder() . "Warnss/$player.yml", Config::YAML);
		      			}
          			if(isset($args[1])){
            				$reason = implode($args[1]);
            				$warns->set("warns", $warns->get("warns") + 1);
            				$warns->save();
            				$this->getServer()->broadcastMessage("[HyperWarn] Warning, ".$player.", ".$reason."!");
            				if($warns->get("warns") >= $this->config->get("MaxWarns")){
              					$BanType = $this->config->get("BanType");
              					if($BanType = "name"){
                					$sender->getServer()->getNameBans()->addBan($player, $reason, null, $sender->getName());
			          			$player->kick($reason);
              					}elseif($BanType = "ip"){
               						$ip = $player->getAddress();
                					$sender->getServer()->getIPBans()->addBan($ip, $reason, null, $sender->getName());
                					foreach($sender->getServer()->getOnlinePlayers() as $all){
			            				if($all->getAddress() === $ip){
                    							$all->kick($reason);
			            				}
			          			}
              					}
            				}
          			}else{
            				$warns->set("warns", $warns->get("warns") + 1);
            				$warns->save();
            				$this->getServer()->broadcastMessage("[HyperWarn] Warning, ".$player."!");
            				if($warns->get("warns") >= $this->config->get("MaxWarns")){
              					$BanType = $this->config->get("BanType");
              					if($BanType = "name"){
                					$sender->getServer()->getNameBans()->addBan($player, "Too many warnings!", null, $sender->getName());
			          			$player->kick("Too many warnings!");
              					}elseif($BanType = "ip"){
                					$ip = $player->getAddress();
                					$sender->getServer()->getIPBans()->addBan($ip, "Too many warnings!", null, $sender->getName());
                					foreach($sender->getServer()->getOnlinePlayers() as $all){
			            				if($all->getAddress() === $ip){
                    							$all->kick("Too many warnings!");
			            				}
			          			}
              					}
            				}
        			 }
        		}else{
          			$sender->sendMessage("[HyperWarn] Player ".$player." could not be found on the server!");
        		}
      		}else{
        		$sender->sendMessage("Usage: /warn <player> [reason]");
        		return true;
      		}
    		break;
    	} 
  }
  
  public function onDisable(){
    $this->getConfig()->save();
    $this->getLogger()->info("HyperWarned Unloaded!");
  }
}
?>
