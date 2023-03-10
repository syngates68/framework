<?php
require_once('../config/sqlconnect.inc.php');
require_once('../model/Model.php');
require_once('../model/Components.php');
require_once('../model/Projets.php');
require_once('../model/Regles.php');

//On initialise le lien avec la BDD pour les modèles
Model::set_db($bdd);

$id_component = $_POST['component'];
$component = Components::getById($id_component);
$projet = Projets::getById($component->id_projet());
$rules = Regles::getByIdComponent($id_component);
$arr = [];
if ($rules != null)
{
    for ($i = 0; $i < sizeof($rules); $i++)
    {
        $arr[$rules[$i]->regle()] = $rules[$i]->valeur();
    }
}
?>
<div class="right-container">
    <div class="group">
        <h3>Nom de la classe</h3>
        <div class="input-group">
            <input type="text" id="classname" class="classname" value="<?= $component->classname(); ?>">
        </div>
    </div>
    <div>
        <input type="hidden" name="component" value="<?= $id_component; ?>">
        <input type="hidden" name="projet" value="<?= $projet->uniqid(); ?>">
        <div class="group">
            <h3>Apparence</h3>
            <div class="input-group">
                <label>Couleur de fond</label>
                <input type="text" data-rule="background-color" id="background" class="csselement" value="<?= isset($arr['background-color']) ? $arr['background-color'] : '#FFFFFF'; ?>" data-color-picker>
            </div>
            <div class="input-group">
                <label>Couleur du texte</label>
                <input type="text" data-rule="color" id="color" class="csselement" style="display: none;" value="<?= isset($arr['color']) ? $arr['color'] : '#FFFFFF'; ?>" data-color-picker>
            </div>
            <?php if ($component->main() == 1) : ?>
                <div class="input-group">
                    <label>Taille du texte</label>
                    <input type="number" data-rule="font-size" class="csselement" data-unite="px" value="<?= isset($arr['font-size']) ? $arr['font-size'] : 13; ?>">
                </div>
                <div class="input-group">
                    <label>Epaisseur du texte</label>
                    <select class="csselement" data-rule="font-weight">
                        <option></option>
                        <option value="100" <?php if (isset($arr['font-weight']) && $arr['font-weight'] == "100") : ?>selected<?php endif; ?>>100</option>
                        <option value="200" <?php if (isset($arr['font-weight']) && $arr['font-weight'] == "200") : ?>selected<?php endif; ?>>200</option>
                        <option value="300" <?php if (isset($arr['font-weight']) && $arr['font-weight'] == "300") : ?>selected<?php endif; ?>>300</option>
                        <option value="400" <?php if (isset($arr['font-weight']) && $arr['font-weight'] == "400") : ?>selected<?php endif; ?>>400</option>
                        <option value="500" <?php if (isset($arr['font-weight']) && $arr['font-weight'] == "500") : ?>selected<?php endif; ?>>500</option>
                        <option value="600" <?php if (isset($arr['font-weight']) && $arr['font-weight'] == "600") : ?>selected<?php endif; ?>>600</option>
                        <option value="700" <?php if (isset($arr['font-weight']) && $arr['font-weight'] == "700") : ?>selected<?php endif; ?>>700</option>
                        <option value="800" <?php if (isset($arr['font-weight']) && $arr['font-weight'] == "800") : ?>selected<?php endif; ?>>800</option>
                        <option value="900" <?php if (isset($arr['font-weight']) && $arr['font-weight'] == "900") : ?>selected<?php endif; ?>>900</option>
                    </select>
                </div>
                <div class="input-group">
                    <label>Police d'écriture</label>
                    <select class="csselement" data-rule="font-family">
                        <option></option>
                        <option value="'Inter', sans-serif" <?php if (isset($arr['font-family']) && $arr['font-family'] == "'Inter', sans-serif") : ?>selected<?php endif; ?>>Inter</option>
                        <option value="'Lato', sans-serif" <?php if (isset($arr['font-family']) && $arr['font-family'] == "'Lato', sans-serif") : ?>selected<?php endif; ?>>Lato</option>
                        <option value="'Montserrat', sans-serif" <?php if (isset($arr['font-family']) && $arr['font-family'] == "'Montserrat', sans-serif") : ?>selected<?php endif; ?>>Montserrat</option>
                        <option value="'Roboto', sans-serif" <?php if (isset($arr['font-family']) && $arr['font-family'] == "'Roboto', sans-serif") : ?>selected<?php endif; ?>>Roboto</option>
                        <option value="'Source Sans Pro', sans-serif" <?php if (isset($arr['font-family']) && $arr['font-family'] == "'Source Sans Pro', sans-serif") : ?>selected<?php endif; ?>>Source Sans Pro</option>
                        <option value="'Open Sans', sans-serif" <?php if (isset($arr['font-family']) && $arr['font-family'] == "'Open Sans', sans-serif") : ?>selected<?php endif; ?>>Open Sans</option>
                    </select>
                </div>
            <?php endif; ?>
        </div>
        <div class="group">	
            <h3>Bordure</h3>
            <div class="input-group">
                <label>Couleur de bordure</label>
                <input type="text" data-rule="border-color" id="border" class="csselement" style="display: none;" value="<?= isset($arr['border-color']) ? $arr['border-color'] : '#FFFFFF'; ?>" data-color-picker>
            </div>
            <?php if ($component->main() == 1) : ?>
                <div class="input-group">
                    <label>Taille de bordure</label>
                    <input type="number" data-rule="border-width" class="csselement" data-unite="px" value="<?= isset($arr['border-width']) ? $arr['border-width'] : 0; ?>">
                </div>
                <div class="input-group">
                    <label>Radius</label>
                    <input type="number" data-rule="border-radius" class="csselement" data-unite="px" value="<?= isset($arr['border-radius']) ? $arr['border-radius'] : 0; ?>">
                </div>
                <div class="input-group">
                    <label>Style</label>
                    <select class="csselement" data-rule="border-style">
                        <option></option>
                        <option value="dotted" <?php if (isset($arr['border-style']) && $arr['border-style'] == "dotted") : ?>selected<?php endif; ?>>dotted</option>
                        <option value="dashed" <?php if (isset($arr['border-style']) && $arr['border-style'] == "dashed") : ?>selected<?php endif; ?>>dashed</option>
                        <option value="solid" <?php if (isset($arr['border-style']) && $arr['border-style'] == "solid") : ?>selected<?php endif; ?>>solid</option>
                        <option value="double" <?php if (isset($arr['border-style']) && $arr['border-style'] == "double") : ?>selected<?php endif; ?>>double</option>
                        <option value="groove" <?php if (isset($arr['border-style']) && $arr['border-style'] == "groove") : ?>selected<?php endif; ?>>groove</option>
                        <option value="ridge" <?php if (isset($arr['border-style']) && $arr['border-style'] == "ridge") : ?>selected<?php endif; ?>>ridge</option>
                        <option value="inset" <?php if (isset($arr['border-style']) && $arr['border-style'] == "inset") : ?>selected<?php endif; ?>>inset</option>
                        <option value="outset" <?php if (isset($arr['border-style']) && $arr['border-style'] == "outset") : ?>selected<?php endif; ?>>outset</option>
                        <option value="none" <?php if (isset($arr['border-style']) && $arr['border-style'] == "none") : ?>selected<?php endif; ?>>none</option>
                        <option value="hidden" <?php if (isset($arr['border-style']) && $arr['border-style'] == "hidden") : ?>selected<?php endif; ?>>hidden</option>
                    </select>
                </div>
            <?php endif; ?>
        </div>
        <?php if ($component->main() == 1) : ?>
            <div class="group">
                <h3>Padding</h3>
                <div class="input-group">
                    <label>Padding Gauche</label>
                    <input type="number" data-rule="padding-left" class="csselement" data-unite="px" value="<?= isset($arr['padding-left']) ? $arr['padding-left'] : 0; ?>">
                </div>
                <div class="input-group">
                    <label>Padding Droite</label>
                    <input type="number" data-rule="padding-right" class="csselement" data-unite="px" value="<?= isset($arr['padding-right']) ? $arr['padding-right'] : 0; ?>">
                </div>
                <div class="input-group">
                    <label>Padding Haut</label>
                    <input type="number" data-rule="padding-top" class="csselement" data-unite="px" value="<?= isset($arr['padding-top']) ? $arr['padding-top'] : 0; ?>">
                </div>
                <div class="input-group">
                    <label>Padding Bas</label>
                    <input type="number" data-rule="padding-bottom" class="csselement" data-unite="px" value="<?= isset($arr['padding-bottom']) ? $arr['padding-bottom'] : 0; ?>">
                </div>
            </div>
            <div class="group">
                <?php
                $shadow = [0, 0, 0, 0, '#000000'];
                if (isset($arr['box-shadow']))
                {
                    $exp = explode(' ', $arr['box-shadow']);
                    $shadow[0] = str_replace('px', '', $exp[0]);
                    $shadow[1] = str_replace('px', '', $exp[1]);
                    $shadow[2] = str_replace('px', '', $exp[2]);
                    $shadow[3] = str_replace('px', '', $exp[3]);
                    $shadow[4] = $exp[4];
                }
                ?>
                <h3>Ombrage</h3>
                <div class="input-group">
                    <label>Décalage à droite</label>
                    <input type="number" data-rule="box-shadow-x" class="csselement box-shadow-<?= $id_component; ?>" data-unite="px" id="" value="<?= $shadow[0]; ?>">
                </div>
                <div class="input-group">
                    <label>Décalage en bas</label>
                    <input type="number" data-rule="box-shadow-y" class="csselement box-shadow-<?= $id_component; ?>" data-unite="px" id="" value="<?= $shadow[1]; ?>">
                </div>
                <div class="input-group">
                    <label>Propagation</label>
                    <input type="number" data-rule="box-shadow-spread" class="csselement box-shadow-<?= $id_component; ?>" data-unite="px" id="" value="<?= $shadow[2]; ?>">
                </div>
                <div class="input-group">
                    <label>Flou</label>
                    <input type="number" data-rule="box-shadow-blur" class="csselement box-shadow-<?= $id_component; ?>" data-unite="px" value="<?= $shadow[3]; ?>">
                </div>
                <div class="input-group">
                    <label>Couleur</label>
                    <input type="text" data-rule="box-shadow-color" id="box-shadow-<?= $id_component; ?>" class="csselement box-shadow-<?= $id_component; ?>" style="display: none;" value="<?= $shadow[4]; ?>" data-color-picker>
                </div>
            </div>
        <?php endif; ?>
        <button class="btn primary btn-ajouter-regle">
            Ajouter une règle
            <span class="material-icons">
                playlist_add
            </span>
        </button>
    </div>
</div>