<?php
namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\SchoolClass;
use App\Models\Student;
use Livewire\Attributes\Layout; // <-- এই লাইনটি যোগ করা হয়েছে

#[Layout('layouts.app')]
class BulkEntry extends Component
{
    public $textData = '';
    public $successCount = 0;
    public $errorCount = 0;
    public $errors = [];

    public function processEntry()
    {
        $lines = explode("\n", trim($this->textData));
        $this->successCount = 0;
        $this->errorCount = 0;
        $this->errors = [];

        foreach ($lines as $index => $line) {
            $line = trim($line);
            if (empty($line)) continue;

            $parts = str_getcsv($line);

            if (count($parts) < 3) {
                $this->errorCount++;
                $this->errors[] = "Row " . ($index + 1) . ": Invalid format. Expected: Roll,Name,Class - Section";
                continue;
            }

            $roll = trim($parts[0]);
            $name = trim($parts[1]);
            $classAndSection = trim($parts[2]);

            $classParts = explode('-', $classAndSection, 2);
            if (count($classParts) < 2) {
                 $this->errorCount++;
                 $this->errors[] = "Row " . ($index + 1) . ": Invalid Class-Section format '{$classAndSection}'.";
                 continue;
            }

            $className = trim($classParts[0]);
            $sectionName = trim($classParts[1]);

            $class = SchoolClass::firstOrCreate(
                ['name' => $className, 'section' => $sectionName],
                ['group' => null]
            );

            if (!$class) {
                $this->errorCount++;
                $this->errors[] = "Row " . ($index + 1) . ": Could not find or create class for '{$name}'.";
                continue;
            }
            
            try {
                Student::updateOrCreate(
                    ['school_class_id' => $class->id, 'roll_number' => $roll],
                    ['name' => $name]
                );
                $this->successCount++;
            } catch (\Exception $e) {
                $this->errorCount++;
                $this->errors[] = "Row " . ($index + 1) . ": Could not save '{$name}': " . $e->getMessage();
            }
        }
        session()->flash('message', "Process complete. {$this->successCount} students saved, {$this->errorCount} errors.");
        $this->reset('textData');
    }

    public function render()
    {
        return view('livewire.student.bulk-entry');
    }
}