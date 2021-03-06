# Development roadmap

## v0.4.6 (FIX# breadcrumbs, title)

* `\views\post\*`


## v0.4.5 (ADD# category_id)

* `\views\post\_search.php`
* `\controllers\PostController.php`
Note: there is a bug on [[\yiisoft\yii2\widgets\Menu::isItemActive($item)]].


## v0.4.4 (ADD# alertClassName)

* `\views\layouts\category.php`


## v0.4.3 (ADD# PostControllerBehaviors)

* `\controllers\PostController.php`
* `\Module.php`


## v0.4.2 (ADD# access controle)

* `\controllers\PostController.php`


## v0.4.0 (move out taggble and tag)

* `\Module.php`
* `\views\post\_form.php`
* `\models\Post.php`
* `\models\PostQuery.php`


## v0.3.5 (#ADD displayCommentCallback)

* `\Module.php` (56)
* `\views\post\view.php` (70)


## v0.3.4 (#ADD generateCategoryCallback, displayCategoryCallback)

* `\Module.php` (46)
* `\views\layouts\category.php`


## v0.3.3 (#ADD categoryModelClass)

* `\Module.php` (41)
* `\models\Post.php` (95, 131)


## v0.3.2 (#ADD category layout)

* `\Module.php` (34)
* `\controllers\PostController.php`
* `\views\layouts\category.php`
* `\views\post\index.php`
* `\views\post\update.php`
* `\views\post\create.php`
* `\views\post\view.php`


## v0.3.1 (#ADD category_id)

* `\models\PostSearch.php` (69)


## v0.3.0 (#ADD category)

* `\controllers\PostController.php` (54)
* `\views\post\index.php` (54)


## v0.2.3 (i18n)


## v0.2.2 (TYPO#)

* [yongtiger/yii2-comment]
- `\views\post\view.php` (66)

* [TagsinputWidget]
- `\views\post\_form.php` (22)

* [yongtiger/yii2-taggable]
- `\models\Post.php` (74, 97, 121, 166-187)
- `\models\PostQuery.php` (25)
- `\models\PostTagAssn.php`


## v0.2.1 (remove yii2-tree, using normal nested sets catogory)


## v0.2.0 (category)


## v0.1.999 (attachable using js)


## v0.1.5 (CHG# yongtiger\attachable\behaviors\AttachableBehavior)

* `\models\Content.php` (58)


## v0.1.4 (CHG# comment sort)

* `\views\post\view.php` (81)


## v0.1.3 (ADD# yongtiger\comment\behaviors)

* `\views\post\view.php` (104)


## v0.1.2 (yongtiger/yii2-comment)


## v0.1.1 (yongtiger/yii2-comment)


## v0.1.0 (reconstruct comment)


## v0.0.10 (CHG# make validation rule handling more flexible, e.g. for behaviors)

* `\models\Content.php` (669): remove 'attachValues', 'detachValues'


## v0.0.9 (CHG# detachValues)

* `\views\post\_form.php` (134)
* `\models\Content.php` (75)


## v0.0.8 (CHG# yongtiger\attachable)

* `\models\Content.php` (60)


## v0.0.7 (ADD# UEditor_insertvideo)

* `\views\post\_form.php` (137)


## v0.0.0 (initial commit)

Features of this version:

* Sample of extensions directory structure. `src`, `docs`, etc.
* `README.md`
* `composer.json`
* `development-roadmap.md`
