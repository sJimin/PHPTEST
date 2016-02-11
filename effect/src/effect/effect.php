<?php 
namespace effect;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\event\block\SignChangeEvent;
use effect\EffectName\EffectName;


class effect extends PluginBase implements Listener{

	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::RED.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 활성화 되었습니다.");
		
	}
	
	public function onDisable(){
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::BLUE.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 종료되었습니다.");
	}
	
    
    public function onSignChange(SignChangeEvent $event){
    	$getLine0=$event->getLine(0);
    	$getLine1=$event->getLine(1);
    	$getLine2=$event->getLine(2);
    	$player=$event->getPlayer();    	
    	$effectType=array("1","2","3","4","5","8","9","10","11","12","13","14","18","19","20","21");
    	foreach ($effectType as $effectArray){
    	if($getLine0=="effect"&&$getLine1==$effectArray) //speed
    	{
    		$event->setLine(0,TextFormat::RED."[E".TextFormat::GOLD."f".TextFormat::YELLOW."f".TextFormat::GREEN."e".TextFormat::BLUE."c".TextFormat::DARK_PURPLE."t]");
    		$event->setLine(1,EffectName::getEffect($effectArray)->getName());
    	}
    	}
    }
}
    	
    	
    	
    	
    	
    



	
	
	
	














?>