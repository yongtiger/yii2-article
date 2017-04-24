<?php ///[v0.3.2 (#ADD category layout)]

/* @var $this yii\web\View */
/* @var $category $this->params['category'] */
/* @var $categoryId $category['categoryId'] */
/* @var $menuItems $category['menuItems'] */

$category = $this->params['category'];
$categoryId = $category['categoryId'];
$menuItems = $category['menuItems'];

$this->beginContent('@app/views/layouts/main.php'); ?>

<div class="col-sm-3">

    <?php ///[v0.3.0 (#ADD category)]
        // // echo \yii\widgets\Menu::widget([
        // // echo \yii\jui\Menu::widget([
        // // echo \yii\bootstrap\Nav::widget([
        // echo \yongtiger\listgroupmenu\widgets\ListGroupMenu::widget([
        //     // 'tag' => 'div',
        //     'items' => $menuItems,
        //     // 'options' => ['id' => 'yii2doc'],   // optional
        //     'activateParents' => true,  // optional
        // ]);

        echo \yongtiger\bootstraptree\widgets\BootstrapTree::widget([
            'options'=>[
                //https://github.com/jonmiles/bootstrap-treeview#options
                'data' => $menuItems,   ///(needed!)
                'enableLinks' => true,  ///(optional)
                'showTags' => true, ///(optional)
                'levels' => 3,  ///(optional)
                // 'multiSelect' => true,  ///(optional, but when `selectParents` is true, you must also set this to true!)
            ],
            // 'htmlOptions' => [  ///(optional)
            //     'id' => 'treeview-tabs',
            // ],
            // 'events'=>[ ///(optional)
            //     //https://github.com/jonmiles/bootstrap-treeview#events
            //     'onNodeSelected'=>'function(event, data) {
            //         // Your logic goes here
            //         alert(data.text);
            //     }'
            // ],

            ///(needed for using jonmiles bootstrap-treeview 2.0.0, must specify it as `<a href="{href}">{text}</a>`)
            // 'textTemplate' => '<a href="{href}">{text}</a>',

            ///(optional) Note: when it is true, you must also set `multiSelect` of the treeview widget options to true!
            // 'selectParents' => true,
        ]); 
        ///[http://www.brainbook.cc]
    ?>

</div>
<div class="col-sm-9">

	<?= $content ?>

</div>

<?php $this->endContent(); ?>