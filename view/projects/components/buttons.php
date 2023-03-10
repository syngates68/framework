<h1>Constructeur de bouton</h1>
<div class="explanation">
    Un framework CSS est généralement composé de <B>6 boutons distincts</B> :
    <ul>
        <li>Un bouton primaire</li>
        <li>Un bouton secondaire</li>
        <li>Un bouton de succès</li>
        <li>Un bouton de danger</li>
        <li>Un bouton d'alerte</li>
        <li>Un bouton d'information</li>
    </ul>
    Lors de la création de votre projet, chacun de ces boutons est automatiquement crée. Vous avez la possibilité de les supprimer en cliquant sur <B>l'icône correspondante</B> à côté
    de l'intitulé du bouton.<br/>
    Afin de vous permettre de définir un style partagé par tous vos boutons (<B>padding, width, height, font-family etc...</B>), vous pouvez renseigner l'élément <B>Bouton par défaut</B>.
</div>
<div class="actions">
    <button class="btn primary">Ajouter un bouton</button>
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
        <button class="<?= str_replace('.', '', $classnameWithSpace); ?>" id="elmt-<?= $c->id(); ?>" <?php if ($c->main() == 1) : ?>data-main="1"<?php endif; ?>>Bouton</button>
    </div>
<?php
    endforeach;
?>