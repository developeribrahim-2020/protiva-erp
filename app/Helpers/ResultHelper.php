<?php

namespace App\Helpers;

class ResultHelper
{
    /**
     * Calculates the grade and grade point for a given mark.
     */
    public static function calculateGrade($marks)
    {
        $marks = (float)$marks;

        if ($marks >= 80) return (object)['grade' => 'A+', 'grade_point' => 5.0];
        if ($marks >= 70) return (object)['grade' => 'A', 'grade_point' => 4.0];
        if ($marks >= 60) return (object)['grade' => 'A-', 'grade_point' => 3.5];
        if ($marks >= 50) return (object)['grade' => 'B', 'grade_point' => 3.0];
        if ($marks >= 40) return (object)['grade' => 'C', 'grade_point' => 2.0];
        if ($marks >= 33) return (object)['grade' => 'D', 'grade_point' => 1.0];
        
        return (object)['grade' => 'F', 'grade_point' => 0.0];
    }

    /**
     * Calculates the final GPA and Grade, considering optional subjects.
     * @param array $gradePoints Array of grade points for all subjects.
     * @param float|null $optionalSubjectGradePoint The grade point of the optional subject.
     * @param int $totalSubjects The total number of mandatory subjects.
     */
    public static function calculateGpa(array $gradePoints, ?float $optionalSubjectGradePoint, int $totalSubjects)
    {
        // Check for failure in any mandatory subject
        if (in_array(0.0, $gradePoints, true)) {
            return (object)['gpa' => '0.00', 'grade' => 'F'];
        }

        if (empty($gradePoints) || $totalSubjects == 0) {
             return (object)['gpa' => 'N/A', 'grade' => 'N/A'];
        }

        $totalMandatoryPoints = array_sum($gradePoints);
        
        // Add extra points from optional subject (points above 2.0)
        $optionalExtraPoints = 0;
        if ($optionalSubjectGradePoint !== null && $optionalSubjectGradePoint > 2.0) {
            $optionalExtraPoints = $optionalSubjectGradePoint - 2.0;
        }

        $totalPointsWithOptional = $totalMandatoryPoints + $optionalExtraPoints;
        $gpa = $totalPointsWithOptional / $totalSubjects;

        // Cap the GPA at 5.00
        $finalGpa = min($gpa, 5.0);
        
        $grade = self::getGradeFromGpa($finalGpa);

        return (object)['gpa' => number_format($finalGpa, 2), 'grade' => $grade];
    }

    public static function getGradeFromGpa($gpa)
    {
        if ($gpa >= 5.00) return 'A+';
        if ($gpa >= 4.00) return 'A';
        if ($gpa >= 3.50) return 'A-';
        if ($gpa >= 3.00) return 'B';
        if ($gpa >= 2.00) return 'C';
        if ($gpa >= 1.00) return 'D';
        
        return 'F';
    }
}