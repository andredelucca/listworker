<?php

use app\models\Task;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\widgets\ActiveForm;
use app\widgets\Alert;

/** @var yii\web\View $this */
/** @var app\models\TaskSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tasks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="task-index">

    <?= Alert::widget() ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create task', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php $form = ActiveForm::begin([
            'method' => 'get',
            'action' => ['index'],
            'options' => ['class' => 'filter-form']
        ]);
?>    
    <div class="row">

        <!-- Filter status -->
        <div class="col-md-5">
            <?= $form->field($searchModel, 'status')->dropDownList([
                '' => 'All',
                \app\models\Task::STATUS_PENDING => 'Pending',
                \app\models\Task::STATUS_IN_PROGRESS => 'In progress',
                \app\models\Task::STATUS_COMPLETED => 'Completed',
            ], ['prompt' => 'Select status'])->label('Status') ?>
        </div>

        <!-- Filter maturity -->
        <div class="col-md-5 mb-3">
            <?= $form->field($searchModel, 'maturity')->input('date', ['class' => 'form-control'])->label('Due date') ?>
        </div>

        <!-- filter button -->
        <div class="col-md-2 d-flex align-items-center mb-3">
            <?= Html::submitButton('Filter', ['class' => 'btn btn-primary me-2']) ?>
            <?= Html::a('Clean Filter', ['index'], ['class' => 'btn btn-secondary']) ?>
        </div>
    </div>
        
    <?php ActiveForm::end(); ?>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'title',
            'description:ntext',
            [
                'attribute' => 'status',
                'value' => function ($model) {
                    return $model->getStatusText();
                },
                'filter' => [
                    \app\models\Task::STATUS_PENDING => 'Pending',
                    \app\models\Task::STATUS_IN_PROGRESS => 'In progress',
                    \app\models\Task::STATUS_COMPLETED => 'Completed'
                ],
            ],
            'maturity',
            'created_at',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Task $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                }
            ],
        ],
    ]); ?>

</div>
