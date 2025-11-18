<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class Users extends Component
{
    public $name = '';
    public $email = '';
    public $password = '';

    public function createNewUsers()
    {
        $validatedData = $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6',
        ]);
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
        ]);

        // User::create([
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'password' => bcrypt($this->password),
        // ]);
        // $this->reset(['name', 'email', 'password']);
        $this->reset();
        // dd('Create User function called');
    }
    public function render()
    {
        return view('livewire.users', [
            'tittle' => 'Users Page',
            'user' => User::all(),
        ]);
    }
}
