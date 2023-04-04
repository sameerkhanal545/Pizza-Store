<?php
    require_once("../../db/dbhelper.php");
    
    class Topping
    {
        protected $ToppingID;
        protected $ToppingName;
        protected $ToppingDescription;

        
        protected $errors=[];
        
        function getErrors(){ return $this->errors; }
        function clearErrors(){ $this->errors=[]; }
        
        function getToppingID(){ return $this->ToppingID; }
        function setToppingID($ToppingID)
        { 
            $this->ToppingID=trim(htmlspecialchars($ToppingID)); 
            if(empty($this->ToppingID))
                $this->errors[]="<p>Topping Id is required.</p>";
            else if(!filter_var($this->ToppingID,FILTER_VALIDATE_INT))
                $this->errors[]="<p>Topping Id is invalid.</p>";
            $this->ToppingID=(int)$this->ToppingID;
        }
        
        function getToppingName(){ return $this->ToppingName; }
        
        function setToppingName($ToppingName)
        { 
            $this->ToppingName=trim(htmlspecialchars($ToppingName)); 
            if(empty($this->ToppingName))
                $this->errors[]="<p>Topping name is required.</p>";
            
        }
        
        function getToppingDescription(){ return $this->ToppingDescription; }
        
        function setToppingDescription($ToppingDescription)
        { 
            $this->ToppingDescription=trim(htmlspecialchars($ToppingDescription)); 
            if(empty($this->ToppingDescription))
                $this->errors[]="<p>Topping description is required.</p>";
        }
        
        
        function __construct($properties=[])
        {
            if(isset($properties["ToppingID"])) $this->setToppingID($properties["ToppingID"]);
            if(isset($properties["ToppingName"])) $this->setToppingName($properties["ToppingName"]);
            if(isset($properties["ToppingDescription"])) $this->setToppingDescription($properties["ToppingDescription"]);

        }
        
        
        function insert()
        {
            $pdo=DBHelper::getConnection();
            $stmt=$pdo->prepare("insert into topping (ToppingName,ToppingDescription)
                           values (:ToppingName ,:ToppingDescription)");
            $stmt->execute([
                "ToppingName" => $this->ToppingName,
                "ToppingDescription" => $this->ToppingDescription
            ]);
            
        }
        
         function update()
        {
            $pdo=DBHelper::getConnection();
            $stmt=$pdo->prepare("update topping set ToppingName = :ToppingName ,ToppingDescription 
            = :ToppingDescription where ToppingID = :ToppingID");
            $stmt->execute([
                "ToppingID" => $this->ToppingID,
                "ToppingName" => $this->ToppingName,
                "ToppingDescription" => $this->ToppingDescription
            ]);
            
        }
        
           function find($topping_id)
        {
            if(filter_var($topping_id,FILTER_VALIDATE_INT))
            {
                $pdo=DBHelper::getConnection();
                $stmt = $pdo->prepare("select * from topping where 
                              ToppingID=:ToppingID  
                ");
                $stmt->execute(["ToppingID"=>(int)$topping_id]);
                if($row=$stmt->fetch())
                {
                    $this->ToppingID = $row["ToppingID"];
                    $this->ToppingName = $row["ToppingName"];
                    $this->ToppingDescription = $row["ToppingDescription"];
                }    
            }
        }
        
        function findAll()
        {
                $pdo=DBHelper::getConnection();
                $stmt = $pdo->prepare("select * from topping");
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }




































