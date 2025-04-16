<?php
    require_once 'config.php';
    require_once 'controller/giteController.php';
    require_once 'controller/userController.php';

    use Controller\GiteController;
    use Controller\UserController;

    $url = "";

    if(isset($_GET['url']))
    {
        $url = $_GET['url'];
    }
    else
    {
        $url = '/';
    }

    $giteController = new GiteController($pdo);
    $userController = new UserController($pdo);

    switch($url)
    {
        case '/':
            require_once 'view/home.php';
            break;
        case 'addGita':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $giteController->addGita($_POST['nome'], $_POST['data_inizio'], $_POST['data_fine'], $_POST['meta'], $_POST['max_partecipanti']);
            } else {
                require_once 'view/addGita.php';
            }
            break;
        case 'joinGita':
            if (isset($_GET['gita_id'])) {
                $giteController->joinGita($_GET['gita_id']);
            } else {
                echo "<script>alert('ID gita non specificato.'); window.location.href = 'index.php?url=myGite';</script>";
            }
            break;
        case 'addReview':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $giteController->addReview($_POST['gita_id'], $_POST['stelle'], $_POST['testo']);
            } else {
                require_once 'view/addReview.php';
            }
            break;
        case 'signup':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController->signup(
                    $_POST['nome'],
                    $_POST['cognome'],
                    $_POST['email'],
                    $_POST['password'],
                    $_POST['classe']
                );
            } else {
                require_once 'view/signup.php';
            }
            break;
        case 'login':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $userController->login($_POST['username'], $_POST['password']);
            } else {
                require_once 'view/login.php';
            }
            break;
        case 'editGita':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $giteController->editGita($_GET['gita_id'], $_POST['nome'], $_POST['data_inizio'], $_POST['data_fine'], $_POST['meta'], $_POST['max_partecipanti']);
            } else {
                $gitaId = $_GET['gita_id'];
                require_once 'view/editGita.php';
            }
            break;
        case 'loginAsUser':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                session_start();
                $userId = $_POST['user_id'];
                $_SESSION['id'] = $userId;
                $_SESSION['classe'] = $userId == 4 ? 'PRF' : 'STD'; // Default to PRF for user 4, STD otherwise
                header('Location: index.php?url=myGite');
                exit();
            }
            break;
        case 'myGite':
            require_once 'view/myGite.php';
            break;
        case 'addTour':
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $giteController->addTour($_POST['gita_id'], $_POST['nome'], $_POST['prezzo'], $_POST['descrizione']);
            } else {
                require_once 'view/addTour.php';
            }
            break;
        case 'viewGita':
            if (isset($_GET['gita_id'])) {
                $gitaId = $_GET['gita_id'];
                require_once 'view/viewGita.php';
            } else {
                echo "<script>alert('ID gita non specificato.'); window.location.href = 'index.php?url=myGite';</script>";
            }
            break;
        default:
            echo "404 Not Found";
            break;
    }
?>