<?php


class MagicCall
{
	public function __call($method, $args) {
		$method = '__' . $method;
		$this->$method();
	}

	private function __index() {
		echo "hello world!";
	}

}

$a = new MagicCall();
$a->index();