<?php

namespace Libs\Database;

use PDOException;


class UsersTable
{
    private $db = null;

    public function __construct(MySQL $db)
    {
        $this->db = $db->connect();
    }

    public function insert($data)
    {
        try {
            $query = "
                INSERT INTO users (
                    name, email, phone, address,
                    password, role_id, created_at
                ) VALUES (
                    :name, :email, :phone, :address,
                    :password, :role_id, NOW()
                )
                ";
            $statement = $this->db->prepare($query);
            $statement->execute($data);
            if ($data) {
                return $this->db->lastInsertId();
            } else {
                echo "Record does not exist!";
            }   
     
        
              
        } catch (PDOException $e) {
            return $e->getMessage()();
        }
    }
    public function update($data) {
    
        try {
        
    
            $query = "
                UPDATE users SET name = :name, email = :email, phone = :phone
                WHERE id = :id
            ";
            $statement = $this->db->prepare($query);
    
            $statement->bindParam(':name', $data['name']);
            $statement->bindParam(':email', $data['email']);
            $statement->bindParam(':phone', $data['phone']);
            $statement->bindParam(':id', $data['id']);
    
            $success = $statement->execute();
    
            if ($success) {
                return true;
            } else {
              
                error_log("No rows affected or update failed", 3, '/path/to/error.log');
                return false;
            }
        } catch (Exception $e) {
            error_log($e->getMessage(), 3, '/path/to/error.log');
            return false;
        }
    }
        


    public function getAll()
    {
        try {
            $statement = $this->db->query("
            SELECT users.*, roles.name AS role, roles.value
            FROM users LEFT JOIN roles
            ON users.role_id = roles.id
        ");
        
        return $statement->fetchAll();
    
        } catch (PDOException $e) {
            return $e->getMessage()();
        }
       

    }

    public function findByEmailAndPasword($email, $password)
    {
        $statement = $this->db->prepare("
            SELECT users.*, roles.name AS role, roles.value
            FROM users LEFT JOIN roles
            ON users.role_id = roles.id
            WHERE users.email = :email  
            AND users.password = :password
        ");
        
        $statement->execute([
            ':email' => $email,
            ':password' => $password
        ]);
        $row = $statement->fetch();
    
        return $row ?? false;       
    }

   
    public function updatePhoto($id, $name)
    {
    $statement = $this->db->prepare("
        UPDATE users SET photo=:name WHERE id = :id"
    );
    $statement->execute([ ':name' => $name, ':id' => $id ]);

    return $statement->rowCount();
    }

    public function suspend($id)
    {
        $statement = $this->db->prepare("
            UPDATE users SET suspended=1 WHERE id = :id
        ");
        $statement->execute([ ':id' => $id ]);
        return $statement->rowCount();
    }

    public function unsuspend($id)
    {
        $statement = $this->db->prepare("
            UPDATE users SET suspended=0 WHERE id = :id
        ");
        $statement->execute([ ':id' => $id ]);
        return $statement->rowCount();
    }

    public function changeRole($id, $role)
    {
        $statement = $this->db->prepare("
            UPDATE users SET role_id = :role WHERE id = :id
");
        $statement->execute([ ':id' => $id, ':role' => $role ]);
        return $statement->rowCount();
    }
        
    public function delete($id)
    {
    $statement = $this->db->prepare("
            DELETE FROM users WHERE id = :id
        ");
        $statement->execute([ ':id' => $id ]);
        return $statement->rowCount();
    }

    
}


