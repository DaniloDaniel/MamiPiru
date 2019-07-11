<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\controllers\CatalogoclController;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Catalogo');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogocl-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
                'nombre',
                'imagen',
                'stock',
                [
                    'class' => 'kartik\grid\DataColumn',
                    'pageSummary' => true,
                    'label' => 'carrito',
                    'value' => function ($model){              
                        if(CatalogoclController::actionProductoEnCarrito($model->id)){
                            return Html::button('En el Carrito', ['disabled' => true, 'class' => 'btn btn-success']);
                        }
                        else{                    
                            return Html::a(
                                'Agregar', ['cookie', 'id' => $model->id, 'nombre' => $model->nombre, 'stock' => $model->stock], ['class' => 'btn btn-primary'], 
                            );                      
                        }
                    },
                    'vAlign'=>'middle',
                    'hAlign'=>'center',
                    'format'=>'raw',
                    'width'=>'50px',
                    'noWrap'=>true
                ],
            ['class' => 'yii\grid\ActionColumn', 'template' => "{view}"],
        ],
        'resizableColumns'=>true,
        'containerOptions' => ['style'=>'overflow: auto'], // only set when $responsive = false
        'toolbar' =>  [
            [

            ],
            '{toggleData}'
        ],
        'pjax' => true,
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'floatHeader' => true,
        'floatHeaderOptions' => ['scrollingTop'=>'50'],                    
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Productos',
        ],
    ]); ?>


</div>
