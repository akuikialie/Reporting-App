<?php

use Phinx\Seed\AbstractSeed;

class UserRolesSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeders is available here:
     * http://docs.phinx.org/en/latest/seeding.html
     */
    public function run()
    {
        $data[] = [
            'role_id' =>  1,
            'user_id'  =>  1,
        ];

        $data[] = [
            'role_id' =>  2,
            'user_id'  =>  2,
        ];

        $data[] = [
            'role_id' =>  3,
            'user_id'  =>  3,
        ];

        $data[] = [
            'role_id' =>  1,
            'user_id'  =>  4,
        ];

        $this->insert('user_role', $data);
    }
}
