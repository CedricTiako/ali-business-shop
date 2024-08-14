<?php

class ConnectMySQLDB {
    private $pdo;

    public function __construct($host, $dbname, $username, $password) {
        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password, [
                PDO::ATTR_PERSISTENT => true,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            ]);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            // Log error instead of die
            error_log("Connection error: " . $e->getMessage());
            throw new Exception("Database connection error" .$e->getMessage());
        }
    }

	public function logErrorRequest($method, $endpoint, $data) {
    $logData = date('Y-m-d H:i:s') . " - $method $endpoint: " . json_encode($data) . "\n";
    file_put_contents($method.'.txt', $logData, FILE_APPEND);
    }
    public function create($table, $data) {
		$this->logErrorRequest('create',$table, $data);
        try {
            $keys = implode(',', array_keys($data));
            $values = ':' . implode(',:', array_keys($data));
            $sql = "INSERT IGNORE INTO $table ($keys) VALUES ($values)";
            
            $stmt = $this->pdo->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error
            error_log("Insert error: " . $e->getMessage());
            return false;
        }
    } 
    
    public function read($table, $conditions = [], $orderBy = '') {
        try {
            $sql = "SELECT * FROM $table";
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $whereClauses = [];
                foreach ($conditions as $field => $value) {
                    if (is_array($value)) {
                        $operator = $value[0];
                        $whereClauses[] = "$field $operator :$field";
                    } else {
                        $whereClauses[] = "$field = :$field";
                    }
                }
                $sql .= implode(' AND ', $whereClauses);
            }
            if (!empty($orderBy)) {
                $sql .= " ORDER BY $orderBy";
            }
            
            $stmt = $this->pdo->prepare($sql);
            foreach ($conditions as $field => $value) {
                if (is_array($value)) {
                    $stmt->bindValue(":$field", $value[1]);
                } else {
                    $stmt->bindValue(":$field", $value);
                }
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error
            error_log("Read error: " . $e->getMessage());
            return [];
        }
    }

    public function update($table, $data, $conditions) {
        $this->logErrorRequest('update',$table, array("data"=> $data,"condition"=>$conditions));
        try {
            $setClauses = [];
            foreach ($data as $field => $value) {
                $setClauses[] = "$field = :$field";
            }
            $sql = "UPDATE $table SET " . implode(', ', $setClauses);
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $whereClauses = [];
                foreach ($conditions as $field => $value) {
                    if (is_array($value)) {
                        $operator = $value[0];
                        $whereClauses[] = "$field $operator :where_$field";
                    } else {
                        $whereClauses[] = "$field = :where_$field";
                    }
                }
                $sql .= implode(' AND ', $whereClauses);
            }
            
            $stmt = $this->pdo->prepare($sql);
            foreach ($data as $field => $value) {
                $stmt->bindValue(":$field", $value);
            }
            foreach ($conditions as $field => $value) {
                if (is_array($value)) {
                    $stmt->bindValue(":where_$field", $value[1]);
                } else {
                    $stmt->bindValue(":where_$field", $value);
                }
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error
            error_log("Update error: " . $e->getMessage());
            return false;
        }
    }

    public function delete($table, $conditions) {
        try {
            $sql = "DELETE FROM $table WHERE ";
            $whereClauses = [];
            foreach ($conditions as $field => $value) {
                $whereClauses[] = "$field = :$field";
            }
            $sql .= implode(' AND ', $whereClauses);
            
            $stmt = $this->pdo->prepare($sql);
            foreach ($conditions as $field => $value) {
                $stmt->bindValue(":$field", $value);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            // Log error
            error_log("Delete error: " . $e->getMessage());
            return false;
        }
    }

    public function executeCustomQuery($query, $params = []) {
        try {
            $stmt = $this->pdo->prepare($query);
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
            $stmt->execute();

            if (strpos(strtoupper($query), 'SELECT') === 0) {
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            return $stmt->rowCount();
        } catch (PDOException $e) {
            // Log error
            error_log("Custom query error: " . $e->getMessage());
            return false;
        }
    }

    public function customSelect($tables, $conditions = [], $joins = [], $orderBy = '') {
        try {
            $tableList = implode(', ', $tables);
            $sql = "SELECT * FROM $tableList";
            foreach ($joins as $join) {
                $sql .= " $join";
            }
            if (!empty($conditions)) {
                $sql .= " WHERE ";
                $whereClauses = [];
                foreach ($conditions as $field => $value) {
                    $whereClauses[] = "$field = :$field";
                }
                $sql .= implode(' AND ', $whereClauses);
            }
            if (!empty($orderBy)) {
                $sql .= " ORDER BY $orderBy";
            }
            
            $stmt = $this->pdo->prepare($sql);
            foreach ($conditions as $field => $value) {
                $stmt->bindValue(":$field", $value);
            }
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error
            error_log("Custom select error: " . $e->getMessage());
            return [];
        }
    }

    public function executeStoredProcedure($procedureName, $params = []) {
        try {
            $placeholders = implode(', ', array_fill(0, count($params), '?'));
            $stmt = $this->pdo->prepare("CALL $procedureName($placeholders)");
            $stmt->execute(array_values($params));
        } catch (PDOException $e) {
            // Log error
            error_log("Stored procedure execution error: " . $e->getMessage());
            throw new Exception("Stored procedure execution error");
        }
    }

    public function executeStoredProcedureWithResults($procedureName, $params = []) {
        try {
            $placeholders = implode(', ', array_fill(0, count($params), '?'));
            $stmt = $this->pdo->prepare("CALL $procedureName($placeholders)");
            $stmt->execute(array_values($params));
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Log error
            error_log("Stored procedure execution error: " . $e->getMessage());
            throw new Exception("Stored procedure execution error");
        }
    }

    public function lastInsertID() {
        try {
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            // Log error
            error_log("Last insert ID retrieval error: " . $e->getMessage());
            return false;
        }
    }
}