<?php

namespace app\controllers;

use app\models\Geo;
use app\models\NestingHasGeo;
use app\models\UploadForm;
use Yii;
use app\models\Nesting;
use app\models\NestingSearch;
use app\models\Model;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm;

/**
 * NestingController implements the CRUD actions for Nesting model.
 */
class NestingController extends Controller
{
    /**
     *sudo ln -s /opt/phpstorm/bin/phpstorm.sh /usr/local/bin/phpstorm @inheritdoc
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

    /**
     * Lists all Nesting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NestingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $uploadModel = new UploadForm();
    
        if (Yii::$app->request->isPost) {
            $uploadModel->jobFile = UploadedFile::getInstance($uploadModel, 'jobFile');
            if ($uploadModel->upload()) {
                $uploadModel->parseJob();
                if ($nesting = Yii::$app->session->get('nesting')) {
                    if ($result = Nesting::findOne(['name' => $nesting->name])) {
                        return $this->redirect('nesting/update', ['id' => $result->id]);
                    }
                    return $this->redirect('nesting/create');
                }
            }
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'uploadModel' => $uploadModel,
        ]);
    }

    /**
     * Displays a single Nesting model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Nesting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Nesting();
        $modelsGeos = [new NestingHasGeo()];
        if ($model->load(Yii::$app->request->post())) {
        
            $modelsGeos = Model::createMultiple(NestingHasGeo::classname());
            Model::loadMultiple($modelsGeos, Yii::$app->request->post());
        
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsGeos),
                    ActiveForm::validate($model)
                );
            }
        
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsGeos) && $valid;
        
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($modelsGeos as $item) {
                            $item->nesting_id = $model->id;
                            if (! ($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
    
        return $this->render('create', [
            'model' => $model,
            'modelsGeos' => (empty($modelsGeos)) ? [new NestingHasGeo()] : $modelsGeos
        ]);
    }

    /**
     * Updates an existing Nesting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $modelsGeos = $model->nestingHasGeos;

        if ($model->load(Yii::$app->request->post())) {
    
            $oldIDs = ArrayHelper::map($modelsGeos, 'id', 'id');
            $modelsGeos = Model::createMultiple(NestingHasGeo::classname(), $modelsGeos);
            Model::loadMultiple($modelsGeos, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($modelsGeos, 'id', 'id')));
    
            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($modelsGeos),
                    ActiveForm::validate($model)
                );
            }
            
            $valid = $model->validate();
            $valid = Model::validateMultiple($modelsGeos) && $valid;
    
            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        if (!empty($deletedIDs)) {
                            NestingHasGeo::deleteAll(['id' => $deletedIDs]);
                        }
                        foreach ($modelsGeos as $item) {
                            $item->nesting_id = $model->id;
                            if (! ($flag = $item->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['view', 'id' => $model->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }
        return $this->render('update', [
            'model' => $model,
            'modelsGeos' => (empty($modelsGeos)) ? [new NestingHasGeo()] : $modelsGeos,
        ]);
    }

    /**
     * Deletes an existing Nesting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Nesting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Nesting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Nesting::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
