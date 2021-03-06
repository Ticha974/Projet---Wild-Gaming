<?php

namespace App\Model;

class NewsManager extends AbstractManager
{
    public const TABLE = 'news';

    // Fetch data from news table
    public function select(): array
    {
        $query = "SELECT * FROM " . self::TABLE .  " ORDER BY createdDate DESC";
        $statement = $this->pdo->query($query);
        $news = $statement->fetchAll();
        return $news;
    }

    /**
     * Get all row from database dans display a limited result.
     */
    public function selectLimited(): array
    {
        $query = 'SELECT * FROM news  ORDER BY createdDate DESC LIMIT 3 ';
        $statement = $this->pdo->query($query);
        $news = $statement->fetchAll();
        return $news;
    }


    //Insert new item into news table
    public function insert(array $news): int
    {
       /* if (empty($news['gameId'])) {
            $news['gameId'] = null;
        } else {
            $news['gameId'] = intval($news['gameId']);
        }*/
        $news['gameId'] = intval($news['gameId']);
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " 
        (title, detail, gameId, img_url_news) VALUES
         (:title, :detail, :gameId, :img_url_news)");
        $statement->bindValue('title', $news['title'], \PDO::PARAM_STR);
        //$statement->bindValue('category', $news['category'], \PDO::PARAM_STR);
        $statement->bindValue('detail', $news['detail'], \PDO::PARAM_STR);
        $statement->bindValue('gameId', $news['gameId'], \PDO::PARAM_INT);
        $statement->bindValue('img_url_news', $news['img_url_news'], \PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    //Update news in database
    public function update(array $news): bool
    {
        /*if (empty($news['gameId'])) {
            $news['gameId'] = 0;
        } else {
            $news['gameId'] = intval($news['gameId']);
        }*/
        $news['gameId'] = intval($news['gameId']);
        $statement = $this->pdo->prepare("UPDATE " . self::TABLE .
            " SET title = :title, detail = :detail, gameId = :gameId, img_url_news = :img_url_news 
            WHERE id=:id");
        $statement->bindValue('id', $news['id'], \PDO::PARAM_INT);
        $statement->bindValue('title', $news['title'], \PDO::PARAM_STR);
        //$statement->bindValue('category', $news['category'], \PDO::PARAM_STR);
        $statement->bindValue('detail', $news['detail'], \PDO::PARAM_STR);
        $statement->bindValue('gameId', $news['gameId']);
        $statement->bindValue('img_url_news', $news['img_url_news'], \PDO::PARAM_STR);

        return $statement->execute();
    }

    /**
     * Select news by gameId from news table
     */
    public function fetchNewsByGameId(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . self::TABLE . " WHERE gameId=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

    public function deleteNews(int $id): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . self::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();
    }
}
