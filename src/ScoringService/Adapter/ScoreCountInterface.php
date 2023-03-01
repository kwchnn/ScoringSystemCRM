<?php


namespace App\ScoringService\Adapter;


interface ScoreCountInterface
{
    public function getScore(string $email): void;
}