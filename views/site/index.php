<?php

use yii\helpers\Url;

/** @var yii\web\View $this */

$this->title = 'Listworker';
?>
<div class="site-index">

    <div class="jumbotron text-center bg-transparent mt-5 mb-5">
        <h1 class="display-4">Congratulations!</h1>

        <p class="lead">Welcome to your task app.</p>

        <p class="lead">If you already have an account, log in by clicking the button below.</p>
        
        <?php if (Yii::$app->user->isGuest): ?>
            <p><a class="btn btn-lg btn-success" href="<?= Url::to(['site/login']) ?>">Login</a></p>
        <?php else: ?>
            <p><a class="btn btn-lg btn-success disabled" href="#" aria-disabled="true">Login</a></p>
        <?php endif; ?>

        <p class="lead">But if you don't have an account, create it by clicking the button below.</p>

        <?php if (Yii::$app->user->isGuest): ?>
            <p><a class="btn btn-lg btn-primary" href="<?= Url::to(['site/signup']) ?>">Create account</a></p>
        <?php else: ?>
            <p><a class="btn btn-lg btn-primary disabled" href="#" aria-disabled="true">Create account</a></p>
        <?php endif; ?>
    </div>

    <div class="body-content">

    </div>
</div>
