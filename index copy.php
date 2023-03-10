<?php
session_start();

date_default_timezone_set('Europe/Paris');

require_once('config/config.inc.php');
require_once('config/sqlconnect.inc.php');
require_once('model/Model.php');
require_once('model/Projets.php');
require_once('model/Components.php');
require_once('model/Regles.php');

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

$uniqidprojet = (isset($_GET['projet'])) ? $_GET['projet'] : null;
$projet = Projets::getByUniqid($uniqidprojet);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Constructeur de Framework CSS</title>
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
                <img src="<?= BASEURL; ?>assets/images/tec.png" class="logo" />
            </div>
            <div class="navbar-content__middle"></div>
            <div class="navbar-content__right"></div>
        </div>
    </nav>
    <div class="main">
        <div class="left">
            <div class="sticky">
                <p>
                    <span class="material-icons-outlined composants">palette</span>
                    Composants
                </p>
                <ul>
                    <li><a href="<?= BASEURL.$uniqidprojet; ?>/alerts">Alerts</a></li>
                    <li><a href="<?= BASEURL.$uniqidprojet; ?>/buttons">Buttons</a></li>
                    <li><a href="<?= BASEURL.$uniqidprojet; ?>/colors">Colors</a></li>
                    <li><a href="<?= BASEURL.$uniqidprojet; ?>/typography">Typography</a></li>
                </ul>
                <p>
                    <span class="material-icons-outlined resultats">task_alt</span>
                    Résultats
                </p>
                <ul>
                    <li><a href="#">Exporter les fichiers</a></li>
                    <li><a href="#">Documentation</a></li>
                    <li><a href="#">Design System</a></li>
                </ul>
            </div>
        </div>
        <div class="middle">
            <?php
            $component = isset($_GET['component']) ? $_GET['component'] : null;
            if ($component != null)
                include 'components/'.$component.'.php';
            ?>
        </div>
        <div class="right"></div>
        <div class="toast">
            <div class="toast-header">
                <div class="toast-header__type"></div>
                <div class="toast-header__title"></div>
            </div>
            <div class="toast-body"></div>
        </div>
    </div>
    <script src="<?= BASEURL; ?>assets/js/component.js"></script>
    <script>
        function getWindowSizes()
        {
            var windowWidth = $(window).width()
            var leftWidth = (windowWidth * 20) / 100

            if ($('.main').hasClass('right-opened'))
                var middleWidth = windowWidth - (leftWidth * 2)
            else
                var middleWidth = windowWidth - leftWidth

            $('.left').css('flexBasis', leftWidth + 'px')
            $('.right').css('width', leftWidth + 'px')
            $('.right').css('transform', `translateX(${leftWidth}px)`)
            $('.middle').css('flexBasis', middleWidth + 'px')
        }
        $(document).ready(getWindowSizes)
        $(window).resize(getWindowSizes)
    </script>
</body>
</html>