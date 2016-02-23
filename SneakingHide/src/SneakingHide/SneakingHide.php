<?php 
namespace SneakingHide;


use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerToggleSneakEvent;
use pocketmine\utils\TextFormat;
use pocketmine\entity\Effect;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\Player;


class SneakingHide extends PluginBase implements Listener{
	
	private $config,$configData;
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::RED.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 활성화 되었습니다.");
		@mkdir($this->getDataFolder());
		$this->config= new Config($this->getDataFolder()."config.yml",Config::YAML,["start"=>false,"Sneaking"=>false,"allowuser"=>[]]);
		$this->configData= $this->config->getAll();
	}
	
	public function onDisable(){
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::BLUE.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 종료되었습니다.");
		$this->config->save();
		$this->config->setAll($this->configData);
	}
	
	public function onHide(PlayerToggleSneakEvent $event){
		$player=$event->getPlayer();
		if($event->isSneaking()&&$this->configData["start"]==true&&$this->configData["Sneaking"]==true){
			   $effect= Effect::getEffect(14);
			   $effect->setDuration (600 * 20);
			   $effect->setAmplifier (10);
			   $player->addEffect($effect);
			   $player->sendMessage(TextFormat::BLUE.$player->getName()."님의 스텔스 모드가 켜졌습니다");
			} 
			elseif(!$event->isSneaking()&&$this->configData["start"]==true&&$this->configData["Sneaking"]==true){
		
				$player->removeEffect(14);
				
		        $player->sendMessage(TextFormat::RED.$player->getName()."님의 스텔스 모드가 꺼졌습니다");
			}
	}
	
	public function onCommand(CommandSender $sender,Command $command, $label,array $args){	
		if(strtolower($command->getName())=="hide"){
			if(!isset($args[0])){
			$sender->sendMessage(TextFormat::GOLD."/hide <on|off|list>");
			$sender->sendMessage(TextFormat::GOLD."/hide <add|del> <플레이어>");
			return true;
			}													
			switch (strtolower($args[0])){
				case "on" :					
					$this->configData["start"]=true;
					$sender->sendMessage(TextFormat::AQUA."Sneaking Hide 작동");
					break;
				case "off":
				    if(!$sender Instanceof Player) return true;
				    $this->configData["start"]=false;
					$sender->sendMessage(TextFormat::AQUA."Sneaking Hide 작동중지");	
					$sender->removeEffect(14);
					break;
				case "add" :
					$target=$this->getServer()->getPlayer($args[1]);
					if(!$target instanceof Player) return true;
					if(!isset($args[1])){
						$sender->sendMessage(TextFormat::RED."유저명을 적어주세요");
					}					
					if(strtolower($args[1])){					
					$this->configData["Sneaking"]=true;
					$sender->sendMessage(TextFormat::AQUA.$target->getName()."님을 추가하였습니다");
					$target->sendMessage("스텔스 모드");
					array_push($this->configData["allowuser"],$args[1]);
					}
					break;
				case "del" :
					$target=$this->getServer()->getPlayer($args[1]);
					if(!$target instanceof Player) return true;
					if(!isset($args[1])){
						$sender->sendMessage(TextFormat::RED."유저명을 적어주세요");
					}					
					if(strtolower($args[1])){
					$this->configData["Sneaking"]=false;
					$sender->sendMessage(TextFormat::AQUA.$target->getName()."님을 삭제하였습니다");
					$target->sendMessage("스텔스 모드 불가능");
					unset($this->configData["allowuser"][array_search($args[1],$this->configData["allowuser"])]);
					}
				    break;
				case "list" :
					foreach ($this->configData["allowuser"] as $userlist){
						$sender->sendMessage(TextFormat::AQUA.$userlist);
						$sender->sendMessage(TextFormat::RED."허용한 유저목록를 불러옵니다");
					}
					break;
				
			}
		}
	}
}


?>