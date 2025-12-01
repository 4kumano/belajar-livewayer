<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Users extends Component
{
    use WithFileUploads;
    public $name;
    public $email;
    public $password;
    public $avatar;

    public function createNewUsers()
    {
        $validatedData = $this->validate([
            'name' => 'required|min:3',
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:6',
            'avatar' => 'required|image|max:5120', // max 5MB
        ]);
        if ($this->avatar) {
            $validatedData['avatar'] = $this->avatar->store('avatars', 'public');
        } else {
            $validatedData['avatar'] = null;
        }
        User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'avatar' => $validatedData['avatar'],
        ]);

        // User::create([
        //     'name' => $this->name,
        //     'email' => $this->email,
        //     'password' => bcrypt($this->password),
        // ]);
        // $this->reset(['name', 'email', 'password']);
        $this->reset();
        // dd('Create User function called');
        session()->flash('sukses', 'Akun Berhasil dibuat.');
    }
    public function render()
    {
        return view('livewire.users', [
            'tittle' => 'Users Page',
            'user' => User::all(),
        ]);
    }
}
