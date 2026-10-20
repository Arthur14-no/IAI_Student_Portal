<?php   
        require __DIR__. '/vendor/autoload.php';

        session_start();

        

        use App\Controllers\EtudiantController;

        $controller= new EtudiantController();
        /*$controller-> Index();
        $controller-> Admis();
        $controller-> Echoue(); */

       // $page= $_GET['page']?? 'liste';

        if (isset($_GET['page'])) {
                $page= $_GET['page'];
        }
        else {
                $page= 'listes';
        }



        if ($page === 'listes') {
                $controller-> Listes();
        }
        elseif ($page === 'admis') {
                $controller-> Admis();
        }
        elseif ($page === 'echoue') {
                $controller-> Echoue();
        }
        elseif ($page === 'ajouter') {
                $controller-> Ajouter();
        }
        elseif ($page === 'creer') {
                $controller-> Creer();
        }
      

?>