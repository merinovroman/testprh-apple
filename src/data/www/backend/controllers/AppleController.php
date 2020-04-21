<?php

namespace backend\controllers;

use common\models\AppleGenerateForm;
use Yii;
use common\models\Apple;
use common\models\AppleSearch;
use yii\db\Exception;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * Class AppleController
 *
 * @package backend\controllers
 * @author Roman Merinov <merinovroman@gmail.com>
 */
class AppleController extends Controller
{

    private $apple;

    /**
     * AppleController constructor.
     * @param $id
     * @param $module
     * @param Apple $apple
     * @param array $config
     */
    function __construct(
        $id,
        $module,
        Apple $apple,
        $config = []
    )
    {
        parent::__construct($id, $module, $config);

        $this->apple = $apple;
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Список яблок
     *
     */
    public function actionIndex()
    {
        /** @var AppleSearch $searchModel */
        $searchModel = new AppleSearch();
        $appleGenerateForm = new AppleGenerateForm();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'appleGenerateForm' => $appleGenerateForm
        ]);
    }

    /**
     * Размер яблока
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionChangeSize()
    {
        if ($_POST['editableKey']) {
            $model = $this->loadApple($_POST['editableKey']);
            try {
                $model->eat($_POST['Apple'][$_POST['editableIndex']]['size']);
                $model->save();
                return Json::encode(['output' => number_format($model->size, 2)]);
            } catch (\Exception $e) {
                return Json::encode(['message' => $e->getMessage()]);
            }
        }
    }

    /**
     *
     * @param int $id
     * @return \yii\web\Response
     * @throws HttpException
     * @throws NotFoundHttpException
     */
    public function actionFallToGround(int $id)
    {
        $model = $this->loadApple($id);
        if (!$model) throw new HttpException(404, 'Apple is not exist');
        $model->status = "fall";
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Генерация яблок
     * @return \yii\web\Response
     */
    public function actionGenerate()
    {
        $model = new AppleGenerateForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            for ($i = 0; $i < $model->quantity; $i++) {
                $apple = new Apple();
                $apple->save();
            }
        }
        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return \yii\web\Response
     * @throws NotFoundHttpException
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {
        $this->loadApple($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * @param int $id
     * @return Apple
     * @throws NotFoundHttpException
     */
    protected function loadApple(int $id): Apple
    {
        if (($model = $this->apple->findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Apple not found.');
        }
    }
}
