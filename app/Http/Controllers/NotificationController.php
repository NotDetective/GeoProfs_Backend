<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotificationEmail;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{

    private array $ValidateTypes = ['low', 'medium', 'high'];
    private array $sendEmailTypes = ['high'];

    /**
     *
     * @param string $message
     * @param string $type
     * @param User $receiver
     *
     * @throws \Exception
     */
    public function createNotification(string $message, string $type, User $receiver)
    {

        if ($this->checkIfTypeIsValidate($type)) {
            throw new \Exception('Invalid type');
        }

        $this->sendNotification($message, $type, $receiver);
        $this->sendEmail($message, $type, $receiver);
    }

    private function sendNotification(string $message, string $type, User $receiver): void
    {
        Notification::create([
            'message' => $message,
            'type' => $type,
            'user_id' => $receiver->id,
        ]);
    }

    private function sendEmail(string $message, string $type, User $receiver): void
    {
        if (!in_array($type, $this->sendEmailTypes)) {
            return;
        }

        SendNotificationEmail::dispatch($message, $receiver);
    }

    private function checkIfTypeIsValidate(string $type): bool
    {
        return !in_array($type, $this->ValidateTypes);
    }

}
