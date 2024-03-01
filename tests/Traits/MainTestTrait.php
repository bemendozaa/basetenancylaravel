<?php

namespace Tests\Traits;

use App\Models\Tenant\User;


trait MainTestTrait
{
        
    /**
     *
     * @return void
     */
    public function createAndLoginUser()
    {
        $this->actingAs($this->createUser());
    }


    /**
     *
     * @return void
     */
    public function loginUser()
    {
        $user = User::first();

        if(!$user)
        {
            $user = $this->createUser();
        }

        $this->actingAs($user);
    }


    private function createUser()
    {
        return User::factory()->create();
    }

}


