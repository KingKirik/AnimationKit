<?php
use std, gui, framework, app;

class AnimationKit 
{
    function displaceX($node, $b, $c, $d, $type = false, callable $callback = null){
        if ($type == true) $c = $c - $node->x;
        $d = $d/UXAnimationTimer::FRAME_INTERVAL_MS;
        $timer = new UXAnimationTimer(function () use (&$timer, $node, $b, $c, $d, $callback){
            static $currentTime;
            if ($currentTime >= $d){ $timer->stop(); if ($callback) { $callback(); } }
            $ease = $this->Ease($currentTime, $b, $c, $d);
            $node->x = round($ease, 1);
            //var_dump($currentTime." -x- ".$node->x);   
            $currentTime++; 
        });
        $timer->start();
    }
    function displaceY($node, $b, $c, $d, $type = false, callable $callback = null){
        if ($type == true) $c = $c - $node->y;
        $d = $d/UXAnimationTimer::FRAME_INTERVAL_MS;
        $timer = new UXAnimationTimer(function () use (&$timer, $node, $b, $c, $d, $callback){
            static $currentTime;
            if ($currentTime >= $d){ $timer->stop(); if ($callback) { $callback(); } }
            $ease = $this->Ease($currentTime, $b, $c, $d);
            $node->y = round($ease, 1);
            //var_dump($currentTime." -y- ".$node->y); 
            $currentTime++;  
        });
        $timer->start();
    }    
    function changeBorderRadius($node, $b, $c, $d, callable $callback = null){
        $c = $c - $node->borderRadius;
        $d = $d/UXAnimationTimer::FRAME_INTERVAL_MS;
        $timer = new UXAnimationTimer(function () use (&$timer, $node, $b, $c, $d, $callback){
            static $currentTime;
            if ($currentTime >= $d){ $timer->stop(); if ($callback) { $callback(); } }
            $ease = $this->Ease($currentTime, $b, $c, $d);
            $node->borderRadius = round($ease, 1);
            //var_dump($currentTime." -radius- ".$node->borderRadius); 
            $currentTime++; 
        });
        $timer->start();
    }
    function changeOpacity($node, $b, $c, $d, callable $callback = null){
        $c = $c - $node->opacity;
        $d = $d/UXAnimationTimer::FRAME_INTERVAL_MS;
        $timer = new UXAnimationTimer(function () use (&$timer, $node, $b, $c, $d, $callback){
            static $currentTime;
            if ($currentTime >= $d){ $timer->stop(); if ($callback) { $callback(); } }
            $ease = $this->Ease($currentTime, $b, $c, $d);
            $node->opacity = round($ease, 2);
            //var_dump($currentTime." -opacity- ".$node->opacity); 
            $currentTime++; 
        });
        $timer->start();
    }
    function changeScale($node, $b, $n, $e,  $c, $d, callable $callback = null){
        $e = $e - $node->scaleX;
        $c = $c - $node->scaleY;
        $d = $d/UXAnimationTimer::FRAME_INTERVAL_MS;
        $timer = new UXAnimationTimer(function () use (&$timer, $node, $b, $n, $e, $c, $d, $callback){
            static $currentTime;
            if ($currentTime >= $d){ $timer->stop(); if ($callback) { $callback(); } }
            $easeX = $this->Ease($currentTime, $b, $e, $d);
            $easeY = $this->Ease($currentTime, $n, $c, $d);
            $node->scale = [round($easeX, 2), round($easeY, 2)];
            $currentTime++;  
            //var_dump($currentTime." -x- -y- ".$node->scale[0].' --- '.$node->scale[1]); 
        });
        $timer->start();
    }
    function changeRGB($node, $property, $r, $g, $b, $o, $r1, $g1, $b1, $o1, $d, callable $callback = null){
        $r1 = $r1 - ($node->$property->red * 255);
        $g1 = $g1 - ($node->$property->green * 255);
        $b1 = $b1 - ($node->$property->blue * 255);
        $o1 = $o1 - $node->$property->opacity;
        $d = $d/UXAnimationTimer::FRAME_INTERVAL_MS;
        $timer = new UXAnimationTimer(function () use (&$timer, $node, $property, $r, $g, $b, $o, $r1, $g1, $b1, $o1, $d, $callback){
            static $currentTime;
            if ($currentTime >= $d){ $timer->stop(); if ($callback) { $callback(); } }
            $rEase = $this->Ease($currentTime, $r, $r1, $d);
            $gEase = $this->Ease($currentTime, $g, $g1, $d);
            $bEase = $this->Ease($currentTime, $b, $b1, $d);
            $oEase = $this->Ease($currentTime, $o, $o1, $d);
            $node->$property = UXColor::rgb(round($rEase), round($gEase), round($bEase), round($oEase, 2));
            //var_dump($currentTime." -rgb- ".round($rEase).' '.round($gEase).' '.round($bEase).' '.round($oEase, 2)); 
            $currentTime++; 
        });
        $timer->start();
    }          
    function resize($node, $b, $n, $e,  $c, $d, callable $callback = null){
        $e = $e - $node->width;
        $c = $c - $node->height;
        $d = $d/UXAnimationTimer::FRAME_INTERVAL_MS;
        $timer = new UXAnimationTimer(function () use (&$timer, $node, $b, $n, $e, $c, $d, $callback){
            static $currentTime;
            if ($currentTime >= $d){ $timer->stop(); if ($callback) { $callback(); } }
            $easeW = $this->Ease($currentTime, $b, $e, $d);
            $easeH = $this->Ease($currentTime, $n, $c, $d);
            $node->size = [round($easeW, 1), round($easeH, 1)];
            $currentTime++;  
            //var_dump($currentTime." -w---h- ".$node->size[0].' --- '.$node->size[1]); 
        });
        $timer->start();
    }
    function Ease($t, $b, $c, $d){
        $t /= $d/2;
        if ($t < 1) return $c/2*$t*$t + $b;
        $t--;
        return -$c/2 * ($t*($t-2) - 1) + $b;
    }    
}