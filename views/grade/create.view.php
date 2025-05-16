<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);


$conn = null;
try {
    $conn = new mysqli('localhost', 'root', '', 'studio_class');
    
   
    $studentQuery = "SELECT id, first_name, last_name FROM Users WHERE role = 'student' ORDER BY last_name, first_name";
    $studentResult = $conn->query($studentQuery);
    
    // Get all subjects
    $subjectQuery = "SELECT id, name FROM Subjects";
    $subjectResult = $conn->query($subjectQuery);
} catch (Exception $e) {
    echo "Database connection error: " . $e->getMessage();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $studentId = $_POST['student_id'];
    $subjectId = $_POST['subject_id'];
    $grade = $_POST['grade'];
    $date = $_POST['date'];
    
   
    if (empty($studentId) || empty($subjectId) || empty($grade) || empty($date)) {
        $error = "Visiem laukiem jābūt aizpildītiem";
    } elseif ($grade < 1 || $grade > 10) {
        $error = "Atzīmei jābūt no 1 līdz 10";
    } else {
        
        $stmt = $conn->prepare("INSERT INTO Grades (user_id, subject_id, grade, created_at) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiis", $studentId, $subjectId, $grade, $date);
        
        if ($stmt->execute()) {
            $success = "Atzīme veiksmīgi pievienota!";
        } else {
            $error = "Kļūda pievienojot atzīmi: " . $stmt->error;
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="lv">
<head>
    <title>Pievienot atzīmi</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        orange: {
                            light: '#FFA64D',
                            DEFAULT: '#FF7F00',
                            dark: '#E67300',
                        }
                    },
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100 font-sans text-gray-800">
    <div class="container mx-auto px-4 py-8 max-w-md">
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Header -->
            <div class="bg-orange text-white px-6 py-4 relative">
                <h1 class="text-xl font-medium">Pievienot jaunu atzīmi</h1>
                <div class="absolute -bottom-1 left-0 right-0 h-1 bg-orange-light"></div>
            </div>
            
            <!-- Form Container -->
            <div class="p-6">
                <?php if (isset($error)): ?>
                    <div class="bg-red-50 text-red-600 p-4 rounded-lg mb-6 border-l-4 border-red-500">
                        <?php echo $error; ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($success)): ?>
                    <div class="bg-green-50 text-green-600 p-4 rounded-lg mb-6 border-l-4 border-green-500">
                        <?php echo $success; ?>
                    </div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="mb-6">
                        <label for="student_id" class="block mb-2 font-medium text-gray-700">Skolēns:</label>
                        <select 
                            id="student_id" 
                            name="student_id" 
                            required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange focus:border-orange"
                        >
                            <option value="">Izvēlieties skolēnu</option>
                            <?php 
                            if ($studentResult) {
                                while ($student = $studentResult->fetch_assoc()): 
                            ?>
                                <option value="<?php echo $student['id']; ?>">
                                    <?php echo $student['last_name'] . ' ' . $student['first_name']; ?>
                                </option>
                            <?php 
                                endwhile; 
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label for="subject_id" class="block mb-2 font-medium text-gray-700">Priekšmets:</label>
                        <select 
                            id="subject_id" 
                            name="subject_id" 
                            required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange focus:border-orange"
                        >
                            <option value="">Izvēlieties priekšmetu</option>
                            <?php 
                            if ($subjectResult) {
                                while ($subject = $subjectResult->fetch_assoc()): 
                            ?>
                                <option value="<?php echo $subject['id']; ?>">
                                    <?php echo $subject['name']; ?>
                                </option>
                            <?php 
                                endwhile;
                            }
                            ?>
                        </select>
                    </div>
                    
                    <div class="mb-6">
                        <label for="grade" class="block mb-2 font-medium text-gray-700">Atzīme:</label>
                        <input 
                            type="number" 
                            id="grade" 
                            name="grade" 
                            min="1" 
                            max="10" 
                            step="0.1" 
                            required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange focus:border-orange"
                        >
                    </div>
                    
                    <div class="mb-6">
                        <label for="date" class="block mb-2 font-medium text-gray-700">Datums:</label>
                        <input 
                            type="date" 
                            id="date" 
                            name="date" 
                            required
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-orange focus:border-orange"
                        >
                    </div>
                    
                    <button 
                        type="submit"
                        class="w-full bg-orange hover:bg-orange-dark text-white font-medium py-3 px-4 rounded-lg transition-all duration-300 transform hover:-translate-y-0.5 hover:shadow-lg uppercase tracking-wide"
                    >
                        Saglabāt
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>