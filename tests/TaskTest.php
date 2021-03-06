<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TastkTest extends TestCase
{

    use WithoutMiddleware;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testTasksUseJson()
    {
        $this->get('/task')->seeJson()->seeStatusCode(200);
    }
    /**
     * Test tasks in database are listed by API
     *
     * @return void
     */
    public function testTasksInDatabaseAreListedByAPI()
    {
        $this->createFakeTasks();

        $user = factory(App\User::class)->create();

        $this->actingAs($user)->get('/task')
            ->seeJsonStructure([
                '*' => [
                    'name', 'done','priority'
                ]
            ])->seeStatusCode(200);
    }
    /**
     * Test task in database is shown by API
     *
     * @return void
     */
    public function testTaskInDatabaseAreShownByAPI()
    {
        $task = $this->createFakeTask();
        $user = factory(App\User::class)->create();
        $this->actingAs($user)->get('/task/' . $task->id)
            ->seeJsonContains(['name' => $task->name, 'done' => $task->done, 'priority' => $task->priority ])
            ->seeStatusCode(200);

    }
    /**
     * Create fake task
     *
     * @return \App\Task
     */
    private function createFakeTask() {
        $faker = Faker\Factory::create();
        $task = new \App\Task();
        $task->name = $faker->sentence;
        $task->done = $faker->boolean;//boolean
        $task->priority = $faker->randomDigit;//randomDigit
        $task->save();
        return $task;
    }
    /**
     * Create fake tasks
     *
     * @param int $count
     * @return \App\Task
     */
    private function createFakeTasks($count = 10) {
        foreach (range(0,$count) as $number) {
            $this->createFakeTask();
        }
    }
    /**
     * Test tasks can be posted and saved to database
     *
     * @return void
     */
    public function testTasksCanBePostedAndSavedIntoDatabase()
    {
        $data = ['name' => 'Foobar', 'done' => true, 'priority' => 1];
        $this->post('/task',$data)->seeInDatabase('tasks',$data);
        $this->get('/task')->seeJsonContains($data)->seeStatusCode(200);
    }
//    /**
//     * Test tasks can be update and see changes on database
//     *
//     * @return void
//     */
    public function testTasksCanBeUpdatedAndSeeChangesInDatabase()
    {
        $task = $this->createFakeTask();
        $data = [ 'name' => 'Learn Laravel', 'done' => false , 'priority' => 3];
        $this->put('/task/' . $task->id, $data)->seeInDatabase('tasks',$data);
        $this->get('/task')->seeJsonContains($data)->seeStatusCode(200);
    }
//    /**
//     * Test tasks can be deleted and not see on database
//     *
//     * @return void
//     */
    public function testTasksCanBeDeletedAndNotSeenOnDatabase()
    {
//        $task = $this->createFakeTask();
//        dd($task);
//        $data = [ 'name' => $task->name, 'done' => $task->done , 'priority' => $task->priority];
//        $this->delete('/task/' . $task->id)->notSeeInDatabase('tasks',$data);
//        $this->get('/task')->dontSeeJson($data)->seeStatusCode(200);
    }

    /*
     * @group failing
     */
    public function testAuthApi(){
        //$this->visit('/task')->assertRedirectedTo('auth/login')->see("Acces denied");
    }

    /*
    * @group failing
    */
    public function testTasksInDatabaseAreListedByAPI2()
    {
        $this->createFakeTasks();
        $user = factory(App\User::class)->create();

        $this->get('/task?api_token='. $user->api_token)
            ->seeJsonStructure([
                '*' => [
                    'name', 'done','priority'
                ]
            ])->seeStatusCode(200);
    }
}
