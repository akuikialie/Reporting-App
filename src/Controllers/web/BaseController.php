<?php

namespace App\Controllers\web;

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

abstract class BaseController
{
	protected $container;

	public function __construct($container)
	{
		return $this->container = $container;
	}

	public function __get($property)
	{
		return $this->container->{$property};
	}
}

?>
