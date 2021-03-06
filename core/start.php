<?php

Autoloader::namespaces(array(
	'LCQRS' => __DIR__
));

use LCQRS\Bus;

Route::controller('lcqrs::testing');

Bus::register('lcqrs.command', function($identifier, $message) {
	$command_handler = str_replace('Commands', 'CommandHandlers', $identifier);
	$command = unserialize($message);
	new $command_handler($command);
});