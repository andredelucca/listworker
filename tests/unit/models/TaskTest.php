<?php

namespace tests\unit\models;

use app\models\Task;
use app\models\User;
use Codeception\Test\Unit;

/**
 * @group models
 */
class TaskTest extends Unit
{
    protected $model;

    public function testTaskStatusText()
    {
        $task = new Task();
        $task->status = Task::STATUS_PENDING;
        $this->assertEquals('Pending', $task->getStatusText(), 'Status text should be "Pending".');

        $task->status = Task::STATUS_IN_PROGRESS;
        $this->assertEquals('In progress', $task->getStatusText(), 'Status text should be "In progress".');

        $task->status = Task::STATUS_COMPLETED;
        $this->assertEquals('Completed', $task->getStatusText(), 'Status text should be "Completed".');

        $task->status = 999;
        $this->assertEquals('Desconhecido', $task->getStatusText(), 'Status text should be "Desconhecido".');
    }

    public function testTaskStatusOptions()
    {
        $task = new Task();
        $expectedOptions = [
            Task::STATUS_PENDING => 'Pending',
            Task::STATUS_IN_PROGRESS => 'In progress',
            Task::STATUS_COMPLETED => 'Completed',
        ];
        $this->assertEquals($expectedOptions, $task->getStatusOption(), 'Status options should match.');
    }
}
