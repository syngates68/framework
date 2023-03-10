<div class="main">
    <div class="left">
        <div class="sticky">
            <ul>
                <li><a href="<?= BASEURL; ?>projets/<?= $uniqidprojet; ?>/">Accueil</a></li>
            </ul>
            <p>
                <span class="material-icons-outlined composants">palette</span>
                Global
            </p>
            <ul>
                <li><a href="<?= BASEURL; ?>projets/<?= $uniqidprojet; ?>/main">Principal</a></li>
            </ul>
            <p>
                <span class="material-icons-outlined composants">palette</span>
                Composants
            </p>
            <ul>
                <li><a href="<?= BASEURL; ?>projets/<?= $uniqidprojet; ?>/alerts">Alerts</a></li>
                <li><a href="<?= BASEURL; ?>projets/<?= $uniqidprojet; ?>/buttons">Buttons</a></li>
                <li><a href="<?= BASEURL; ?>projets/<?= $uniqidprojet; ?>/inputs">Inputs</a></li>
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
        <?php if ($component != null) : ?>
            <?php include 'components/'.$component.'.php'; ?>
        <?php else : ?>
            <h1>Bienvenue sur votre projet</h1>
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Suscipit ipsum iure molestias rerum vero quasi, doloribus nihil. Ratione aliquid tenetur praesentium quaerat. Nam veniam dicta sunt qui ipsam omnis esse?</p>
        <?php endif; ?>
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