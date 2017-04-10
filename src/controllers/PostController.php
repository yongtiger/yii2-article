<?php ///[Yii2 article]

/**
 * Yii2 article
 *
 * @link        http://www.brainbook.cc
 * @see         https://github.com/yongtiger/yii2-article
 * @author      Tiger Yong <tigeryang.brainbook@outlook.com>
 * @copyright   Copyright (c) 2017 BrainBook.CC
 * @license     http://opensource.org/licenses/MIT
 */

namespace yongtiger\article\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\StringHelper;
use yongtiger\article\models\Post;
use yongtiger\article\models\PostSearch;
use yongtiger\article\models\Content;

/**
 * PostController implements the CRUD actions for Post model.
 *
 * @package yongtiger\article\controllers
 */
class PostController extends Controller
{
    /**
     * @inheritdoc
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
     * Lists all Post models.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Post model.
     *
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'postModel' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Post model and its corresponding Content model.
     *
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @see http://www.yiiframework.com/doc-2.0/guide-input-multiple-models.html
     * @return mixed
     */
    public function actionCreate()
    {
        $postModel = new Post();
        $contentModel = new Content();

        if ($this->saveAll($postModel, $contentModel)) {
            return $this->redirect(['view', 'id' => $postModel->id]);
        }
        
        return $this->render('create', [
            'postModel' => $postModel,
            'contentModel' => $contentModel,
        ]);
    }

    /**
     * Updates an existing Post model and its corresponding Content model.
     *
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @see http://www.yiiframework.com/doc-2.0/guide-input-multiple-models.html
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the Content model cannot be found
     */
    public function actionUpdate($id)
    {
        $postModel = $this->findModel($id);
        $contentModel = Content::findOne($postModel->content_id);
        if (!isset($contentModel)) {
            throw new NotFoundHttpException("The content was not found.");
        }

        if ($this->saveAll($postModel, $contentModel)) {
            return $this->redirect(['view', 'id' => $id]);
        }
        
        return $this->render('update', [
            'postModel' => $postModel,
            'contentModel' => $contentModel,
        ]);
    }

    /**
     * Deletes an existing Post model and its corresponding Content model.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the Content model cannot be found
     * @throws Exception if the Post model or its corresponding Content model cannot be deleted.
     */
    public function actionDelete($id)
    {
        $postModel = $this->findModel($id);
        $contentModel = Content::findOne($postModel->content_id);
        if (!isset($contentModel)) {
            throw new NotFoundHttpException("The content was not found.");
        }

        ///@see http://www.yiiframework.com/doc-2.0/guide-db-dao.html#performing-transactions
        $transaction = Yii::$app->db->beginTransaction();
        try {
            $postModel->delete();
            $contentModel->delete();
            $transaction->commit();
        } catch(\Exception $e) {
            $transaction->rollBack();
            throw $e;
        } catch(\Throwable $e) {
            $transaction->rollBack();
            throw $e;
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the Post model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Saves or updates a Post model and its corresponding Content model.
     *
     * @see http://www.yiiframework.com/doc-2.0/guide-input-multiple-models.html
     * @return bool
     * @throws Exception if the Post model or its corresponding Content model cannot be saved.
     */
    protected function saveAll($postModel, $contentModel)
    {
        $post = Yii::$app->request->post();
        if ($postModel->load($post) && $contentModel->load($post) && $postModel->validate() && $contentModel->validate()) {

            ///@see http://www.yiiframework.com/doc-2.0/guide-db-dao.html#performing-transactions
            $transaction = Yii::$app->db->beginTransaction();
            try {
                $contentModel->save(false);
                $postModel->content_id = $contentModel->id;
                if (empty($postModel->summary)) {
                    $postModel->summary = $this->getSummary($contentModel->body);
                }
                $postModel->save(false);
                $transaction->commit();
                return true;
            } catch(\Exception $e) {
                $transaction->rollBack();
                throw $e;
            } catch(\Throwable $e) {
                $transaction->rollBack();
                throw $e;
            }

        }
        return false;
    }
    
    /**
     * Gets summary.
     *
     * @param string $string
     * @param string $length
     * @return string
     */
    public function getSummary($string, $length = 250)
    {
        $string = strip_tags($string);
        $string = str_replace('&nbsp;', '', $string);
        $string = preg_replace('/(\s+)/u', '', $string);
        return StringHelper::truncate($string, $length);
    }
}
