<?php

namespace Schedule\Contact\Repository;

use Illuminate\Support\Facades\DB;
use Schedule\Contact\Entity\Contact;
use Schedule\Contact\Exception\ContactException;

class ContactRepository {
    public static function save(Contact $contact): int {
        try {
            return DB::table('contacts')
                ->insertGetId([
                    'first_name' => $contact->first_name,
                    'last_name' => $contact->last_name,
                    'email' => $contact->email,
                    'phone' => $contact->phone,
                ]);
        } catch (\Exception $e) {
            throw new ContactException('Email already save');
        }
    }

    public static function update(array $params, int $id): void {
        try {
            DB::table('contacts')
                ->where(['id' => $id])
                ->update($params);
        } catch (\Exception $e) {
            throw new ContactException('Could not update the contact');
        }
    }

    public static function delete(int $id): void {
        try {
            DB::table('contacts')
                ->where(['id' => $id])
                ->delete();
        } catch (\Exception $e) {
            throw new ContactException('Could not update the contact');
        }
    }
}
