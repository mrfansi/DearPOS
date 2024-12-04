<?php

namespace Database\Factories;

use App\Models\EmployeeDocument;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EmployeeDocumentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EmployeeDocument::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'employee_id' => $this->faker->optional()->uuid,
            'document_type' => $this->faker->randomElement(['contract', 'id', 'passport', 'certification']),
            'document_name' => $this->faker->word,
            'file_path' => $this->faker->filePath(),
            'issue_date' => $this->faker->date(),
            'expiry_date' => $this->faker->optional()->date(),
            'is_verified' => $this->faker->boolean,
            'notes' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }
}
