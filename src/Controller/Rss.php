<?php

namespace App\Controller;

use App\Model\NewsManager;

class Rss extends AbstractController
{
    public function rss(): string
    {
        $newsManager = new NewsManager();
        $news = $newsManager->select();
        $address = $_SERVER['HTTP_HOST'];
        header('Content-Type: application/rss+xml; charset=UTF-8');
        return $this->twig->render('Rss/rss.xml.twig', [
            'news' => $news,
            'address' => $address]);
    }
}
