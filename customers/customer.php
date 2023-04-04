<?php
    require_once("../db/dbhelper.php");
    
    class Customer
    {
        protected $CustomerID;
        protected $ProvinceID;
        protected $CustomerName;
        protected $CustomerEmail;
        protected $CustomerPhone;
        protected $CustomerAddress;
        protected $CustomerCity;
        protected $PasswordHash;
        
        protected $errors=[];
        
        function getErrors(){ return $this->errors; }
        function clearErrors(){ $this->errors=[]; }
        
        function getCustomerID(){ return $this->CustomerID; }
        function setCustomerID($CustomerID)
        { 
            $this->CustomerID=trim(htmlspecialchars($CustomerID)); 
            if(empty($this->CustomerID))
                $this->errors["CustomerIDError"]="<p>Customer Id is required.</p>";
            else if(!filter_var($this->CustomerID,FILTER_VALIDATE_INT))
                $this->errors["CustomerIDError"]="<p>Customer Id is invalid.</p>";
            $this->CustomerID=(int)$this->CustomerID;
        }
        
         function getProvinceID(){ return $this->ProvinceID; }
        function setProvinceID($ProvinceID)
        { 
            $this->ProvinceID=trim(htmlspecialchars($ProvinceID)); 
            if(empty($this->ProvinceID))
                $this->errors["ProvinceID"]="<p>Province is required.</p>";
            else if(!filter_var($this->ProvinceID,FILTER_VALIDATE_INT))
                $this->errors["ProvinceIDError"]="<p>User Id is invalid.</p>";
            $this->ProvinceID=(int)$this->ProvinceID;
        }
        
        function getCustomerName(){ return $this->CustomerName; }
        function setCustomerName($CustomerName)
        { 
            $this->CustomerName=trim(htmlspecialchars($CustomerName)); 
            if(empty($this->CustomerName))
                $this->errors["CustomerNameError"]="<p>Customer Name is required.</p>";
            
        }
        
        function getPasswordHash(){ return $this->PasswordHash; }
        function setPasswordHash($PasswordHash)
        { 
            $passValue =trim(htmlspecialchars($PasswordHash)); 
            if(empty($passValue))
                $this->errors["PasswordError"]="<p>Password is required.</p>";
            else
            {
                $hash=password_hash($passValue,PASSWORD_DEFAULT);
                $this->PasswordHash = $hash; 

            }
            
        }
        
        function getCustomerEmail(){ return $this->CustomerEmail; }
        function setCustomerEmail($CustomerEmail)
        { 
            $this->CustomerEmail=trim(htmlspecialchars($CustomerEmail)); 
            if(empty($this->CustomerEmail))
                $this->errors["CustomerEmailError"]="<p>Email is required.</p>";
            else if(!filter_var($this->CustomerEmail,FILTER_VALIDATE_EMAIL))
                $this->errors["CustomerEmailError"]="<p>Email is invalid.</p>";
        }
        
        function getCustomerPhone(){ return $this->CustomerPhone; }
        function setCustomerPhone($CustomerPhone)
        { 
            $this->CustomerPhone=trim(htmlspecialchars($CustomerPhone)); 
            if(empty($this->CustomerPhone))
                $this->errors["CustomerPhoneError"]="<p>Phone is required.</p>";
        }
        
        function getCustomerAddress(){ return $this->CustomerAddress; }
        function setCustomerAddress($CustomerAddress)
        { 
            $this->CustomerAddress=trim(htmlspecialchars($CustomerAddress)); 
            if(empty($this->CustomerAddress))
                $this->errors["CustomerAddressError"]="<p>Address is required.</p>";
        
        }
        
        function getCustomerCity(){ return $this->CustomerCity; }
        function setCustomerCity($CustomerCity)
        { 
            $this->CustomerCity=trim(htmlspecialchars($CustomerCity)); 
            if(empty($this->CustomerCity))
                $this->errors["CustomerCityError"]="<p>City is required.</p>";
    
        }
        
        function __construct($properties=[])
        {
            if(isset($properties["CustomerID"])) $this->setUserId($properties["CustomerID"]);
            if(isset($properties["ProvinceID"])) $this->setProvinceID($properties["ProvinceID"]);
            if(isset($properties["CustomerName"])) $this->setCustomerName($properties["CustomerName"]);
            if(isset($properties["CustomerEmail"])) $this->setCustomerEmail($properties["CustomerEmail"]);
            if(isset($properties["CustomerPhone"])) $this->setCustomerPhone($properties["CustomerPhone"]);
            if(isset($properties["CustomerAddress"])) $this->setCustomerAddress($properties["CustomerAddress"]);
            if(isset($properties["CustomerCity"])) $this->setCustomerCity($properties["CustomerCity"]);
            if(isset($properties["PasswordHash"])) $this->setPasswordHash($properties["PasswordHash"]);

        }
        
        function insert()
        {
            $pdo=DBHelper::getConnection();
            $stmt=$pdo->prepare("insert into customers (CustomerName,CustomerEmail,CustomerPhone,CustomerAddress,CustomerCity,PasswordHash,ProvinceID)
                           values (:CustomerName,:CustomerEmail,:CustomerPhone,:CustomerAddress,:CustomerCity,:PasswordHash,:ProvinceID)");
            $stmt->execute([
                "CustomerName" => $this->CustomerName,
                "CustomerEmail" => $this->CustomerEmail,
                "CustomerPhone" => $this->CustomerPhone,
                "CustomerAddress" => $this->CustomerAddress,
                "CustomerCity" => $this->CustomerCity,
                "ProvinceID" => $this->ProvinceID,
                "PasswordHash" => $this->PasswordHash

            ]);
            
            $this->CustomerID=$pdo->lastInsertId();
        }
        
        function find($CustomerID)
        {
            if(filter_var($CustomerID,FILTER_VALIDATE_INT))
            {
                $pdo=DBHelper::getConnection();
                $stmt = $pdo->prepare("select * from customers where 
                              CustomerID=:CustomerID  
                ");
                $stmt->execute(["CustomerID"=>(int)$CustomerID]);
                if($row=$stmt->fetch())
                {
                    $this->CustomerID = $row["CustomerID"];
                    $this->CustomerName = $row["CustomerName"];
                    $this->CustomerPhone = $row["CustomerPhone"];
                    $this->CustomerEmail = $row["CustomerEmail"];                    
                    $this->CustomerAddress = $row["CustomerAddress"];
                    $this->ProvinceID = $row["ProvinceID"];                    
                    $this->CustomerCity = $row["CustomerCity"];
                    $this->PasswordHash = $row["PasswordHash"];

                }    
            }
        }
        
    }

    // $user=new User([
    //     //"user_id" => "",
    //     "name" => "Sameer",
    //     "email" => "sam@mail.com",
    //     "phone" => "1231231234",
    //     "province" => "ON"
    // ]);
    
    // foreach($user->getErrors() as $error)
    //     echo $error;
        
    // //$user->insert();
    // $user->find(84);
    // var_dump($user);

?>







































