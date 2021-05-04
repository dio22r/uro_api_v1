<?php

namespace App\Controllers;

class Home extends BaseController
{
	public function index()
	{
		echo "test";
		return view('welcome_message');
	}
}
