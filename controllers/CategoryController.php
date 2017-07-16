<?php

namespace app\controllers;

use Yii;
use app\models\Category;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller {
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        return $this->render('index', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    
    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new Category();
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    /**
     * Deletes an existing Category model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();
        
        return $this->redirect(['index']);
    }
    
    public function actionGetChilds() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $categories = Category::find()
                ->select(['id', 'name', 'parent_id'])
                ->where(['parent_id' => $data['id']])
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->all();
            if (!empty($categories)) {
                $ids = array_column($categories, 'id');
                $childs = Category::find()
                    ->select(['id', 'name', 'parent_id'])
                    ->where(['in', 'parent_id' , $ids])
                    ->orderBy(['parent_id' => SORT_ASC, 'name' => SORT_ASC])
                    ->asArray()
                    ->all();
                if (!empty($childs)) {
                    $count = count($childs);
                    $i = 0;
                    foreach ($categories as $key => $category) {
                        while ($i < $count) {
                            if ($childs[$i]['parent_id'] == $category['id']) {
                                if (!isset($categories[$key]['childs']))
                                    $categories[$key]['childs'] = [];
                                $categories[$key]['childs'][] = $childs[$i];
                                $i++;
                            } else {
                                break;
                            }
                        }
                    }
                }
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'categories' => $categories,
                ];
            }
            return false;
        }
    }
    
    /**
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
