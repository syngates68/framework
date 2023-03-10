<h1>Constructeur de messages d'alertes</h1>
<div class="actions">
    <button class="btn primary">Ajouter une alerte</button>
    <button class="btn secondary set-default">Style par défaut</button>
</div>
<?php
    foreach ($components as $c) :
        $rules = Regles::getByIdComponent($c->id());
?>
    <div class="title">
        <h2><?= $c->nom(); ?></h2>
        <div class="icons">
            <span class="material-icons-outlined edit-component" data-component="<?= $c->id(); ?>" data-type="buttons" data-project="<?= $projet->uniqid(); ?>">edit_note</span>
            <span class="material-icons-outlined delete-component" data-component="<?= $c->id(); ?>">delete</span>
        </div>
    </div>
    <h3>Aperçu du résultat</h3>
    <div class="elmt-container">
        <style class="elmt-style" data-id="<?= $c->id(); ?>">
            <?php
            $classname = '.A'.$projet->uniqid().'-'.str_replace('.', '', $c->classname());
            $classnameWithSpace = $classname;

            if ($c->main() != 1)
            {
                $classname = '.A'.$projet->uniqid().'-'.str_replace('.', '', $main->classname()).'.A'.$projet->uniqid().'-'.str_replace('.', '', $c->classname());
                $classnameWithSpace = '.A'.$projet->uniqid().'-'.str_replace('.', '', $main->classname()).' .A'.$projet->uniqid().'-'.str_replace('.', '', $c->classname());
            }
            echo $classname; 
            ?>
            {
                <?php 
                    for ($i = 0; $i < sizeof($rules); $i++) :
                        echo $rules[$i]->regle().' : '.$rules[$i]->valeur();
                        if ($rules[$i]->unite() != null)
                            echo $rules[$i]->unite();
                        echo ';';
                    endfor; 
                ?>
            }
        </style>
        <alert class="<?= str_replace('.', '', $classnameWithSpace); ?>" id="elmt-<?= $c->id(); ?>" <?php if ($c->main() == 1) : ?>data-main="1"<?php endif; ?>>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Explicabo, vero quia. Soluta veniam recusandae nulla similique ad dignissimos, eum quibusdam 
            quaerat cumque tenetur dolore. Modi maxime neque rem sint vel?
        </alert>
    </div>
<?php
    endforeach;
?>