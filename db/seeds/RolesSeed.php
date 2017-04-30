<?php

use Phinx\Seed\AbstractSeed;

class RolesSeed extends AbstractSeed
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
            'name'         =>  'user',
            'updated_at'   =>  '2017-04-30 00:00:00',
            'created_at'   =>  '2017-05-30 00:00:00',
        ];

        $data[] = [
            'name'         =>  'pic',
            'updated_at'   =>  '2017-04-30 00:00:00',
            'created_at'   =>  '2017-05-30 00:00:00',
        ];

        $data[] = [
            'name'         =>  'guardian',
            'updated_at'   =>  '2017-04-30 00:00:00',
            'created_at'   =>  '2017-05-30 00:00:00',
        ];

        $this->insert('roles', $data);
    }
}
