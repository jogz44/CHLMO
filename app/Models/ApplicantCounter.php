<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicantCounter extends Model
{
    use HasFactory;

    protected $fillable = [
        'year',
        'last_count'
    ];

    // Method to increment the last count for the current year
    public static function incrementCountForYear($year)
    {
        // Fetch or create the record for the year
        $counter = self::firstOrCreate(
            ['year' => $year],
            ['last_count' => 0] // Initialize last_count to 0 if creating a new year
        );

        // Increment the last_count by 1
        $counter->increment('last_count');

        // Return the updated last_count value
        return $counter->last_count;
    }
}
