<?php

namespace Schedule\Message\Repository;

use Illuminate\Support\Facades\DB;
use Schedule\Message\Entity\Message;
use Schedule\Message\Exception\MessageException;

class MessageRepository {
    public static function save(Message $message): int {
        try {
            return DB::table('messages')
                ->insertGetId([
                    'message' => $message->message,
                    'contact_id' => $message->contact_id,
                ]);
        } catch (\Exception $e) {
            throw new MessageException('Could not save the message');
        }
    }

    public static function update(array $params, int $message_id, int $contact_id): void {
        try {
            DB::table('messages')
                ->where('id', $message_id)
                ->where('contact_id', $contact_id)
                ->update($params);
        } catch (\Exception $e) {
            throw new MessageException('Could not update the message');
        }
    }

    public static function delete(int $message_id, int $contact_id): void {
        try {
            DB::table('messages')
                ->where('id', $message_id)
                ->where('contact_id', $contact_id)
                ->delete();
        } catch (\Exception $e) {
            throw new MessageException('Could not delete the message');
        }
    }

    public static function deleteByContactId(int $contact_id): void {
        try {
            DB::table('messages')
                ->where('contact_id', $contact_id)
                ->delete();
        } catch (\Exception $e) {
            throw new MessageException('Could not delete the contact messages');
        }
    }

    public static function loadByContactId(int $contact_id): array {
        $message_list = [];
        try {
            $messages = DB::table('messages')
                ->select('message')
                ->where('contact_id', $contact_id)
                ->get();

            foreach ($messages as $message) {
                $message_list[] = $message;
            }

            return $message_list;
        } catch (\Exception $e) {
            throw new MessageException('Could not list the messages');
        }
    }
}
