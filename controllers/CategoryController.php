<?php

namespace app\controllers;

use app\models\Entity;
use app\models\Geo;
use app\models\Nesting;
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
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $parent = $model->parent;
            $parent->has_childs = 1;
            if ($parent->save()) {
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
            $model->addError('parent_id', 'Родительская категория не может быть сохранена');
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }
    
    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $oldParentId = $model->getOldAttribute('parent_id');
            if ($oldParentId != $model->parent_id) {
                $model->save(false);
                if (!Category::findOne(['parent_id' => $oldParentId])) {
                    $oldParent = Category::findOne(['id' => $oldParentId]);
                    $oldParent->has_childs = null;
                    $oldParent->save();
                }
                $parent = $model->parent;
                $parent->has_childs = 1;
                $parent->save();
            }
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
        $model = $this->findModel($id);
        $parent = $model->parent;
        Category::updateAll(['parent_id' => $parent->id], ['parent_id' => $model->id]);
        Entity::updateAll(['category_id' => 1], ['category_id' => $model->id]);
        $model->delete();
        if (!Category::findOne(['parent_id' => $parent->id])) {
            $parent->has_childs = null;
            $parent->save();
        }
        
        return $this->redirect(['index']);
    }
    
    public function actionGetChilds() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $categories = Category::find()
                ->select('*')
                ->where(['parent_id' => $data['id']])
                ->orderBy(['name' => SORT_ASC])
                ->asArray()
                ->all();
            if (!empty($categories)) {
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return [
                    'categories' => $categories,
                ];
            }
            return false;
        }
        return false;
    }
    
    public function actionGetParents()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if ($category = Category::findOne(['id' => $data['id']])) {
                $categories[] = $category->id;
                while(!is_null($category->parent_id)) {
                    if ($category->parent_id == $data['root']) {
                        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                        return [
                            'categories' => $categories,
                        ];
                    }
                    if ($category = Category::findOne(['id' => $category->parent_id]))
                        array_unshift($categories, $category->id);
                    else
                        return false;
                }
            }
        }
        return false;
    }
    
    public function actionGetItems() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            if ($data['id'] && $data['types']) {
                $items = [];
                if (in_array('geo', $data['types'])) {
                    $result = Geo::find()
                        ->select('*')
                        ->where(['category_id' => $data['id']])
                        ->all();
                    $items = array_merge($items, $result);
                }
                if (in_array('nesting', $data['types'])) {
                    $result = Nesting::find()
                        ->select('*')
                        ->where(['category_id' => $data['id']])
                        ->all();
                    $items = array_merge($items, $result);
                }
                usort($items, function($a, $b)
                {
                    return strcmp($a->name, $b->name);
                });
                if (!empty($items)) {
                    $view = isset($data['view']) ? $data['view'] : 'list';
                    return $this->renderPartial($view, ['items' => $items]);
//                    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//                    return [
//                        'items' => $items,
//                    ];
                }
            }
            return false;
        }
        return false;
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
