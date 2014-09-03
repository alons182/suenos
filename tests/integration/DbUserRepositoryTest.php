<?php


use Suenos\Repos\User\DbUserRepository;
use Laracasts\TestDummy\Factory as TestDummy;
class DbUserRepositoryTest extends \Codeception\TestCase\Test
{
   /**
    * @var \IntegrationTester
    */
    protected $tester;
    protected $repo;


    protected function _before()
    {
        $this->repo =  new DbUserRepository(new User);
    }

    /** @test */
    public function find_a_user_with_your_profile_by_username()
    {
        //Given I have one user and profile
        $users = TestDummy::times(2)->create('User');
        $profile = TestDummy::create('Profile',[
            'user_id' => $users[0]->id,
            'first_name' => 'Alonso'
        ]);
        $username =  $users[0]->username;
        //when
        $user = $this->repo->findByUsername($username);

        //then
        $this->assertEquals($username,$user->username);
        $this->assertEquals($profile->first_name,$user->profile->first_name);

    }
    /** @test */
    public function save_the_user_with_a_blank_profile()
    {
        //Given I have data for the new user
        $data = [
            'username' => 'alo',
            'email' => 'alo@example.com',
            'password' => '123',
            'parent_id' => '0'

        ];
        //when I try a persist this user
        $saveUser = $this->repo->store($data);

        //The it should be saved
        //and the profile should have the correct user_id
        $this->tester->seeRecord('profiles',[
            'user_id'=>  $saveUser->id
        ]);


    }

}