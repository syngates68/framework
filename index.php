<?php
session_start();

date_default_timezone_set('Europe/Paris');

require_once('config/config.inc.php');
require_once('config/sqlconnect.inc.php');
require_once('model/Model.php');

//On initialise le lien avec la BDD pour les modèles
Model::set_db($bdd);

$ctrl = (isset($_GET['ctrl']) && $_GET['ctrl'] != null) ? $_GET['ctrl'] : 'home';
$action = (isset($_GET['action'])) ? $_GET['action'] : null;

$ctrl_file = 'controller/'.ucfirst($ctrl).'Controller.inc.php';
if (file_exists($ctrl_file))
{
    require_once($ctrl_file);

    $ctrl_class = ucfirst($ctrl).'Controller';
    if (class_exists($ctrl_class))
    {
        $c = new $ctrl_class();
        $action = ($action == null) ? 'index' : $action;

        $method = $_SERVER['REQUEST_METHOD'].'_'.$action;
        if (method_exists($c, $method))
        {
            if (strtolower($_SERVER['REQUEST_METHOD']) == 'get')
            {
                ob_start();
                $c->$method();
                $content = ob_get_clean();
            }
            else
                $c->$method();
        }
        else
        {
            header('Location: '.BASEURL);
            exit();
        }
    }
    else
    {
        header('Location: '.BASEURL);
        exit();
    }
}
else
{
    header('Location: '.BASEURL);
    exit();
}

if ((!array_key_exists('HTTP_X_REQUESTED_WITH', $_SERVER) || !strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') && !isset($_GET['mode']))
{
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constructeur de Framework CSS</title>
    <link rel="icon" type="image/png" href="<?= BASEURL; ?>assets/images/logo.png"> 
    <link rel="stylesheet" href="<?= BASEURL; ?>assets/css/main.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>assets/colorpicker/style.css">
    <script src="<?= BASEURL; ?>assets/js/jquery.js"></script>
    <script src="<?= BASEURL; ?>assets/js/main.js" defer></script>
    <script src="<?= BASEURL; ?>assets/colorpicker/colorpicker.js" defer></script>
    <script>var baseurl = "<?= BASEURL; ?>"</script>
    
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons|Material+Icons+Outlined" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&family=Lato:ital,wght@0,100;0,300;0,400;0,700;0,900;1,100;1,300;1,400;1,700;1,900&family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Open+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,300;1,400;1,500;1,600;1,700;1,800&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Source+Sans+Pro:ital,wght@0,200;0,300;0,400;0,600;0,700;0,900;1,200;1,300;1,400;1,600;1,700;1,900&display=swap" rel="stylesheet"></head>
<body>
    <nav class="navbar">
        <div class="navbar-content">
            <div class="navbar-content__left">
                <img src="<?= BASEURL; ?>assets/images/logo-title.png" class="logo" />
            </div>
            <div class="navbar-content__middle">
                <ul>
                    <li><a href="#">Lien 1</a></li>
                    <li><a href="#">Lien 2</a></li>
                    <li><a href="#">Lien 3</a></li>
                    <li><a href="#">Lien 4</a></li>
                </ul>
                <div class="navbar-content__right">
                    <button class="btn primary-outline">Connexion</button>
                    <button class="btn primary">Incription</button>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        <?= $content; ?>
    </div>
</body>
</html>
<?php
}
else if (isset($_GET['mode']) && $_GET['mode'] == 'empty')
    echo $content;