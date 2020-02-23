<?php namespace App\Models;

use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'is_hidden_email',
        'is_hidden_phone',
        'is_send_notifications'
    ];

    public function getSettings(int $idUser)
    {
        $settings = $this->asArray()
                         ->where(['id' => $idUser])
                         ->first();

        return ($settings)
               ? $settings
               : false;
    }

    public function acceptSettings(int $idUser, array $settings)
    {
        $status = $this->update($idUser, $settings);

        return $status;
    }

    public function createSettings(int $idUser)
    {
        $status = $this->insert(['id' => $idUser]);

        return ($status)
               ? $status
               : false;
    }
}