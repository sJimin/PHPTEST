<?php 

namespace clearInventory;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;

class clearInventory extends PluginBase implements Listener{
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::RED.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 활성화 되었습니다.");
	}
	
	public function onDisable(){
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::BLUE.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 종료되었습니다.");
	}
	
	public function onCommand(CommandSender $sender,Command $command, $label,array $args){
		if(!$sender instanceof Player) return;
		if(strtolower($command->getName())=="clearinv"){
			$sender->getInventory()->clearAll();
			$sender->sendMessage(TextFormat::RED."인벤토리가 초기화 되었습니다.");
		}	
}
  
} 
    
   
?>
