<?php

namespace Database\Factories;

use App\Models\ProductAttributeValue;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProductAttributeValueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductAttributeValue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'product_id' => $this->faker->optional()->uuid,
            'attribute_id' => $this->faker->optional()->uuid,
            'value' => $this->faker->word,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

    /**
     * Generate a value based on a specific data type
     * 
     * @param string $dataType
     * @return Factory
     */
    public function withDataType(string $dataType)
    {
        return $this->state(function () use ($dataType) {
            switch ($dataType) {
                case 'string':
                    $value = $this->faker->word;
                    break;
                case 'integer':
                    $value = $this->faker->numberBetween(1, 1000);
                    break;
                case 'decimal':
                    $value = $this->faker->randomFloat(2, 0, 1000);
                    break;
                case 'boolean':
                    $value = $this->faker->boolean;
                    break;
                case 'date':
                    $value = $this->faker->date();
                    break;
                default:
                    $value = $this->faker->word;
            }

            return [
                'value' => $value,
            ];
        });
    }
}
