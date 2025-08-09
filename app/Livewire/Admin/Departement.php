<?php

namespace App\Livewire\Admin;

use App\Models\Departement as ModelsDepartement;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use PhpParser\Node\Expr\FuncCall;

class Departement extends Component
{
    public $showModalCreate = false;
    public $showModalEdit = false;
    public $departements;

    public $id;
    public $name;
    public $semester;
    public $cost;

    protected function rules()
    {
        return [
            'name' => [
                'required',
                Rule::unique('departements', 'name')->where(fn($query) => $query->where('semester', $this->semester))
            ],
            'semester' => 'required|numeric',
            'cost' => 'required|numeric'
        ];
    }

    public function store()
    {
        $this->validate();

        try {
            ModelsDepartement::create([
                'name' => $this->name,
                'semester' => $this->semester,
                'cost' => $this->cost,
            ]);

            $this->reset(['name', 'semester', 'cost']);

            session()->flash('success', 'Departemen Created!.');
            $this->showModalCreate = false;
            $this->mount();
        } catch (\Throwable $th) {
            $this->showModalEdit = false;
            session()->flash('error', 'Departement Failed to Create!');
        }
    }

    public function edit($id)
    {
        $data = ModelsDepartement::where('id', $id)->first();
        $this->name = $data->name;
        $this->semester = $data->semester;
        $this->cost = $data->cost;
        $this->id = $data->id;

        $this->showModalEdit = true;
    }

    public function update()
    {
        $this->validate();
        try {
            ModelsDepartement::where('id', $this->id)->update([
                'name' => $this->name,
                'semester' => $this->semester,
                'cost' => $this->cost,
            ]);
            $this->showModalEdit = false;
            $this->mount();
            session()->flash('success', 'Departement Updated!');
        } catch (\Throwable $th) {
            $this->showModalEdit = false;
            session()->flash('error', 'Departement Failed to Update!');
        }
    }

    public function delete($id)
    {
        try {
            ModelsDepartement::where('id', $id)->delete();
            $this->mount();
            session()->flash('success', 'Departement Deleted!');
        } catch (\Throwable $th) {
            $this->showModalEdit = false;
            session()->flash('error', 'Departement Failed to Delete!');
        }
    }


    public function mount()
    {
        $this->departements = ModelsDepartement::orderBy('id', 'desc')->get();
    }

    public function render()
    {
        return view('livewire.admin.departement', [
            'departements' => $this->departements
        ]);
    }
}
