<?php

namespace effect\listener;

use effect\database\PluginData;
use pocketmine\event\Listener;
use pocketmine\plugin\Plugin;
use effect\listener\other\ListenerLoader;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\Server;
use pocketmine\utils\TextFormat;

class EventListener implements Listener {
	/**
	 *
	 * @var Plugin
	 */
	private $plugin;
	private $db;
	private $listenerloader;
	/**
	 *
	 * @var Server
	 */
	private $server;
	public function __construct(Plugin $plugin) {
		$this->plugin = $plugin;
		$this->db = PluginData::getInstance ();
		$this->listenerloader = ListenerLoader::getInstance ();
		$this->server = Server::getInstance ();
		
		$this->registerCommand("portionsign", "portionsign.command.allow", "portionsign-description", "portionsign-help");
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $plugin );
	}
	public function registerCommand($name, $permission, $description, $usage) {
		$name = $this->db->get ( $name );
		$description = $this->db->get ( $description );
		$usage = $this->db->get ( $usage );
		$this->db->registerCommand ( $name, $permission, $description, $usage );
	}
	public function getServer() {
		return $this->server;
	}
	public function onCommand(CommandSender $player, Command $command, $label, array $args) {
		// TODO - 명령어처리용
		if (strtolower ( $command ) == $this->db->get ( "portionsign" )) { // TODO <- 빈칸에 명령어
			if (!isset( $args [0] )) {
				// TODO - 명령어만 쳤을경우 도움말 표시
				$player->sendMessage(TextFormat::AQUA."/portionsign 1 =>KOR 설명서");
				$player->sendMessage(TextFormat::AQUA."/portionsign 2 =>ENG manual");
				$player->sendMessage(TextFormat::AQUA."/포션표지판 1 =>KOR 설명서");
				$player->sendMessage(TextFormat::AQUA."/포션표지판 2 =>ENG manual");
				$player->sendMessage(TextFormat::RED."알림:신속&구속&체력신장 작동X");
				$player->sendMessage(TextFormat::RED."Notice:Speed&Slowness&HealthBoost(x)");
				return true;
			}
			if (strtolower( $args[0])=="1"){
				$player->sendMessage(TextFormat::RED."<<표지판 포션 플러그인 설명서>>");
				$player->sendMessage(TextFormat::BLUE."표지판 첫째줄 effect 둘째줄 포션효과 아이디");
				$player->sendMessage(TextFormat::BLUE."표지판 첫째줄 effect 둘째줄 remove");
				$player->sendMessage(TextFormat::GOLD."1:신속 2:구속 3:성급함 4:피로 5:힘 8:점프강좌");
				$player->sendMessage(TextFormat::GOLD."9:멀미 10:재생 11:저항 12:화염저항 13:수중호흡");	
				$player->sendMessage(TextFormat::GOLD."14:투명화 18:나약함 19:독 20:위더 21:체력신장");
			}
			if(strtolower( $args[0])=="2"){
				$player->sendMessage(TextFormat::RED."<<Sign Portion plugin's manual>>");
				$player->sendMessage(TextFormat::BLUE."Sign's First line=>effect Second line=>effectid");
				$player->sendMessage(TextFormat::BLUE."Sign's First line=>effect Second line=>remove");
				$player->sendMessage(TextFormat::GOLD."1:Speed 2:Slowness 3:Haste 4:Fatigue 5:Strength ");
				$player->sendMessage(TextFormat::GOLD."8:JumpBoost 9:Nausea 10:Regeneration 11:Resistance");	
				$player->sendMessage(TextFormat::GOLD."12:FireResistance 13:WaterBreathing 14:Invisibility");
				$player->sendMessage(TextFormat::GOLD."18:Weakness 19:Poison 20:Wither 21:HealthBoost");
			}
			
			switch (strtolower ( $args [0] )) {
				case $this->db->get ( "" ) :
					// TODO ↗ 빈칸에 세부명령어
					// TODO 세부명령어 실행시 원하는 작업 실행			
					break;
				case $this->db->get ( "" ) :
					// TODO ↗ 빈칸에 세부명령어
					// TODO 세부명령어 실행시 원하는 작업 실행
					break;
				default :
					// TODO - 잘못된 명령어 입력시 도움말 표시
					break;
			}
			return true;
		}
	}
}

?>
