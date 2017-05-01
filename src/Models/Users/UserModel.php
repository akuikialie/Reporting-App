<?php 

namespace App\Models\Users;

use App\Models\BaseModel;

class UserModel extends BaseModel
{
    protected $table = 'users';
    protected $column = ['id', 'name', 'email', 'username', 'password', 'gender', 'address', 'phone', 'image', 'updated_at', 'created_at', 'is_admin'];

    public function createUser(array $data)
    {
        $data = [
            'name' => $data['name'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_BCRYPT),
            'gender' => $data['gender'],
            'address' => $data['address'],
            'phone' => $data['phone'],
            'image' => $data['image']
        ];

        $this->createData($data);
        return $this->db->lastInsertId();
    }

    public function getAllUser()
        {
            $qb = $this->db->createQueryBuilder();
                $qb->select('*')
                                 ->from($this->table)
                                 ->where('is_admin = 0');
                $query = $qb->execute();
                return $query->fetchAll();
        }
}
