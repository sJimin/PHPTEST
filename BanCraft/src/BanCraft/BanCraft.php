<?php
namespace BanCraft;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\utils\Config;
use pocketmine\event\inventory\CraftItemEvent;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Player;


class BanCraft extends PluginBase implements Listener{
	
	private $config,$configData;
	
	public function onEnable(){					
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::RED.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 활성화 되었습니다.");
		@mkdir($this->getDataFolder());
		$this->config= new Config($this->getDataFolder()."config.yml",Config::YAML,["CraftBan"=>[]]);
		$this->configData= $this->config->getAll();
		
	}
	
	public function onDisable(){
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::BLUE.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 종료되었습니다.");
		$this->config->save();
		$this->config->setAll($this->configData);
	}
	
	public function onCommand(CommandSender $sender,Command $command, $label,array $args){
	    if (!$sender Instanceof Player) return;
	    $getItemHand=$sender->getInventory()->getItemInHand();
	    $ItemCode=$getItemHand->getId();
		if(strtolower($command->getName())=="bancraft"){
			if(!isset($args[0])) {
				$sender->sendMessage(TextFormat::AQUA."/bancraft <add|remove|reset|list>");
				$sender->sendMessage(TextFormat::GOLD."/bancraft add - 들고있는 아이템 조합을 벤합니다");
				$sender->sendMessage(TextFormat::GOLD."/bancraft remove - 들고있는 아이템 조합벤을 풉니다");
				$sender->sendMessage(TextFormat::GOLD."/bancraft reset - 금지된 조합법들을 초기화 합니다");
				$sender->sendMessage(TextFormat::GOLD."/bancraft list - 금지된 조합법 목록을 확인 합니다");
				return;
			}
			switch (strtolower($args[0])){				
				case "add":	
					$getItemHand=$sender->getInventory()->getItemInHand();
					$banItem=$getItemHand->getId().":".$getItemHand->getDamage();
					array_push($this->configData["CraftBan"],$banItem);
					$sender->sendMessage(TextFormat::RED.$banItem."가 벤되었습니다");						
					break;			
				case "reset":
					$this->configData["CraftBan"]=[];
					$sender->sendMessage(TextFormat::RED."조합 금지 리스트 초기화");
				break;
				case "remove":
					$getItemHand=$sender->getInventory()->getItemInHand();
					$banItem=$getItemHand->getId().":".$getItemHand->getDamage();
					unset($this->configData["CraftBan"][array_search($getItemHand,$this->configData["CraftBan"])]);
				case "list":
					foreach ($this->configData["CraftBan"] as $banlist){
					$sender->getPlayer()->sendMessage(TextFormat::AQUA.$banlist);
					}
			}			 
		}
		$this->config->save();
		$this->config->setAll($this->configData);
	}
	
	
	public function craftEvent(CraftItemEvent $event){
		$player=$event->getPlayer();
		$ItemId=$event->getRecipe()->getResult()->getId().":".$event->getRecipe()->getResult()->getDamage();
		if($this->isData($ItemId)){
			$event->setCancelled(true);
			$event->getPlayer()->sendMessage(TextFormat::RED.$ItemId."조합 금지 블록을 사용하였습니다");
			$event->getPlayer()->kick("담번엔 금지된 아이템을 조합하지 마세요");		
		}
	}
		
	public function isData($item){
		foreach($this->configData["CraftBan"] as $key){
			if($item==$key) return true;
		}
		return false;
	}
}


?>
