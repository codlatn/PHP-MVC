<?php

namespace System;

class Html
{


    //store app obj
    protected  $app;

    private $title;

    private $description;

    private $keyWords;


    public function setTitle($title): void
    {
        $this->title = $title;
    }


    public function setDescription($description): void
    {
        $this->description = $description;
    }


    public function setKeyWords($keyWords): void
    {
        $this->keyWords = $keyWords;
    }

    public function getTitle(): string
    {
        return $this->title;
    }


    public function getDescription($description): string
    {
        return $this->description;
    }


    public function getKeyWords($keyWords): string
    {
        return  $this->keyWords;
    }
}
