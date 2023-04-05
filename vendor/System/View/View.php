<?php

namespace System\View;

use \System\File;

class View implements ViewInterface
{




    //proproty: 

    private  $file;

    private  $data;

    private  $viewPath;

    private  $output;



    //methods 

    public function __construct(File $file, $viewPath, array $data )
    {
        $this->file = $file;

        $this->preparePath($viewPath);

        $this->data = $data;
    }

  
    //viod
    public function preparePath(string $viewPath)
    {
        $relativePath = 'App/Views/'.$viewPath.'.php';
         $this->viewPath = $this->file->to($relativePath);

           
         
         if(!$this->viewFileExists($relativePath)){
            die($viewPath . ' The file Not exist');
         }
    }

    //bool if view path exists
    public function viewFileExists($viewPath)
    {
        return file_exists($this->file->to($viewPath));
    }
  //string
  public function getOutput()
  {
     if(is_null($this->output)){
        ob_start();
        
        extract($this->data);
        
        require $this->viewPath;
         

        $this->output = ob_get_clean();
     }

    return $this->output;
  }

    //Magic PHP Funciton
    public function __toString()
    {
        return $this->getOutput();
    }
}
