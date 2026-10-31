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


        if($page == 'export_pdf'){
                (new \App\Controllers\EtudiantController())-> exportPdf();
                exit;
        }


        if ($page === 'editer') {
                (new \App\Controllers\EtudiantController())-> Editer();
        
                exit;
        }

        if ($page === 'supprimer') {
                (new \App\Controllers\EtudiantController())-> Supprimer();

                exit;
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