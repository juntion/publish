<?php

namespace Tests\Feature\Erp;

use Tests\TestCase;

class PermissionTest extends TestCase
{
    /**
     * @test
     */
    public function profiles()
    {
        $response = $this->get('/users/erp/profiles', $this->headers);
        $response->assertJsonFragment($this->successStructure());
        return $response->original['data'];
    }

    /**
     * @test
     */
    public function userProfiles()
    {
        $response = $this->get('/users/' . $this->user->id . '/erp/profiles', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends profiles
     * @param $profiles
     */
    public function setProfiles($profiles)
    {
        $data = ['profile_ids' => collect($profiles)->pluck('profile_id')->toArray()];
        $response = $this->post('/users/' . $this->user->id . '/erp/profiles', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends profiles
     * @param $profiles
     */
    public function deleteProfile($profiles)
    {
        $profileId = $this->faker()->randomElement(collect($profiles)->pluck('profile_id')->toArray());
        $response = $this->delete('/users/' . $this->user->id . '/erp/profiles', ['profile_id' => $profileId], $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     * @depends profiles
     * @param $profiles
     */
    public function batchSetProfiles($profiles)
    {
        $data = [
            'user_ids' => [$this->user->id],
            'profile_ids' => collect($profiles)->pluck('profile_id')->toArray(),
        ];
        $response = $this->post('/users/erp/profiles', $data, $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }

    /**
     * @test
     */
    public function canSetProfileUsers()
    {
        $response = $this->get('/users/erp/canSetProfileUsers', $this->headers);
        $response->assertJsonFragment($this->successStructure());
    }
}
