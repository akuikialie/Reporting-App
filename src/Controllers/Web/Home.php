<?php

namespace App\Controllers\Web;
use App\Controllers\BaseController;

class Home extends BaseController
{
    public function index($request, $response)
    {
        return $this->view->render($response, 'index.twig');
    }
}

?>
