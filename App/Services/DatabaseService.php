<?php

namespace App\Services;


class DatabaseService extends Service
{
    private \PDO $pdo;
    private $query;
    protected $table;
    protected $fields = [];
    protected $relationships = [];

    public function __construct()
    {
        $this->newPDO();
    }

    private function newPDO()
    {
        $config = include ROOT . '/config.php';
        $dsn = "mysql:dbname={$config['DB_DATABASE']};host={$config['DB_HOST']}";
        $user = $config['DB_USER'];
        $password = $config['DB_PASSWORD'];

        $this->pdo = new \PDO($dsn, $user, $password);
    }

    public function execute(string $query)
    {
        return $this->pdo->exec($query);
    }

    public function getLastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    public function select(array $fields = ['*']): self
    {
        $queryFields = implode(', ', $fields);

        $this->query = $this->pdo->query("SELECT {$queryFields} FROM {$this->table}");

        return $this;
    }

    public function insert(array $fields): int
    {
        $this->newPDO();

        $fields = $this->sanitizeInputs($fields);
        $tableFields = [];
        $paramValues = [];

        foreach ($fields as $key => $value) {
            $tableFields[] = $key;
            $paramValues = ":{$key}";
        }

        $tableFields = implode(', ', $tableFields);
        $paramValues = implode(', ', $paramValues);

        $sql = "INSERT INTO {$this->table} ($tableFields}) values {$paramValues}";

        $statement = $this->pdo->prepare($sql);

        foreach ($fields as $key => $value) {
            $statement->bindParam(":{$key}", $value);
        }

        $statement->execute();

        return $this->getLastInsertId();
    }

    public function delete(int $id): bool
    {
        $this->newPDO();

        try {
            $sql = "DELETE FROM {$this->table} WHERE id = {$id}";

            $this->pdo->beginTransaction();
            $statement = $this->pdo->prepare($sql);
            $statement->execute();

            foreach ($this->relationships as $relationship) {
                $rSql = "DELETE FROM {$relationship} WHERE {$this->table}_id = {$id}";
                $rStatement = $this->pdo->prepare($rSql);
                $rStatement->execute();
            }

            $this->pdo->commit();

            return true;

        } catch (\PDOException $exception) {
            $this->pdo->rollBack();

            return false;
        }
    }

    public function get(): array
    {
        $data = [];

        $rows = $this->query->fetchAll();

        foreach ($rows as $row) {
            $class = new self;
            foreach ($this->fields as $field) {
                $fieldAccessorFunctionName = $this->getFieldAccessorFunctionName($field);
                $class->{"set{$fieldAccessorFunctionName}"}($row[$field]);
            }

            $data[] = $class->toArray();
        }

        return $data;
    }

    public function toArray(): array
    {
        $data = [];

        foreach ($this->fields as $field) {
            $fieldAccessorFunctionName = $this->getFieldAccessorFunctionName($field);
            $data[$field] = $this->{"get{$fieldAccessorFunctionName}"}();
        }

        return $data;
    }

    private function getFieldAccessorFunctionName(string $field): string
    {
        return implode('', array_map(function ($fieldNamePart) {
            return ucfirst($fieldNamePart);
        }, explode('_', $field)));
    }

    private function sanitizeInputs(array $inputs): array
    {
        $cleanInputs = [];

        foreach ($inputs as $field => $value) {
            $cleanVal = strip_tags($value);

            switch ($field) {
                case 'id':
                    $cleanVal = filter_var($cleanVal, FILTER_SANITIZE_NUMBER_INT);
                    break;
                default:
                    $cleanVal = filter_var($cleanVal, FILTER_SANITIZE_STRING);
            }

            $cleanInputs[$field] = $cleanVal;
        }

        return $cleanInputs;
    }
}