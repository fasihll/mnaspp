<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class Users extends Component
{
    public $showModalCreate = false;
    public $showModalEdit = false;

    public $users;

    public $id;
    public $name;
    public $email;
    public $password;
    public $password_confirmation;
    public $role_id;

    protected function rules()
    {
        if ($this->showModalEdit) {
            if ($this->password != null) {
                return [
                    'name' => 'nullable|string|max:25|unique:users,name,' . $this->id,
                    'email' => 'nullable|email|unique:users,email,' . $this->id,
                    'password' => 'required|min:8|confirmed',
                ];
            } else {
                return [
                    'name' => 'nullable|string|max:25|unique:users,name,' . $this->id,
                    'email' => 'nullable|email|unique:users,email,' . $this->id,
                ];
            }
        }

        return [
            'name' => 'required|string|max:25|unique:users,name',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role_id' => 'required|numeric'
        ];
    }

    public function store()
    {
        $this->validate();

        try {
            User::create([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role_id' => $this->role_id,
            ]);

            $this->reset(['name', 'email', 'password', 'role_id']);

            session()->flash('success', 'User Created!.');
            $this->showModalCreate = false;
            $this->mount();
        } catch (\Throwable $th) {
            $this->showModalEdit = false;
            session()->flash('error', 'User Failed to Create!');
        }
    }

    public function edit($id)
    {
        $data = User::where('id', $id)->first();
        $this->name = $data->name;
        $this->email = $data->email;
        $this->role_id = $data->role_id;
        $this->id = $data->id;

        $this->showModalEdit = true;
    }

    public function update()
    {
        $this->validate();
        try {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
            ];

            if (!empty($this->password)) {
                $data['password'] = Hash::make($this->password);
            }

            User::where('id', $this->id)->update($data);

            $this->showModalEdit = false;
            $this->mount();
            session()->flash('success', 'User  Updated!');
        } catch (\Throwable $th) {
            $this->showModalEdit = false;
            session()->flash('error', 'User  Failed to Update!');
        }
    }

    public function delete($id)
    {
        try {
            User::where('id', $id)->delete();
            $this->mount();
            session()->flash('success', 'User  Deleted!');
        } catch (\Throwable $th) {
            $this->showModalEdit = false;
            session()->flash('error', 'User  Failed to Delete!');
        }
    }

    public function mount()
    {
        $this->users = User::with('roles')->orderBy('id', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.admin.users', [
            'users' => $this->users
        ]);
    }
}
