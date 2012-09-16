<?php

require_once("_config.php");
require_once (CORE_PATH."dictionary.php");

class DictionaryTest extends PHPUnit_Framework_TestCase
{
    public $dict;
    public $path;

    public function setUp(){
        $this->path = "dictionary.xml";
        $this->dict = new System\Dictionary($this->path);
    }

    public function testSingleWithS(){
        $word_single = $this->dict->get_single("houses");
        $this->assertTrue($word_single == "house");
    }

    public function testSingleWithOutS(){
        $word_single = $this->dict->get_single("house");
        $this->assertTrue($word_single == "house");
    }

    public function testSingleFromTheDict(){
        $word_single = $this->dict->get_single("People");
        $this->assertTrue($word_single == "Person");
    }

}
?>