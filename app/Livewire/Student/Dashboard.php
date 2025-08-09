<?php

namespace App\Livewire\Student;

use App\Models\Student;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Dashboard extends Component
{
    use WithFileUploads;

    public $showModalBayar = false;

    public $transaction;

    public $name;
    public $departement;
    public $semester;
    public $transaction_type;
    public $status;
    public $bukti;
    public $id;

    protected function rules()
    {
        return [
            'transaction_type' => 'required|in:cash,transfer',
            'bukti' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }


    public function openModalBayar($id)
    {
        $data = Transaction::with('student', 'departement')->where('id', $id)->first();
        $this->name = $data->student->name;
        $this->departement = $data->departement->name;
        $this->semester = $data->departement->semester;
        $this->transaction_type = $data->transaction_type;
        $this->status = $data->status;
        $this->id = $data->id;

        $this->showModalBayar = true;
    }
    public function bayar()
    {
        $this->validate();
        try {
            $data = [
                'transaction_type' => $this->transaction_type,
                'bukti' => $this->bukti ? $this->bukti->store('bukti', 'public') : null,
            ];
            Transaction::updateOrCreate(
                ['id' => $this->id],
                array_filter($data, fn($value) => !is_null($value))
            );
            $this->showModalBayar = false;
            $this->mount();
            session()->flash('success', 'Transaction Updated!');
        } catch (\Throwable $th) {
            $this->showModalBayar = false;
            session()->flash('error', 'Transaction Failed to Update!');
        }
    }

    public function mount()
    {
        $student_id = Student::where('user_id', Auth::user()->id)->first()->id;
        $this->transaction = Transaction::with('student', 'departement')->where('student_id', $student_id)->get();
    }
    public function render()
    {
        return view('livewire.student.dashboard', [
            'transaction' => $this->transaction
        ]);
    }
}
