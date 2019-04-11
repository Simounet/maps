<?php

/**
 * Nextcloud - maps
 *
 * This file is licensed under the Affero General Public License version 3 or
 * later. See the COPYING file.
 *
 * @author Piotr Bator <prbator@gmail.com>
 * @copyright Piotr Bator 2017
 */

 namespace OCA\Maps\DB;

use OCP\IDBConnection;
use OCP\AppFramework\Db\Mapper;

class GeophotoMapper extends Mapper {

    public function __construct(IDBConnection $db) {
        parent::__construct($db, 'maps_photos');
    }

    public function find($id) {
        $sql = 'SELECT * FROM `*PREFIX*maps_photos` ' .
            'WHERE `id` = ?';
        return $this->findEntity($sql, [$id]);
    }

    public function findByFileId($userId, $fileId) {
        try {
            $sql = 'SELECT * FROM `*PREFIX*maps_photos` ' .
                'WHERE `user_id` = ? ' .
                'AND `file_id` = ? ';
            return $this->findEntity($sql, [$userId, $fileId]);
        }
        catch (\Throwable $e) {
            return null;
        }
    }

    public function findAll($userId, $limit=null, $offset=null) {
        $sql = 'SELECT * FROM `*PREFIX*maps_photos` where `user_id` = ? and `lat` is not null and `long` is not null';
        return $this->findEntities($sql, [$userId], $limit, $offset);
    }

    public function findAllNonLocalized($userId, $limit=null, $offset=null) {
        $sql = 'SELECT * FROM `*PREFIX*maps_photos` where `user_id` = ? and (`lat` is null or `long` is  null)';
        return $this->findEntities($sql, [$userId], $limit, $offset);
    }

    public function deleteByFileId($fileId) {
        $sql = 'DELETE FROM `*PREFIX*maps_photos` where `file_id` = ?';
        return $this->execute($sql, [$fileId]);
    }

    public function deleteAll($userId) {
        $sql = 'DELETE FROM `*PREFIX*maps_photos` where `user_id` = ?';
        return $this->execute($sql, [$userId]);
    }

}
