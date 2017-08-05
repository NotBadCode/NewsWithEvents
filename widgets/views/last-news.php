<?php


/* @var $this yii\web\View
 * @var $news \app\models\News[]
 */
?>

<?php foreach ($news as $newsItem): ?>
    <div>
        <h3>
            <?= $newsItem->title ?>
        </h3>
        <div>
            <?= $newsItem->short_text ?>
        </div>
    </div>
<?php endforeach; ?>