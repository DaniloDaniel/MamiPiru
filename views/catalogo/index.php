<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Catalogo');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogo-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
              'label' => 'Estado',
              'value' => function($model)
              {
                return ($model->activo === 1)? 'Activo':'Inactivo';
              }
            ],
            'nombre',
            'imagen',

            ['class' => 'yii\grid\ActionColumn', 'template' => "{view}"],
        ],
    ]); ?>


</div>
