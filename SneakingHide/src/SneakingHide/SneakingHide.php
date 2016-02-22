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
		$this->config= new Config($this->getDataFolder()."config.yml",Config::YAML,["start"=>false]);
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
		if($event->isSneaking()&&$this->configData["start"]==true){
			   $effect= Effect::getEffect(14);
			   $effect->setDuration (600 * 20);
			   $effect->setAmplifier (10);
			   $player->addEffect($effect);
			   $player->sendMessage(TextFormat::BLUE.$player->getName()."님의 스텔스 모드가 켜졌습니다");
			} 
			elseif(!$event->isSneaking()&&$this->configData["start"]==true){
		
				$player->removeEffect(14);
				
		        $player->sendMessage(TextFormat::RED.$player->getName()."님의 스텔스 모드가 꺼졌습니다");
			}
	}
	
	public function onCommand(CommandSender $sender,Command $command, $label,array $args){
		if(!$sender Instanceof Player){
			$sender->sendMessage("플레이어가 존재하지 않습니다"); return;		
		if(strtolower($command->getName())=="hide"){
			$sender->sendMessage("/hide <on|off>");
			switch (strtolower($args[0])){
				case "on" :
					$this->configData["start"]=true;
					$sender->sendMessage(TextFormat::AQUA."Sneaking Hide 작동");
					break;
				case "off" :
				    $this->configData["start"]=false;
					$sender->sendMessage(TextFormat::AQUA."Sneaking Hide 작동중지");
					break;
			}
			}
		}
	}
}


?>