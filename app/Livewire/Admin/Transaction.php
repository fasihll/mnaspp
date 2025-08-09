<?php

namespace App\Livewire\Admin;

use App\Models\Departement;
use App\Models\Student;
use App\Models\Transaction as ModelsTransaction;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Transaction extends Component
{
    use WithFileUploads;

    public $showModalCreate = false;
    public $showModalEdit = false;
    public $showModalCheckPayment = false;

    public $transaction;
    public $student;
    public $departement;

    public $id;
    public $student_id;
    public $student_name;
    public $departement_id;
    public $departement_name;

    public $transaction_type;
    public $status;
    public $bukti;

    protected function rules()
    {
        return [
            'student_id' => [
                'required',
                'numeric',
                Rule::unique('transactions')->where(function ($query) {
                    return $query->where('departement_id', $this->departement_id)
                        ->where('id', '!=', $this->id);
                })
            ],
            'departement_id' => [
                'required',
                'numeric',
                Rule::unique('transactions')->where(function ($query) {
                    return $query->where('student_id', $this->student_id)
                        ->where('id', '!=', $this->id);
                })
            ]
        ];
    }

    public function store()
    {
        try {
            $this->validate();

            ModelsTransaction::create([
                'student_id' => $this->student_id,
                'departement_id' => $this->departement_id,
            ]);

            $this->reset();

            session()->flash('success', 'Transaction Created!.');
            $this->showModalCreate = false;
            $this->mount();
        } catch (\Throwable $th) {
            $this->showModalCreate = false;
            session()->flash('error', 'Transaction Failed to Create! ' . $th->getMessage());
        }
    }

    public function edit($id)
    {
        $data = ModelsTransaction::where('id', $id)->first();
        $this->student_id = $data->student_id;
        $this->departement_id = $data->departement_id;
        $this->id = $data->id;

        $this->showModalEdit = true;
    }

    public function update()
    {
        try {
            $this->validate();

            ModelsTransaction::where('id', $this->id)->update([
                'student_id' => $this->student_id,
                'departement_id' => $this->departement_id,
            ]);
            $this->showModalEdit = false;
            $this->reset();
            $this->mount();
            session()->flash('success', 'Transaction Updated!');
        } catch (\Throwable $th) {
            $this->showModalEdit = false;
            session()->flash('error', 'Transaction Failed to Update!' . $th->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            ModelsTransaction::where('id', $id)->delete();
            $this->mount();
            session()->flash('success', 'Transaction Deleted!');
        } catch (\Throwable $th) {
            $this->showModalEdit = false;
            session()->flash('error', 'Transaction Failed to Delete!');
        }
    }

    public function restore($id)
    {
        try {
            ModelsTransaction::withTrashed()->where('id', $id)->restore();
            $this->mount();
            session()->flash('success', 'Transaction Restored!');
        } catch (\Throwable $th) {
            $this->showModalEdit = false;
            session()->flash('error', 'Transaction Failed to Restore!');
        }
    }

    public function paymentCheck($id)
    {
        $data = ModelsTransaction::with('student', 'departement')->where('id', $id)->first();

        $this->student_name = $data->student->name;
        $this->departement_name = $data->departement->name;
        $this->transaction_type = $data->transaction_type;
        $this->status = $data->status;
        $this->bukti = $data->bukti;
        $this->id = $data->id;

        $this->showModalCheckPayment = true;
    }

    public function confirmPayment()
    {
        try {
            ModelsTransaction::where('id', $this->id)->update([
                'status' => $this->status,
            ]);
            $this->showModalCheckPayment = false;
            $this->reset();
            $this->mount();
            session()->flash('success', 'Transaction Updated!');
        } catch (\Throwable $th) {
            $this->showModalCheckPayment = false;
            session()->flash('error', 'Transaction Failed to Update!' . $th->getMessage());
        }
    }

    public function mount()
    {
        $this->transaction = ModelsTransaction::with('student', 'departement')->withTrashed()->get();
        $this->student = Student::all();
        $this->departement = Departement::all();
    }

    public function render()
    {
        return view('livewire.admin.transaction', [
            'transaction' => $this->transaction,
            'student' => $this->student,
            'departement' => $this->departement
        ]);
    }
}
