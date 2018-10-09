<?php
class Selector{
    public function __construct($install)
    {
       $this->install = $install;
    }
    public function selectScripts(){
        
        if($this->install){
            $check = 'main';
        }else{
           $check ='install';
        }
         
        $scripts = array_diff(scandir("src/frontend/modules/".$check), array('..', '.','images','styles'));
        foreach($scripts as $key => $value){
                $scripts[$key] = "<script src='src/frontend/modules/".$check."/".$value."' type='text/babel'></script>";    
        }
        return implode("\n",$scripts);
    }
    public function selectStyles(){
        if($this->install){
            echo 0;
        }else{
            $styles = "src/frontend/modules/install/styles/style.css";
            return "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$styles."\">";
        }

    }
} 