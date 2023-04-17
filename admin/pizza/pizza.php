<?php
define('SITE_ROOT', __DIR__ . "/../../");

require_once(SITE_ROOT . "/db/dbhelper.php");

class Pizza
{
    private $PizzaID;
    private $PizzaName;
    private $PizzaDescription;
    private $PizzaPrice;
    private $PizzaImage;
    private $PizzaSize;
    private $errors;

    // Constructor
    public function __construct($data = [])
    {
        if ($data) {
            $this->PizzaID = isset($data['PizzaID']) ? $data['PizzaID'] : null;
            $this->PizzaName = $data['PizzaName'];
            $this->PizzaDescription = $data['PizzaDescription'];
            $this->PizzaPrice = isset($data['PizzaPrice']) ? $data['PizzaPrice'] : null;
            $this->PizzaSize = isset($data['PizzaSize']) ? $data['PizzaSize'] : null;
            $this->PizzaImage = isset($data['PizzaImage']) ? $data['PizzaImage'] : null;
        }
    }

    // Getters
    public function getPizzaID()
    {
        return $this->PizzaID;
    }

    public function getPizzaName()
    {
        return $this->PizzaName;
    }

    public function getPizzaDescription()
    {
        return $this->PizzaDescription;
    }

    public function getPizzaPrice()
    {
        return $this->PizzaPrice;
    }

    public function getPizzaSize()
    {
        return $this->PizzaSize;
    }

    public function getPizzaImage()
    {
        return $this->PizzaImage;
    }

    // Setters
    public function setPizzaName($PizzaName)
    {
        $this->PizzaName = $PizzaName;
    }

    public function setPizzaDescription($PizzaDescription)
    {
        $this->PizzaDescription = $PizzaDescription;
    }

    public function setPizzaPrice($PizzaPrice)
    {
        $this->PizzaPrice = $PizzaPrice;
    }

    public function setPizzaSize($PizzaSize)
    {
        $this->PizzaSize = $PizzaSize;
    }

    public function setPizzaImage($PizzaImage)
    {
        $this->PizzaImage = $PizzaImage;
    }

    public function setErrors($error)
    {
        $this->errors = [$error];
    }

    // Validation
    public function getErrors($isUpdate)
    {
        $errors = [];


        if (empty($this->PizzaName)) {
            $errors[] = "Pizza name is required.";
        }

        if (empty($this->PizzaDescription)) {
            $errors[] = "Pizza description is required.";
        }
        if (!$isUpdate) {

            if (empty($this->PizzaPrice)) {
                $errors[] = "Pizza price is required.";
            }

            if (!filter_var($this->PizzaPrice, FILTER_VALIDATE_FLOAT)) {
                $errors[] = "Pizza price is invalid.";
            }

            if (empty($this->PizzaSize)) {
                $errors[] = "Pizza size is required.";
            }

            if (!in_array($this->PizzaSize, ['Small', 'Medium', 'Large'])) {
                $errors[] = "Invalid pizza size.";
            }
        }
        if (!empty($this->PizzaImage) && is_array($this->PizzaImage) && $this->PizzaImage['error'] != UPLOAD_ERR_OK) {
            $errors[] = "Error uploading image. Please try again.";
        }

        return $errors;
    }



    // Insert
    public function insert()
    {
        // Code to insert data into database

        if (!empty($this->PizzaImage)) {

            $target_dir = "images/";
            $target_file = $target_dir . basename($this->PizzaImage["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($this->PizzaImage["tmp_name"]);
            if ($check === false) {
                return "File is not an image.";
            }

            // Check file size
            if ($this->PizzaImage["size"] > 500000) {
                return "Sorry, your file is too large.";
            }

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }

            // Upload file
            if (move_uploaded_file($this->PizzaImage["tmp_name"], $target_file)) {
                // Code to insert pizza data with image file name in database
                $query = "INSERT INTO pizzas (Name, Description, PizzaImage) 
            VALUES (:PizzaName, :PizzaDescription, :PizzaImage)";
                $params = array(
                    ":PizzaName" => $this->PizzaName,
                    ":PizzaDescription" => $this->PizzaDescription,
                    ":PizzaImage" => basename($this->PizzaImage["name"])
                );
                // Execute query with $params
            } else {
                return "Sorry, there was an error uploading your file.";
            }
        } else {
            // Code to insert pizza data without image file name in database
            $query = "INSERT INTO pizzas (Name, Description) 
        VALUES (:PizzaName, :PizzaDescription, :PizzaSize)";
            $params = array(
                ":PizzaName" => $this->PizzaName,
                ":PizzaDescription" => $this->PizzaDescription,
            );
            // Execute query with $params
        }
        $pdo = DBHelper::getConnection();
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $PizzaId = $pdo->lastInsertId();

        // now insert prices
        $stmt = $pdo->prepare("insert into prices (Price,size,PizzaID)
        values (:PizzaPrice ,:PizzaSize,:PizzaID)");
        $stmt->execute([
            "PizzaPrice" => $this->PizzaPrice,
            "PizzaSize" => $this->PizzaSize,
            "PizzaID" => $PizzaId
        ]);
    }


    // Update
    public function update()
    {
        // Code to update data in database

        if (!empty($this->PizzaImage)) {
            $target_dir = "images/";
            $target_file = $target_dir . basename($this->PizzaImage["name"]);
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

            // Check if image file is a actual image or fake image
            $check = getimagesize($this->PizzaImage["tmp_name"]);
            if ($check === false) {
                return "File is not an image.";
            }

            // Check file size
            if ($this->PizzaImage["size"] > 500000) {
                return "Sorry, your file is too large.";
            }

            // Allow certain file formats
            if (
                $imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif"
            ) {
                return "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            }

            // Upload file
            if (move_uploaded_file($this->PizzaImage["tmp_name"], $target_file)) {
                // Code to update pizza data with image file name in database
                $query = "UPDATE pizzas SET Name = :PizzaName, Description = :PizzaDescription, 
           PizzaImage = :PizzaImage WHERE PizzaID = :PizzaID";
                $params = array(
                    ":PizzaName" => $this->PizzaName,
                    ":PizzaDescription" => $this->PizzaDescription,
                    ":PizzaImage" => basename($this->PizzaImage["name"]),
                    ":PizzaID" => $this->PizzaID
                );
                // Execute query with $params
            } else {
                return "Sorry, there was an error uploading your file.";
            }
        } else {
            // Code to update pizza data without changing image file name in database
            $query = "UPDATE pizzas SET Name = :PizzaName, Description = :PizzaDescription WHERE PizzaID = :PizzaID";
            $params = array(
                ":PizzaName" => $this->PizzaName,
                ":PizzaDescription" => $this->PizzaDescription,
                ":PizzaID" => $this->PizzaID
            );

        }
        $pdo = DBHelper::getConnection();
        $stmt = $pdo->prepare($query);
        $stmt->execute($params);
        $PizzaId = $pdo->lastInsertId();

    }

    public function delete()
    {
        // Code to delete data from database

        // Delete image file
        $target_dir = "images/pizzas/";
        $target_file = $target_dir . $this->PizzaImage;
        if (file_exists($target_file)) {
            unlink($target_file);
        }
    }

    function findAll()
    {
        $pdo = DBHelper::getConnection();
        $stmt = $pdo->prepare("SELECT p.PizzaID as PizzaID, p.Name as PizzaName, p.Description as PizzaDescription,
                p.PizzaImage as PizzaImage 
                FROM pizza_store.pizzas as p");
        $stmt->execute();
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pizzas = array();
        foreach ($rows as $row) {
            $pizza = new Pizza([]);
            $pizza->PizzaID = $row["PizzaID"];
            $pizza->PizzaName = $row["PizzaName"];
            $pizza->PizzaDescription = $row["PizzaDescription"];
            $pizza->PizzaImage = $row["PizzaImage"];
            $pizzas[] = $pizza;
        }

        return $pizzas;
    }

    function findOne($PizzaID)
    {
        $pdo = DBHelper::getConnection();
        $stmt = $pdo->prepare("SELECT p.PizzaID as PizzaID, p.Name as PizzaName, p.Description as PizzaDescription,
                p.PizzaImage as PizzaImage
                FROM pizza_store.pizzas as p WHERE PizzaID=:PizzaID");
        $stmt->execute([
            ":PizzaID" => $PizzaID,
        ]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $pizza = new Pizza([]);
        $pizza->PizzaID = $row["PizzaID"];
        $pizza->PizzaName = $row["PizzaName"];
        $pizza->PizzaDescription = $row["PizzaDescription"];
        $pizza->PizzaImage = $row["PizzaImage"];

        return $pizza;
    }

}