<?php

namespace App\Livewire\Student;

use App\Models\Student;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Biodata extends Component
{
    use WithFileUploads;

    public $name;
    public $email;
    public $phone;
    public $image;
    public $certificate;

    protected function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|numeric',
            'image' => $this->image ? 'nullable' : 'required|file|mimes:jpeg,png,jpg|max:2048',
            'certificate' => $this->certificate ?  'nullable' : 'required|file|mimes:pdf|max:2048',
        ];
    }

    public function mount()
    {
        $student = Student::where('user_id', Auth::user()->id)->with('user')->first();
        $this->name = $student->user->name ?? '';
        $this->email = $student->user->email ?? '';
        $this->phone = $student->phone ?? '';
        $this->image = $student->image ?? '';
        $this->certificate = $student->certificate ?? '';
    }

    public function store()
    {
        try {
            $this->validate();

            $student = Student::with('user')->updateOrCreate(
                ['user_id' => Auth::user()->id],
                [
                    'name' => $this->name,
                    'email' => $this->email,
                    'phone' => $this->phone,
                    'image' => $this->image instanceof UploadedFile ? $this->image->store('images', 'public') : Student::where('user_id', Auth::user()->id)->first()->image ?? '',
                    'certificate' => $this->certificate instanceof UploadedFile ? $this->certificate->store('certificates', 'public') : Student::where('user_id', Auth::user()->id)->first()->certificate ?? '',
                ]
            );

            if ($student->user) {
                $student->user->name = $this->name;
                $student->user->email = $this->email;
                $student->user->save();
            }

            $this->mount();
            session()->flash('success', 'Biodata berhasil diubah');
        } catch (\Throwable $th) {
            session()->flash('error', 'Biodata gagal diubah ' . $th->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.student.biodata');
    }
}
