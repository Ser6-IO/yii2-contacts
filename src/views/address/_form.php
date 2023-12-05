<?php

use yii\bootstrap5\Html;
use ser6io\yii2bs5widgets\ActiveForm;
use ser6io\yii2contacts\models\Address;
use ser6io\yii2contacts\models\Country;

/** @var yii\web\View $this */
/** @var ser6io\yii2contacts\models\Address $model */
/** @var yii\widgets\ActiveForm $form */

$this->registerJsVar('usStates', \ser6io\yii2contacts\models\UsState::CODE_NAME);
$this->registerJsVar('canadaProvinces', \ser6io\yii2contacts\models\CanadaProvince::CODE_NAME);

?>

<script>
// register a JS function for changing the state input into a select when the country is US or CA
function handleCountryState(modelName) {

    //set the formlName as modelName from camel case to snake case
    const modelFormName = modelName.replace(/([a-z])([A-Z])/g, '$1-$2').toLowerCase();
    const countryInput = modelFormName + '-country';
    const stateInput = modelFormName + '-state';
    const stateInputName = modelName + '[state]';

    const currentState = $(`#${stateInput}`).val();

    function toggleStateInput() {
        var country = $(`#${countryInput}`).val();
        if (country == 'US' || country == 'CA') {
            $(`#${stateInput}`).replaceWith(`<select id="${stateInput}" class="form-select" name="${stateInputName}" aria-required="true" aria-invalid="false"><option value="">Select State</option></select>`);
            
            const states = (country == 'US') ? usStates : canadaProvinces;
            for (var i = 0; i < states.length; i++) {
                $(`#${stateInput}`).append('<option value="' + Object.keys(states[i])[0] + '">' + Object.values(states[i])[0] + '</option>');
            }

            $(`#${stateInput}`).val(currentState).change();
        } else {
            $(`#${stateInput}`).replaceWith(`<input type="text" id="${stateInput}" class="form-control" name="${stateInputName}" aria-required="true" aria-invalid="false">`);
        }
    }
    $(`#${countryInput}`).change(function() {
        toggleStateInput();
    });
    toggleStateInput();
}
</script>
<?php 
    $modelName = (new \ReflectionClass($model))->getShortName();;
    $this->registerJs("handleCountryState('$modelName')");
?>


<?php $form = ActiveForm::begin(); ?>

<?= Html::activeHiddenInput($model, 'contact_id') ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'type')->dropDownList(Address::ADDRESS_TYPE) ?>
    </div>
    <div class="col-md-6">
        <?= $form->field($model, 'country')->dropDownList(Country::CODE_NAME) ?>
    </div>
</div>

<?= $form->field($model, 'line_1')->textInput(['maxlength' => true]) ?>

<?= $form->field($model, 'line_2')->textInput(['maxlength' => true]) ?>

<div class="row">
    <div class="col-md-6">
        <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'state')->textInput(['maxlength' => true]) ?>
    </div>
    <div class="col-md-3">
        <?= $form->field($model, 'zip')->textInput(['maxlength' => true]) ?>
    </div>
</div>

<div class="form-group">
    <?= Html::submitButton('<i class="bi bi-check-circle"></i> Save', ['class' => 'btn btn-success  mt-3']) ?>
</div>

<?php ActiveForm::end(); ?>
