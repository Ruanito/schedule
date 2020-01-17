<?php

namespace Schedule\Contact;

use Schedule\Contact\Entity\Contact;
use Schedule\Contact\Exception\ContactException;
use Schedule\Contact\Repository\ContactRepository;
use Schedule\Message\Repository\MessageRepository;

class ContactService {
    public static function create(array $params): int {
        $contact = self::buildContactEntity($params);
        self::validateContact($contact);
        return ContactRepository::save($contact);
    }

    public static function update(array $params, int $id): void {
        ContactRepository::update($params, $id);
    }

    public static function delete(int $id): void {
        MessageRepository::deleteByContactId($id);
        ContactRepository::delete($id);
    }

    private static function buildContactEntity(array $params): Contact {
        $contact = new Contact();
        $contact->first_name = $params['first_name'] ?? null;
        $contact->last_name = $params['last_name'] ?? null;
        $contact->email = $params['email'] ?? null;
        $contact->phone = $params['phone'] ?? null;

        return $contact;
    }

    private static function validateContact(Contact $contact): void {
        if (is_null($contact->first_name)) {
            throw new ContactException('Invalid First Name');
        }

        if (is_null($contact->email)) {
            throw new ContactException('Invalid Email');
        }

        if (is_null($contact->last_name)) {
            throw new ContactException('Invalid Last Name');
        }

        if (is_null($contact->phone)) {
            throw new ContactException('Invalid Phone');
        }
    }
}
