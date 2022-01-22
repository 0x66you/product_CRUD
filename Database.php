<?php
namespace app;

use PDO;
use PDOException;
use app\models\Product;
class Database
{
    public \PDO $connection;
    public static ?Database $db = null;
    public function __construct()
    {
        $dbms = 'mysql';
        $host = '127.0.0.1';
        $dbName = 'product_crud';
        $user = 'root';
        $pass = '';
        $dsn = "$dbms:host=$host;dbname=$dbName";
        try{
            $this->connection = new PDO($dsn,$user,$pass);
            self::$db = $this;
        }catch(PDOException $e){
            die("ERROR!: ".$e->getMessage().'<br/>');
        }
    }
    public function getProducts($search = '')
    {
        if($search){
            $statement = $this->connection->prepare('
                SELECT * FROM products WHERE title LIKE :title ORDER BY create_date DESC
            ');
            $statement->bindValue(':title',"%$search%");    
        }else{
            $statement = $this->connection->prepare('Select * FROM products ORDER BY create_date DESC');
        }
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
        
    }
    public function getProductById($id)
    {
        $statement = $this->connection->prepare('SELECT * FROM products WHERE id = :id');
        $statement->bindValue(':id', $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function deleteProduct($id)
    {
        $statement = $this->connection->prepare('DELETE FROM products WHERE id = :id');
        $statement->bindValue(':id', $id);

        return $statement->execute();
    }

    public function updateProduct(Product $product)
    {
        $statement = $this->connection->prepare("UPDATE products SET title = :title, 
                                        image = :image, 
                                        description = :description, 
                                        price = :price WHERE id = :id");
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':id', $product->id);

        $statement->execute();
    }

    public function createProduct(Product $product)
    {
        $statement = $this->connection->prepare("INSERT INTO products (title, image, description, price, create_date)
                VALUES (:title, :image, :description, :price, :date)");
        $statement->bindValue(':title', $product->title);
        $statement->bindValue(':image', $product->imagePath);
        $statement->bindValue(':description', $product->description);
        $statement->bindValue(':price', $product->price);
        $statement->bindValue(':date', date('Y-m-d H:i:s'));

        $statement->execute();
    }
}

?>