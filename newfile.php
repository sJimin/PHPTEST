<?php 
		
interface Man{
	function move();
	function _shout();
}
	
class Human implements Man{
	function move(){
		echo("Defect user's movement");
	}
	function _shout(){
		echo("Nice to meet you");
	}
}

class Robot implements Man{
	function move(){
		echo("Defect Robot's movement");
	}
	function _shout(){
		echo("Nice to meet you");
	}
}

$n= new Human();
$n->move();
$n->_shout();

$i= new Robot();
$i-> move();
$i-> _shout();

//hm님 강좌 연습
?>