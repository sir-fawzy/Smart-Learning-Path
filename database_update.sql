
-- Add course_id column to exam_category table if it doesn't exist
ALTER TABLE exam_category ADD COLUMN IF NOT EXISTS course_id INT;

-- Add course_id column to lecture_list table if it doesn't exist
ALTER TABLE lecture_list ADD COLUMN IF NOT EXISTS course_id INT;

-- Add course_id column to questions table if it doesn't exist
ALTER TABLE questions ADD COLUMN IF NOT EXISTS course_id INT;

-- Create course_enrollments table if it doesn't exist
CREATE TABLE IF NOT EXISTS course_enrollments (
  id INT PRIMARY KEY AUTO_INCREMENT,
  student_id VARCHAR(255),
  course_id INT,
  enrollment_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  UNIQUE KEY unique_enrollment (student_id, course_id)
);

-- Update existing records to set default course_id if needed
-- This is a placeholder - you might want to set specific course IDs manually
-- UPDATE exam_category SET course_id = 1 WHERE course_id IS NULL;
-- UPDATE lecture_list SET course_id = 1 WHERE course_id IS NULL;
-- UPDATE questions SET course_id = 1 WHERE course_id IS NULL;
