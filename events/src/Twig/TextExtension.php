<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
namespace App\Twig;
/**
 * Description of TextExtension
 *
 * @author lucyna
 */
class TextExtension extends \Twig_Extension {
    /**
     * @return array
     */
    public function getFilters() {
        return [
            new \Twig_SimpleFilter("cutText", [$this, "cutText"])
        ];
    }
    
    /**
     * 
     * @param string $text
     * @return string
     */
    public function cutText($text)
    {
        if (mb_strlen($text)>101)
        {
            return mb_substr($text,0,100)."...";
        } else
        {
            return $text;
        }
        
    }
}
