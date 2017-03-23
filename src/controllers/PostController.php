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
use yongtiger\article\models\Post;
use yongtiger\article\models\PostSearch;
use yongtiger\article\models\Content;
use yongtiger\article\models\Comment;
use yongtiger\article\models\CommentSearch;

/**
 * PostController implements the CRUD actions for Post model.
 *
 * @package yongtiger\article\controllers
 */
class PostController extends Controller
{
    ///[yii2-brainblog_v0.5.0_f0.4.5_rich_text_ueditor]
    public function actions()
    {
        return [
            'upload' => [
                'class' => 'kucha\ueditor\UEditorAction',
                'config' => [
                    //"imageUrlPrefix"  => "http://www.baidu.com",//图片访问路径前缀
                    "imagePathFormat" => "/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}", //上传保存路径
                    "imageRoot" => Yii::getAlias("@webroot"),
                ],
            ]
        ];
    }
    ///[http://www.brainbook.cc]

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
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        ///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]显示评论列表
        $comment_searchModel = new CommentSearch();
        $comment_dataProvider = $comment_searchModel->search(Yii::$app->request->queryParams);
        $comment_dataProvider->pagination->pageSize = 10;

        ///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]Pjax发表评论
        $comment_model = new Comment();
        if ($comment_model->load(Yii::$app->request->post()) && $comment_model->save()) {
            $comment_model = new Comment();    ///Pjax后重置$comment_model为new！@see http://www.yiiframework.com/wiki/772/pjax-on-activeform-and-gridview-yii2/
        }
        ///[http://www.brainbook.cc]

        return $this->render('view', [
            'post_model' => $this->findModel($id),  ///[yii2-brainblog_v0.5.1_f0.5.0_post_content_multiple_model]
            'comment_model' => $comment_model,  ///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]Pjax发表评论

            ///[yii2-brainblog_v0.10.0_f0.9.3_post_comment]显示评论列表
            'comment_searchModel' => $comment_searchModel,
            'comment_dataProvider' => $comment_dataProvider,
            ///[http://www.brainbook.cc]
        ]);

    }

    ///[yii2-brainblog_v0.5.1_f0.5.0_post_content_multiple_model]
    /**
     * Creates a new Post model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $post_model = new Post();
        $content_model = new Content();

        $request = Yii::$app->request;
        if ($request->isPost){

            $post = $request->post();

            if ($content_model->load($post) && $content_model->save()) {

                $post['Post']['content_id'] = $content_model->id;

                if ($post_model->load($post) && $post_model->save()) {
                    return $this->redirect(['view', 'id' => $post_model->id]);
                }
            }

        }

        return $this->render('create', [
            'post_model' => $post_model,
            'content_model' => $content_model,
        ]);

    }

    /**
     * Updates an existing Post model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $post_model = $this->findModel($id);
        $content_model = Content::findOne($post_model->content_id);

        if (!isset($post_model, $content_model)) {
            throw new NotFoundHttpException("The post was not found.");
        }

        $request = Yii::$app->request;
        if ($request->isPost){

            $post = $request->post();

            if ($content_model->load($post) && $content_model->save()) {

                if ($post_model->load($post) && $post_model->save()) {
                    return $this->redirect(['view', 'id' => $post_model->id]);
                }
            }

        }

        return $this->render('update', [
            'post_model' => $post_model,
            'content_model' => $content_model,
        ]);

    }

    /**
     * Deletes an existing Post model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        ///[yii2-brainblog_v0.9.3_f0.9.2_post_attachment_AttachableBehavior]
        $post_model = $this->findModel($id);
        $content_model = Content::findOne($post_model->content_id);
        $post_model->delete();
        $content_model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Post the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
