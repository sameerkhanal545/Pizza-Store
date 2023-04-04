<?php
    require_once("../db/dbhelper.php");
    
    class Account
    {
        protected $Email;
        
        protected $Password;
        
        protected $errors = [];
        
        function getErrors(){ return $this->errors; }
        function clearErrors(){ $this->errors=[]; }
        

        function getEmail(){ return $this->Email; }
        function setEmail($Email)
        { 
            $this->Email=trim(htmlspecialchars($Email)); 
            if(empty($this->Email))
                $this->errors["EmailError"]="<p>Email is required.</p>";
            else if(!filter_var($this->Email,FILTER_VALIDATE_EMAIL))
                $this->errors["EmailError"]="<p>Email is invalid.</p>";
        }
        
        function getPassword(){ return $this->Password; }
        function setPassword($Password)
        { 
            $this->Password=trim(htmlspecialchars($Password)); 
            if(empty($this->Password))
                $this->errors["PasswordError"]="<p>Password is required.</p>";
        }
        
        
          function __construct($properties=[])
        {
            if(isset($properties["Email"])) $this->setEmail($properties["Email"]);
            if(isset($properties["Password"])) $this->setPassword($properties["Password"]);

        }
        
        function login()
        {
            $pdo=DBHelper::getConnection();
            $stmt=$pdo->prepare(
                "select CustomerID, PasswordHash from customers
                where CustomerEmail=:CustomerEmail");
            $stmt->execute([
                "CustomerEmail" => $this->Email
            ]);
            
           if($stmt->rowCount()==1)
            {
                $row=$stmt->fetch(PDO::FETCH_ASSOC);
                if(password_verify($this->Password,$row["PasswordHash"]))
                {
                    session_regenerate_id();
                    $_SESSION["CustomerID"]=$row["CustomerID"];
                    return true;
                }
            }
            return false;
        }
        
        function logout()
            {
                $_SESSION = [];
                session_destroy();
                setCookie("PHPSESSID",'',time()-3600,'/',0,0);
            }

    }
    
    
    ?>













