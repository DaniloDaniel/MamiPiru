<?php

namespace app\controllers;

use Yii;
use app\models\Producto;
use app\models\ProductoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter; 
use yii\data\ArrayDataProvider;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\web\Session;
use app\models\CotizacionForm;
/**
 * ProductoController implements the CRUD actions for Producto model.
 */
class CatalogoclController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Lists all Producto models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Producto model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Producto model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Producto the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Producto::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function actionCookie($id, $nombre, $stock){
        
        $session = Yii::$app->session;
        $session->open();

        $carrito = $session['carrito'];
        $carrito[$id]['id'] = $id;
        $carrito[$id]['nombre'] = $nombre;
        $carrito[$id]['stock'] = $stock;
        $carrito[$id]['cantidad'] = 1;
        $session['carrito'] = $carrito;

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionProductoEnCarrito($id){
        
        $session = Yii::$app->session;

        if(isset($session['carrito'][$id])){
            $carrito = $session['carrito'][$id]['id'];
            if($carrito == $id){
                return TRUE; 
            }
            else{
                return FALSE;
            }
        } 
 
        return false;
    }

    public function actionCarrito()
    {
        $session = Yii::$app->session;
        $carrito = $session['carrito'];

        $provider = new ArrayDataProvider([
            'allModels' => $carrito,
            'sort' => [
                'attributes' => ['id', 'cantidad'],
            ],
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        return $this->render('carrito', [
            'dataProvider' => $provider,
        ]);
    }

    public function actionAgregar($id){
        $session = Yii::$app->session;

        $carrito = $session['carrito'];
        $carrito[$id]['cantidad'] = $carrito[$id]['cantidad'] + 1;
        $session['carrito'] = $carrito;

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionQuitar($id){
        $session = Yii::$app->session;

        $carrito = $session['carrito'];
        $carrito[$id]['cantidad'] = $carrito[$id]['cantidad'] - 1;
        $session['carrito'] = $carrito;

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionEliminar($id){
        $session = Yii::$app->session;

        $carrito = $session['carrito'];
        unset($carrito[$id]);
        $session['carrito'] = $carrito;

        return $this->redirect(Yii::$app->request->referrer);
    }

    public function actionCotizar()
    {
        $model = new CotizacionForm();
        if ($model->load(Yii::$app->request->post()) && $model->cotizacion(Yii::$app->params['adminEmail'])) {
            $session = Yii::$app->session;
            $session->destroy();
            Yii::$app->session->setFlash('mensajeok');
            return $this->refresh();
        }
        return $this->render('cotizacion', [
            'model' => $model,
        ]);
    }

}