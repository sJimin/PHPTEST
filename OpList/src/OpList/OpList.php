<?php

namespace OpList;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\Config;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\Player;
use pocketmine\event\player\PlayerQuitEvent;
use pocketmine\utils\TextFormat;

class OpList extends PluginBase implements Listener {
	private $oplists, $oplistData;
	public function onEnable() {
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
		$pdFile = $this->getDescription ();
		$this->getLogger ()->info ( TextFormat::RED . $pdFile->getName () . " 버전 " . $pdFile->getVersion () . "이(가) 활성화 되었습니다." );
		@mkdir ( $this->getDataFolder () );
		$this->oplists = new Config ( $this->getDataFolder () . "oplists.yml", Config::YAML, [ 
				"oplists" => [ ] 
		] );
		$this->oplistData = $this->oplists->getAll ();
	}
	public function onDisable() {
		$pdFile = $this->getDescription ();
		$this->getLogger ()->info ( TextFormat::BLUE . $pdFile->getName () . " 버전 " . $pdFile->getVersion () . "이(가) 종료되었습니다." );
		$this->oplistData ["oplists"] = [ ];
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		$MaxPlayers = $this->getServer ()->getMaxPlayers ();
		$OPcounts = count ( $this->oplistData ["oplists"] );
		if (strtolower ( $command->getName () ) == "oplist") {
			foreach ( $this->oplistData ["oplists"] as $getOpList ) {
				
				$sender->sendMessage ( TextFormat::RED . "현재 접속중인 관리자 " . $OPcounts . "/" . $MaxPlayers . "\n" . TextFormat::AQUA . $getOpList );
				
				if ($OPcounts == 0) {
					$sender->sendMessage ( TextFormat::RED . "현재 접속중인 관리자가 없습니다" );
				}
			}
		}
		$this->oplists->save ();
		$this->oplists->setAll ( $this->oplistData );
	}
	public function PlayerJoinEvent(PlayerJoinEvent $event) {
		$player = $event->getPlayer ();
		if (! $player instanceof Player)
			return;
		if ($player->isOp ()) {
			array_push ( $this->oplistData ["oplists"], $player->getName () );
			$this->oplists->save ();
			$this->oplists->setAll ( $this->oplistData );
		}
		if (! $player->isOp ()) {
			unset ( $this->oplistData ["oplists"] [array_search ( $player->getName (), $this->oplistData ["oplists"] )] );
		}
	}
	public function PlayerQuitEvent(PlayerQuitEvent $event) {
		$player = $event->getPlayer ();
		if (! $player instanceof Player)
			return;
		if ($player->isOp ()) {
			unset ( $this->oplistData ["oplists"] [array_search ( $player->getName (), $this->oplistData ["oplists"] )] );
			$this->oplists->save ();
			$this->oplists->setAll ( $this->oplistData );
		}
	}
	Public function list() {
	}
}

?>