<?php


function dd($data, $exit = 1)
{
    \yii\helpers\VarDumper::dump($data, 10, true);
    if ($exit) {
        exit;
    }
}