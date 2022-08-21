<?php

namespace Tests\Unit;

use Exception;
use Tests\TestCase;
use App\Models\Team;
use App\Models\User;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class TeamTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * @test
     *
     */
    public function a_team_has_a_name()
    {
        $team = new Team(['name' => 'Ferro']);

        $this->assertEquals('Ferro', $team->name);
    }

    /**
    * @test
    *
    * @return void
    **/
    public function a_team_can_add_members()
    {
        $team = Team::factory()->create(['name' => 'Ferro']);
        $member = User::factory()->create(['name' => 'Robert']);

        $member2 = User::factory()->create(['name' => 'Cecilia']);

        $team->add($member);
        $team->add($member2);

        $this->assertEquals(2, $team->count());
    }

    /**
    * @test
    *
    * @return void
    **/
    public function a_team_has_a_maximum_size()
    {
        $team = Team::factory()->create(['size' => 2]);

        $member = User::factory()->create(['name' => 'Robert']);
        $member2 = User::factory()->create(['name' => 'Cecilia']);


        $team->add($member);
        $team->add($member2);

        $this->assertEquals(2, $team->count());

        $this->expectException(Exception::class);

        $member3 = User::factory()->create(['name' => 'Rosa']);

        $team->add($member3);
        
    }

    /**
    * @test
    *
    * @return void
    **/
    public function a_team_can_receive_multiple_members_at_once()
    {
        $team = Team::factory()->create();

        $users = User::factory()->count(5)->create();

        $team->add($users);

        $this->assertEquals(5, $team->count());
    }

    /**
     * @test
     */
    
    
    public function a_team_cannot_exceed_the_max_size_when_adding_multiple_users()
    {
        $team = Team::factory()->create(['size' => 2]);

        $members = User::factory()->count(7)->create();

        $this->expectException(Exception::class);
        
        $team->add($members);

    }

    /**
    * @test
    *
    * @return void
    **/
    public function a_team_can_remove_a_member()
    {
        $team = Team::factory()->create();

        $user = User::factory()->create(['name' => 'Robert']);

        $team->add($user);

        $this->assertEquals(1, $team->count());

        $team->remove($user);

        $this->assertEquals(0, $team->count());

    } 

    /**
    * @test
    *
    * @return void
    **/
    public function a_team_can_remove_more_than_one_member()
    {
        $team = Team::factory()->create();

        $users = User::factory()->count(2)->create();

        $team->add($users);

        $this->assertEquals(2, $team->count());

        $team->remove($users);

        $this->assertEquals(0, $team->count());

    } 

    /**
    * @test
    *
    * @return void
    **/
    public function a_team_can_remove_all_members_at_once()
    {
        $team = Team::factory()->create();

        $users = User::factory()->count(2)->create();

        $team->add($users);

        $this->assertEquals(2, $team->count());

        $team->empty();

        $this->assertEquals(0, $team->count());


        
    } 


}
