<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class User extends Model
{
    /**
     * @var mixed
     */
    private $result;

    /**
     * @var string
     */
    protected $table = "users";

    /**
     * @var int
     */
    private $col_id = "id";

    /**
     * @var string
     */
    private $col_email = "email";

    /**
     * @var string
     */
    private $col_username = "username";

    /**
     * @var string
     */
    private $col_password = "password";

    /**
     * @var string
     */
    private $col_phone = "phone";

    /**
     * @var string
     */
    private $col_website = "website";

    /**
     * @param string $username
     * @param string $password
     * 
     * @return bool
     */
    public function checkUser(string $username, string $password): bool
    {
        $this->result = DB::table($this->table)
            ->where($this->col_username, $username)
            ->where($this->col_password, $password)
            ->first();

        return $this->result !== null;
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @param string $phone
     * @param string $website
     * 
     * @return bool
     */
    public function addUser(string $username, string $email, string $password, string $phone, string $website): bool
    {
        $this->result = null;
        if (DB::table($this->table)
            ->where($this->col_username, $username)
            ->first() !== null
        ) {
            $this->result = "Username exists";
            return false;
        }
        if (DB::table($this->table)
            ->where($this->col_email, $email)
            ->first() !== null
        ) {
            $this->result = "Email exists";
            return false;
        }

        $result = DB::table($this->table)
            ->insert([
                $this->col_username => $username,
                $this->col_email => $email,
                $this->col_password => $password,
                $this->col_website => $website,
                $this->col_phone => $phone
            ]);

        if ($result) {
            return true;
        }

        $this->result = $result;
        return false;
    }

    /**
     * @param int $id
     * @param string $website
     * @param string $phone
     * 
     * @return bool
     */
    public function updateProfile(int $id, string $website, string $phone): bool
    {
        $this->result = null;
        if (DB::table($this->table)
            ->where($this->col_id, $id)
            ->first() === null
        ) {
            $this->result = "Something went wrong, profile not found";
            return false;
        }

        $result = DB::table($this->table)
            ->where($this->col_id, $id)
            ->update([
                $this->col_phone => $phone,
                $this->col_website => $website
            ]);

        if ($result) {
            $this->result = DB::table($this->table)
                ->where($this->col_id, $id)
                ->first();
            return true;
        }

        $this->result = $result;
        return false;
    }

    /**
     * @param int $id
     * @param string $oldPassword
     * @param string $newPassword
     * 
     * @return bool
     */
    public function updatePassword(int $id, string $oldPassword, string $newPassword): bool
    {
        $this->result = null;
        if (DB::table($this->table)
            ->where($this->col_id, $id)
            ->where($this->col_password, $oldPassword)
            ->first() === null
        ) {
            $this->result = "Current password is wrong!";
            return false;
        }

        $result = DB::table($this->table)
            ->where($this->col_id, $id)
            ->update([
                $this->col_password => $newPassword
            ]);

        if ($result) {
            $this->result = DB::table($this->table)
                ->where($this->col_id, $id)
                ->first();
            return true;
        }

        $this->result = $result;
        return false;
    }

    /**
     * Returns the result of last executed action
     * 
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}
