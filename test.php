<?php
/* OO API */

$memcache_obj = new Memcache;

/* connect to memcached server */
$memcache_obj->connect('localhost', 11211);

/*
set value of item with key 'var_key', using on-the-fly compression
expire time is 50 seconds
*/
$memcache_obj->set('var_key', 'some really big variable', MEMCACHE_COMPRESSED, 50);

echo $memcache_obj->get('var_key');

?>

