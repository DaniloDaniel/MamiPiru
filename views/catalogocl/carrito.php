<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\controllers\CatalogoclController;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ProductoSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Carrito');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalogocl-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],
            [
                'class' => 'kartik\grid\DataColumn',
                'pageSummary' => true,
                'label' => 'Producto',
                'attribute' => 'nombre',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>'raw',
                //'width'=>'50px',
                'noWrap'=>true
            ],
            [
                'class' => 'kartik\grid\DataColumn',
                'pageSummary' => true,
                'label' => 'Stock',
                'attribute' => 'stock',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>'raw',
                'width'=>'50px',
                'noWrap'=>true
            ],
            [
                'class' => 'kartik\grid\DataColumn',
                'pageSummary' => true,
                'label' => 'Cantidad',
                'attribute' => 'cantidad',
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>'raw',
                'width'=>'50px',
                'noWrap'=>true
            ],
            [
                'class' => 'kartik\grid\DataColumn',
                'pageSummary' => true,
                'label' => 'Añadir',
                'value' => function ($model){              
                    if(ArrayHelper::getValue($model, 'cantidad') == ArrayHelper::getValue($model, 'stock')){
                        return Html::button('+', ['disabled' => true, 'class' => 'btn btn-success']);
                    }
                    else{                    
                        return Html::a(
                            '+', ['agregar', 'id' => ArrayHelper::getValue($model, 'id')], ['class' => 'btn btn-success'], 
                        );                      
                    }
                },
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>'raw',
                'width'=>'50px',
                'noWrap'=>true
            ],
            [
                'class' => 'kartik\grid\DataColumn',
                'pageSummary' => true,
                'label' => 'Quitar',
                'value' => function ($model){              
                    if(ArrayHelper::getValue($model, 'cantidad') == 1){
                        return Html::button('-', ['disabled' => true, 'class' => 'btn btn-danger']);
                    }
                    else{                    
                        return Html::a(
                            '-', ['quitar', 'id' => ArrayHelper::getValue($model, 'id')], ['class' => 'btn btn-danger'], 
                        );                      
                    }
                },
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>'raw',
                'width'=>'50px',
                'noWrap'=>true
            ],
            [
                'class' => 'kartik\grid\DataColumn',
                'pageSummary' => true,
                'label' => 'Eliminar',
                'value' => function ($model){                   
                        return Html::a(
                            'eliminar', ['eliminar', 'id' => ArrayHelper::getValue($model, 'id')], ['class' => 'btn btn-warning'], 
                        );
                },
                'vAlign'=>'middle',
                'hAlign'=>'center',
                'format'=>'raw',
                'width'=>'50px',
                'noWrap'=>true
            ],
            [   'class' => 'yii\grid\ActionColumn', 
                'template' => "{view}"],
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

    <?= Html::a('Enviar Cotización', ['cotizar'], ['class' => 'btn btn-info'], ); ?>

</div>
