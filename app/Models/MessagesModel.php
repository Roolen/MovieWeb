<?php namespace App\Models;

use CodeIgniter\Model;

class MessagesModel extends Model
{
    protected $table = "messages";
    protected $primaryKey = "id";
    protected $allowedFields = [
        'id_sender',
        'id_recipient',
        'text_message'
    ];

    public function getSendMessages(int $idUser)
    {
        $messages = $this->asArray()
                         ->where(['id_sender' => $idUser])
                         ->findAll();

        return ($messages)
               ? $messages
               : false;
    }

    public function getWritedUsers(int $idUser)
    {
        $idsUsers = $this->asArray()
                         ->where(['id_recipient' => $idUser])
                         ->findAll();

        return ($idsUsers)
               ? $idsUsers
               : false;
    }

    public function getMessages(int $idUserOne, int $idUserTwo)
    {
        $messages = $this->asArray()
                         ->whereIn('id_sender', [$idUserOne, $idUserTwo])
                         ->orWhereIn('id_recipient', [$idUserOne, $idUserTwo])
                         ->findAll();

        return ($messages)
               ? $messages
               : false;
    }

    public function getSenders(int $idUser)
    {
        $messages = $this->asArray()
                        ->where(['id_sender' => $idUser])
                        ->orWhere(['id_recipient' => $idUser])
                        ->findAll();

        if ($messages) {
            $idUsers = [];
            foreach ($messages as $message) {
                if ($message['id_sender'] != $idUser) {
                    $idUsers[] = $message['id_sender'];
                }
                else if ($message['id_recipient'] != $idUser) {
                    $idUsers[] = $message['id_recipient'];
                }
            }

            return array_unique($idUsers);
        }
        else {
            return false;
        }
    }

    public function createMessage(int $idSender, int $idRecipient, string $text)
    {
        $message = $this->insert(['id_sender' => $idSender,
                                  'id_recipient' => $idRecipient,
                                  'text_message' => $text]);

        return ($message)
               ? $message
               : false;
    }
}