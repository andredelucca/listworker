<?php

namespace tests\unit\models;

use app\models\Task;
use app\models\TaskSearch;
use app\models\User;
use Codeception\Test\Unit;
use yii\data\ActiveDataProvider;

/**
 * @group models
 */
class TaskSearchTest extends Unit
{
    protected $tester;

    public function _before()
    {
        
    }

    public function testSearchWithInvalidParameters()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search([
            'status' => 999, 
            'maturity' => 'Nonexistent',
        ]);

        $this->assertInstanceOf(ActiveDataProvider::class, $dataProvider);
        $this->assertEquals(0, $dataProvider->getTotalCount());
    }

    public function testSearchWithoutParameters()
    {
        $searchModel = new TaskSearch();
        $dataProvider = $searchModel->search([]);

        $this->assertInstanceOf(ActiveDataProvider::class, $dataProvider);
        $this->assertGreaterThanOrEqual(0, $dataProvider->getTotalCount());
    }
}
