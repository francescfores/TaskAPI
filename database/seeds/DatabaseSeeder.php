<?php

use App\Tag;
use App\Task;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();
        $this->seedTasks($faker);
        $this->seedTags($faker);
        Model::reguard();
    }

    private function seedTasks($faker){
        foreach (range(1,10) as $number){
            $task= new Task();
            $task-> name= $faker->name();
            $task-> done= $faker->boolean();
            $task-> priority= $faker->randomDigit();
            $task->save();
        }
    }

    private function seedTags($faker){
        foreach (range(1,10) as $number){
            $tag= new Tag();
            $tag-> name= $faker->name();
            $tag->save();
        }
    }
}