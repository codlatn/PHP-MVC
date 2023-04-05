<?php 


namespace System\View;

 use System\Application;

interface ViewInterface{


        //string
        public function getOutput();

        
        //Magic PHP Funciton
        public function __toString(); 


}