<?php

namespace Amir\Todolist\Request;

interface IRequest
{
	public function getHeader ();

	public function getBody ();
}