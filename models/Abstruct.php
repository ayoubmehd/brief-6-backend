<?php
class Abstruct
{

    protected $cnx;
    protected $result;
    protected $errors;
    protected $isError;
    protected $query;
    protected $params;
    protected $fetchConstant;

    // private static $table = "user";

    function __construct()
    {
        $this->isError = false;
        $this->query = "";
        $this->params = [];
        $this->fetchConstant = PDO::FETCH_ASSOC;
        try {
            $this->cnx = new PDO($this->dsn(DB_NAME, DB_HOST), DB_USER, DB_PASS);
        } catch (PDOException $exception) {
            var_dump($exception);

            $this->isError = true;
        }
    }

    function __get($var)
    {
        return $this->$var;
    }

    public static function init()
    {
        return new static();
    }

    private function dsn($dbname, $dbhost)
    {
        return "mysql: host=$dbhost;dbname=$dbname";
    }

    protected function buildQuery($data)
    {
        $returns = [
            "cols" => [],
            "rows" => [],
            "vals" => []
        ];

        if (is_array($data))
            foreach ($data as $key => $value) {
                $returns["cols"][] = $key;
                $returns["rows"][] = "?";
                $returns["vals"][] = $value;
            }

        return $returns;
    }

    protected function inserQuery($data)
    {

        $buildQuery = $this->buildQuery($data);

        $query = "INSERT INTO " . static::$table . "("
            . implode(",", $buildQuery["cols"])
            . ") VALUES("
            . implode(",", $buildQuery["rows"])
            . ")";

        return [
            "query" => $query,
            "values" => $buildQuery["vals"]
        ];
    }

    protected function updateQuery($data, $where)
    {

        $buildQuery = $this->buildQuery($data);

        $query = "UPDATE " . static::$table . " SET "
            . implode("=?, ", $buildQuery["cols"])
            . "=?$where";

        return [
            "query" => $query,
            "values" => $buildQuery["vals"]
        ];
    }

    protected function deleteQuery($where)
    {
        return "DELETE FROM " . static::$table . $where;
    }

    protected function selectQuery(array $select)
    {
        $query = "SELECT " . implode(", ", $select) . " FROM " . static::$table;

        return $query;
    }

    function whereQuery($where)
    {
        extract($this->buildQuery($where));
        $query_string = "";
        foreach ($cols as $key => $value) {
            $query_string .= $value . "=?,";
        }

        $query_string = rtrim($query_string, ",");
        return [
            "query_string" => " WHERE " . $query_string,
            "values" => $vals
        ];
    }

    public function insert($data)
    {
        $insert = $this->inserQuery($data);
        extract($insert);

        $this->query = $query;
        $this->params = $values;

        return $this;
    }

    public function update($data, $where)
    {
        $where = $this->whereQuery($where);
        $update = $this->updateQuery($data, $where["query_string"]);
        extract($update);

        $this->query = $query;
        $this->params = array_merge($values, $where["values"]);

        return $this;
    }

    public function delete($where)
    {
        $where = $this->whereQuery($where);

        $this->query = $this->deleteQuery($where["query_string"]);
        $this->params = $where["values"];

        return $this;
    }

    public function select(array $select = ["*"])
    {
        $this->query =  $this->selectQuery($select);

        return $this;
    }

    public function where($where)
    {
        extract($this->whereQuery($where));
        $this->query .= $query_string;
        $this->params = $values;

        return $this;
    }

    public function in($statement)
    {
        $this->query .= "($statement)";

        return $this;
    }

    public function group_by($column)
    {
        $this->query .= "GROUP BY  `$column`";

        return $this;
    }

    public function query($query, $params = [], $fetchConstant = PDO::FETCH_ASSOC)
    {
        $this->query = $query;
        $this->execute($params);
        $this->result = $result->fetchAll($fetchConstant);
        $this->errors =  $result->errorInfo();

        return $this;
    }

    public function execute()
    {
        $result = $this->cnx->prepare($this->query);
        $result->execute($this->params);

        $this->result = $result->fetchAll($this->fetchConstant);
        $this->errors =  $result->errorInfo();

        return $this;
    }

    public function getLastInsertId()
    {
        return $this->cnx->lastInsertId();
    }
}
