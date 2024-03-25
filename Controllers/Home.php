<?php
class Home extends Controller
{
    public function __construct() {
        session_start();
        
        if (!empty($_SESSION['activo1'])) {
            //echo $_SESSION['activo'];
            header("location: ".base_url. "Principal");
        }
        parent::__construct();
    }
    public function index()
    {
        $this->views->getView($this, "index");
    }
    
}
