<?php 
namespace effect;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\item\Item;
use effect\item\WaterBottle;
use pocketmine\event\player\PlayerItemConsumeEvent;
use pocketmine\entity\Effect;
use effect\item\InvisibilityPortion;



class effect extends PluginBase implements Listener{

	
	const Water_Bottle = 373;
	const Invisibility_Portion=374;
	
	
	
	
	public function onLoad(){
		$this->creatItem(self::Water_Bottle, WaterBottle::class);
		$this->creatItem(self::Invisibility_Portion, InvisibilityPortion::class);
	}
	
	
	
	public function onEnable(){
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::RED.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 활성화 되었습니다.");
		
	}
	
	public function onDisable(){
		$pdFile=$this->getDescription();
		$this->getLogger()->info(TextFormat::BLUE.$pdFile->getName()." 버전 ".$pdFile->getVersion()."이(가) 종료되었습니다.");
	}
	
	public function creatItem($id,$class){
		Item::$list[$id]=$class;
		if(Item::isCreativeItem($item= new $class)){
			Item::addCreativeItem($item);
		}
	}
	
    public function PlayerEatEvent(PlayerItemConsumeEvent $event){
    	$player=$event->getPlayer();
    	if($event->getItem()->getId()===441){
    		$effect= Effect::getEffect(14);
    		$effect->setDuration (180 * 20);
    		$effect->setAmplifier (10);
    		$player->addEffect($effect);
    	}
    }
}


	
	
	
	














?>