<?php

namespace tm\core\base;

use tm\core\Database;
use Valitron\Validator;

abstract class Model
{
    protected $pdo;
    protected $table;
    protected $primary = 'id';
    public $attributes = [];
    public $errors = [];
    public $rules = [];

    public function __construct()
    {
        $this->pdo = Database::instance();
    }

    public function query($sql)
    {
        return $this->pdo->execute($sql);
    }

    public function get()
    {
        $sql = 'SELECT * FROM ' . $this->table;
        return $this->pdo->query($sql);
    }

    public function find($id, $field = '')
    {
        $field = $field ?: $this->primary;
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE ' . $field . ' = ? LIMIT 1';

        return $this->pdo->query($sql, [$id]);
    }

    public function sql($sql, $params = [])
    {
        return $this->pdo->query($sql, $params);
    }

    public function like($str, $field, $table = '')
    {
        $table = $table ?: $this->table;
        $sql = 'SELECT * FROM ' . $table . ' WHERE ' . $field . ' LIKE ?';

        return $this->pdo->query($sql, ['%' . $str . '%']);
    }

    public function load($data)
    {
        foreach ($this->attributes as $key => $value){
            if(isset($data[$key])){
                $this->attributes[$key] = $data[$key];
            }
        }
    }

    public function validate($data)
    {
        $validator = new Validator($data);
        $validator->rules($this->rules);
        if($validator->validate()){

            return true;
        }

        $this->errors = $validator->errors();

        return false;
    }

    public function getErrors()
    {
        $errors = '<ul>';
        foreach($this->errors as $error){
            foreach($error as $item){
                $errors .= "<li>$item</li>";
            }
        }
        $errors .= '</ul>';
        $_SESSION['error'] = $errors;
    }

    public function save($table)
    {
        $tbl = \R::dispense($table);

        foreach ($this->attributes as $key => $value){
            $tbl[$key] = $value;
        }

        return \R::store($tbl);
    }
}