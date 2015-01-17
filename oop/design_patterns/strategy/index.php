<?php
interface OutputInterface{
    public function getOutput($string);
}
class JsonOutput implements OutputInterface {
    public function getOutput($string){
        return json_encode(array('output'=>$string));
    }
}

class Calculator{
    public function add($a, $b) {
        return $a+$b;
    }
}

class Page {
    /**
     * @var OutputInterface $object
     */
    var $object;

    /**
     * @var Calculator $calc
     */
    var $calc;
    public function __construct(Calculator $calc) {
        $this->calc = $calc;
    }
    public function setOutput(OutputInterface $object){
        $this->output = $object;
    }

    public function showAdd($a,$b) {
        $resultCalc = $this->calc->add($a,$b);
        return $this->output->getOutput($resultCalc);
    }
}

$page = new Page(new Calculator());
$page->setOutput(new JsonOutput());
echo $page->showAdd(1,4);
