<?php ///[yii2-article]

/**
 * Yii2 article
 *
 * @link        http://www.brainbook.cc
 * @see         https://github.com/yongtiger/yii2-article
 * @author      Tiger Yong <tigeryang.brainbook@outlook.com>
 * @copyright   Copyright (c) 2017 BrainBook.CC
 * @license     http://opensource.org/licenses/MIT
 */

namespace yongtiger\article;

use Yii;

/**
 * Class Module
 *
 * @package yongtiger\article
 */
class Module extends \yii\base\Module
{
    /**
     * @var string module name
     */
    public static $moduleName = 'article';

    /**
     * @inheritdoc
     */
    public $defaultRoute = 'post';

    ///[v0.3.2 (#ADD category layout)]
    /**
     * @inheritdoc
     */
    public $layout = '@app/views/layouts/main.php';
    
    ///[v0.3.3 (#ADD categoryModelClass)]
    /**
     * @var string the category model class name
     */
    public $categoryModelClass = 'yongtiger\category\models\Category';

    ///[v0.3.4 (#ADD generateCategoryCallback, displayCategoryCallback)]
    /**
     * @var callable
     */
    public $generateCategoryCallback;
    /**
     * @var callable
     */
    public $displayCategoryCallback;

    ///[v0.3.5 (#ADD displayCommentCallback)]
    /**
     * @var callable
     */
    public $displayCommentCallback;

    /**
     * @var callable
     */
    public $editorCallback;

    /**
     * @return static
     */
    public static function instance()
    {
        return Yii::$app->getModule(static::$moduleName);
    }

    /**
     * Registers the translation files.
     */
    public static function registerTranslations()
    {
        ///[i18n]
        ///if no setup the component i18n, use setup in this module.
        if (!isset(Yii::$app->i18n->translations['extensions/yongtiger/yii2-article/*']) && !isset(Yii::$app->i18n->translations['extensions/yongtiger/yii2-article'])) {
            Yii::$app->i18n->translations['extensions/yongtiger/yii2-article/*'] = [
                'class' => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en-US',
                'basePath' => '@vendor/yongtiger/yii2-article/src/messages',
                'fileMap' => [
                    'extensions/yongtiger/yii2-article/message' => 'message.php',  ///category in Module::t() is message
                ],
            ];
        }
    }

    /**
     * Translates a message. This is just a wrapper of Yii::t().
     *
     * @see http://www.yiiframework.com/doc-2.0/yii-baseyii.html#t()-detail
     *
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($category, $message, $params = [], $language = null)
    {
        static::registerTranslations();
        return Yii::t('extensions/yongtiger/yii2-article/' . $category, $message, $params, $language);
    }
}
