<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\models\Producto;
use app\models\Categoria;
/* @var $this yii\web\View */
/* @var $model app\models\Producto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="producto-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'stock')->textInput() ?>

    <?= $form->field($model, 'detalle')->textarea(['maxlength' => true]) ?>

    <?= $form->field($model, 'activo')->checkBox(['label' => '¿Producto en Catalogo?', 'uncheck' => '0', 'checked' => '1']) ?>

    <?= $form->field($model, 'categoria')->dropDownList(
                                                ArrayHelper::map(Categoria::find()->all(),'id','nombre'),
                                                ['prompt'=>'Seleccionar Categoria']
                                            ) ?>

    <?= //$form->field($model, 'upload')->fileInput();
        $form->field($model, 'imagen')->textInput(); 
    ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
