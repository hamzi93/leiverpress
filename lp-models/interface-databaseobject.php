<?php

/**
 * Das Interface in den Repos Ordner
 */
interface DatabaseObject{

    static function create();
    static function update();
    static function getAll();
    static function getById($id);
    static function delete($id);
}