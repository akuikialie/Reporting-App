<?php

use Phinx\Seed\AbstractSeed;

class UserGroupSeed extends AbstractSeed
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
            'group_id' =>  '1',
            'user_id'  =>  '1',
        ];

        $data[] = [
            'group_id' =>  '1',
            'user_id'  =>  '2',
        ];

        $this->insert('user_group', $data);
    }
}
