<?php

namespace Schedule\Message;

use Schedule\Message\Entity\Message;
use Schedule\Message\Exception\MessageException;
use Schedule\Message\Repository\MessageRepository;

class MessageService {
    public static function listMessages(int $contact_id): array {
        return MessageRepository::loadByContactId($contact_id);
    }

    public static function create(array $params, int $contact_id): int {
        $message = self::buildMessageEntity($params, $contact_id);
        self::validateMessage($message);
        return MessageRepository::save($message);
    }

    public static function update(array $params, int $contact_id, int $message_id): void {
        MessageRepository::update($params, $message_id, $contact_id);
    }

    public static function delete(int $contact_id, int $message_id): void {
        MessageRepository::delete($message_id, $contact_id);
    }

    private static function buildMessageEntity(array $params, int $contact_id): Message {
        $message = new Message();
        $message->message = $params['message'] ?? null;
        $message->contact_id = $contact_id;

        return $message;
    }

    private static function validateMessage(Message $message): void {
        if (is_null($message->message)) {
            throw new MessageException('Invalid message');
        }
    }
}
