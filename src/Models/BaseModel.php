<?php

namespace App\Models;

abstract class BaseModel
{
    protected $table;
    protected $column;
    protected $db;
    protected $qb;

    public function __construct($db)
    {
        $this->db = $db;
    }

// Get All
    public function getAll()
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('*')
                                 ->from($this->table)
                                 ->where('deleted = 0');
        $query = $qb->execute();

        return $query->fetchAll();
    }

// Find 
    public function find($column, $value)
    {
        $param = ':'.$column;
        $qb = $this->db->createQueryBuilder();
        $qb
                   ->select('*')
                   ->from($this->table)
                   ->setParameter($param, $value)
                   ->where($column.' = '.$param);
        $result = $qb->execute();

        return $result->fetch();
    }

// Craete Data
    public function createData(array $data)
    {
        $valuesColumn = [];
        $valuesData = [];

        foreach ($data as $dataKey => $dataValue) {
            $valuesColumn[$dataKey] = ':'.$dataKey;
            $valuesData[$dataKey] = $dataValue;
        }

        $qb = $this->db->createQueryBuilder();

        $qb->insert($this->table)
                                 ->values($valuesColumn)
                                 ->setParameters($valuesData)
                                 ->execute();
    }

// Update Data
     public function updateData(array $data, $id)
     {
         $valuesColumn = [];
         $valuesData = [];
         $qb = $this->db->createQueryBuilder();

         $qb->update($this->table);

         foreach ($data as $dataKey => $dataValue) {
             $valuesColumn[$dataKey] = ':'.$dataKey;
             $valuesData[$dataKey] = $dataValue;

             $qb->set($dataKey, $valuesColumn[$dataKey]);
         }

         $qb->setParameters($valuesData)
                                 ->where('id = '.$id)
                                 ->execute();
     }

// HardDelete
    public function hardDelete($id)
    {
        $qb = $this->db->createQueryBuilder();

        $qb->delete($this->table)
                                 ->set('deleted', 1)
                                 ->where('id = '.$id)
                                 ->execute();
    }

// Paginate

    public function paginate($page, $query, $limit)
    {
        $qb = $this->db->createQueryBuilder();
        $getRows = $qb->select('COUNT(id) as rows')
                    ->from($this->table)
                    ->execute()
                    ->fetch();
        $perpage = $limit;
        $total = $getRows['rows'];
        $pages = (int) ceil($total / $perpage);
        $data = array(
            'options' => array(
            'default' => 1,
            'min_range' => 1,
            'max_range' => $pages,
            ),
        );

        $number = (int) $page;
        $range = $perpage * ($number - 1);
        // if ($page >= 2) {
        //     $limit = $limit - 1;
        // }
        $qb = $this->db->createQueryBuilder();
        $test = $qb->select($this->column)
                   ->from($this->table)
                   ->setFirstResult($range)
                   ->setMaxResults($limit)
                   ->execute();

        return $test->fetchAll();
    }
}
