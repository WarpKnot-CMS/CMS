<?php
/**
 * @package   WarpKnot
 */

/**
 * Database connection for default plugin
 */

namespace _MODULE\_DB;

use _WKNT\_CRUD;

class Migrate Extends _CRUD
{
    //:: Table name
    protected $table = 'migrate';

    //:: Primary key
    protected $key = 'mid';
}
