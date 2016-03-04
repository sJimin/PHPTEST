<?php

namespace Calculator;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\utils\TextFormat;
use pocketmine\command\CommandSender;
use pocketmine\command\Command;

class Calculator extends PluginBase implements Listener {
	public function onEnable() {
		$this->getServer ()->getPluginManager ()->registerEvents ( $this, $this );
		$pdFile = $this->getDescription ();
		$this->getLogger ()->info ( TextFormat::RED . $pdFile->getName () . " 버전 " . $pdFile->getVersion () . "이(가) 활성화 되었습니다." );
	}
	public function onDisable() {
		$pdFile = $this->getDescription ();
		$this->getLogger ()->info ( TextFormat::BLUE . $pdFile->getName () . " 버전 " . $pdFile->getVersion () . "이(가) 종료되었습니다." );
	}
	public function onCommand(CommandSender $sender, Command $command, $label, array $args) {
		if (strtolower ( $command->getName () ) == "m") {
			if (! isset ( $args [0] )) {
				$sender->sendMessage ( TextFormat::GREEN . " [Calculator]" . TextFormat::GRAY . "/m help1 /m help2" );
				return true;
			}
			if ($args [0] == "sum") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] )) {
					$sender->sendMessage ( TextFormat::RED . "/sum a b => a+b" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY. $this->sum ( $args [1], $args [2] ) );
			}
			if ($args [0] == "square") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/square a => a²" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->square ( $args [1] ) );
			}
			if ($args [0] == "subtract") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] )) {
					$sender->sendMessage ( TextFormat::RED . "/subtract a b => a-b" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->subtract ( $args [1], $args [2] ) );
			}
			if ($args [0] == "divide") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] )) {
					$sender->sendMessage ( TextFormat::RED . "/divide a b => a÷b" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->divide ( $args [1], $args [2] ) );
			}
			if ($args [0] == "root") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/root a => √a" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->root ( $args [1] ) );
			}
			if ($args [0] == "abs") {
				if (! isset ( $args [1] )) {
					$sender->sendMessage ( TextFormat::RED . "/abs -1 => 1" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->absvalue ( $args [1] ) );
			}
			if ($args [0] == "plane") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] ) || ! isset ( $args [3] ) || ! isset ( $args [4] )) {
					$sender->sendMessage ( TextFormat::RED . "/plane x1 y1 x2 y2 => √(x1-x2)²+(y1-y2)²" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->PlaneDistance ( $args [1], $args [2], $args [3], $args [4] ) );
			}
			if ($args [0] == "trapezoid") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] ) || ! isset ( $args [3] )) {
					$sender->sendMessage ( TextFormat::RED . "/trapzoid Top Bottom Height => TrapezoidArea" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->TrapezoidArea ( $args [1], $args [2], $args [3] ) );
			}
			if ($args [0] == "multiply") {
				if (! isset ( $args [1] ) || ! isset ( $args [2] )) {
					$sender->sendMessage ( TextFormat::RED . "/multiply a b => a×b" );
					return true;
				}
				$sender->sendMessage ( TextFormat::GREEN . "[Calculator] Result => " . TextFormat::GRAY . $this->multiply ( $args [1], $args [2] ) );
			}
			if ($args [0] == "help1") {
				$sender->sendMessage($this->help1 ());
			}
			if ($args [0] == "help2") {
				$sender->sendMessage($this->help2 ());
			}
		}
	}
	public function sum($args1, $args2) {
		return $args1 + $args2;
	}
	public function square($args1) {
		return pow ( $args1, 2 );
	}
	public function multiply($args1, $args2) {
		return $args1 * $args2;
	}
	public function subtract($args1, $args2) {
		return $args1 - $args2;
	}
	public function divide($args1, $args2) {
		$share = floor ( $args1 / $args2 );
		$rest = fmod ( $args1, $args2 );
		return $res = "몫 : " . $share . "나머지 : " . $rest;
	}
	public function root($args1) {
		return sqrt ( $args1 );
	}
	public function absvalue($args1) {
		return abs ( $args1 );
	}
	public function PlaneDistance($args1, $args2, $args3, $args4) {
		return sqrt ( pow ( $args1 - $args3, 2 ) + pow ( $args2 - $args4, 2 ) );
	}
	function TrapezoidArea($args1, $args2, $args3) {
		return ($args1 + $args2) * $args3 / 2;
	}
	public function help1() {
		$list1 = TextFormat::YELLOW."/m square a , a를 제곱해줍니다 \n";
		$list2 = TextFormat::YELLOW."/m abs a , a의 절대값을 구해줍니다 \n";
		$list3 = TextFormat::YELLOW."/m root a , a의 제곱근을 구해줍니다 \n";
		$list4 = TextFormat::YELLOW."/m subtract a b , a에서 b를 빼줍니다 \n";
		$list5 = TextFormat::YELLOW."/m sum a b , a와 b를 더해줍니다 \n";
		return $list1 . $list2 . $list3 . $list4 . $list5;
	}
	public function help2() {
		$list6 = TextFormat::YELLOW."/m divide a b , a 에서 b를 나눠줍니다 \n";
		$list7 = TextFormat::YELLOW."/m multiply a b , a와 b를 곱해줍니다 \n";
		$list8 = TextFormat::YELLOW."/m plane x1 y1 x2 y2 , 두점 (x1,y1),(x2,y2) 사이 거리를 구해줍니다 \n";
		$list9 = TextFormat::YELLOW."/m trapezoid top bottom height , 사다리꼴의 넓이를 구해줍니다";
		return $list6 . $list7 . $list8 . $list9;
	}
}

?>