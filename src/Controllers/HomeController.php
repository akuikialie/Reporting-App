<?php

namespace App\Controllers;

class HomeController extends BaseController
{
        public function index($request, $response)
        {
        	$data = $this->responseDetail(200, 'Success', 'Selamat Datang Di reporting App');

       		return $data;
        }
}
