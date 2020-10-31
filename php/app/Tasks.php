<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Tasks extends Model
{
    /**
     * @var string
     */
    protected $table = "tasks";

    /**
     * @var int
     */
    private $col_id = "id";

    /**
     * @var int
     */
    private $col_user = "user";

    /**
     * @var string
     */
    private $col_name = "name";

    /**
     * @var string
     */
    private $col_due = "due";

    /**
     * @var string
     */
    private $col_status = "status";

    /**
     * @param int $user
     * @param string $status
     * 
     * @return array
     */
    public function getAll(int $user, string $status): array
    {
        $result = [];
        if ($status == "") {
            $result = (DB::table($this->table)
                ->where($this->col_user, $user)
                ->get())->all();
        } else {
            $result = (DB::table($this->table)
                ->where($this->col_user, $user)
                ->where($this->col_status, $status)
                ->get())->all();
        }

        return $result;
    }

    /**
     * @param int $user
     * @param string $name
     * @param string $due
     * @param string $status
     * 
     * @return bool
     */
    public function createTask(int $user, string $name, string $due, string $status): bool
    {
        $result = DB::table($this->table)
            ->insert([
                $this->col_user => $user,
                $this->col_name => $name,
                $this->col_due => $due,
                $this->col_status => $status
            ]);

        if ($result) {
            return true;
        }
        return false;
    }
}
