<?php
session_start();
include("../includes/db.php");
include("../includes/header.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Math Pattern Challenge - Little Learners Emporium</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .activity-container {
            max-width: 1000px;
            margin: 40px auto;
            padding: 20px;
        }

        .activity-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .activity-header h1 {
            color: #333;
            margin-bottom: 10px;
        }

        .activity-header .age-tag {
            display: inline-block;
            background: #e8f5e9;
            color: #2e7d32;
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.9rem;
        }

        .activity-content {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
            margin-top: 30px;
        }

        .activity-description {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .materials-list {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            margin-bottom: 20px;
        }

        .materials-list h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .materials-list ul {
            list-style: none;
            padding: 0;
        }

        .materials-list li {
            margin: 10px 0;
            padding-left: 20px;
            position: relative;
        }

        .materials-list li:before {
            content: "•";
            color: #5db075;
            position: absolute;
            left: 0;
        }

        .instructions {
            margin-top: 20px;
        }

        .instructions h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .instructions ol {
            padding-left: 20px;
        }

        .instructions li {
            margin: 15px 0;
            line-height: 1.5;
        }

        .activity-sidebar {
            background: white;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            height: fit-content;
        }

        .activity-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            margin: 20px 0;
        }

        .pattern-examples {
            background: #f0f7ff;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .pattern-examples h4 {
            color: #0066cc;
            margin-bottom: 15px;
        }

        .pattern-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .pattern-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .back-btn {
            display: inline-block;
            padding: 10px 20px;
            background: #5db075;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background: #4a8f5e;
        }
    </style>
</head>
<body>
    <div class="activity-container">
        <div class="activity-header">
            <h1>🔢 Math Pattern Challenge</h1>
            <span class="age-tag">Age Group: 6-8 Years</span>
        </div>

        <img src="../images/activities/icons/math-patterns.jpg" alt="Math Pattern Challenge" class="activity-image">

        <div class="activity-content">
            <div class="activity-description">
                <div class="materials-list">
                    <h3>Materials Needed:</h3>
                    <ul>
                        <li>Number cards (1-20)</li>
                        <li>Geometric shape blocks</li>
                        <li>Pattern worksheets</li>
                        <li>Colored markers or pencils</li>
                        <li>Grid paper</li>
                        <li>Pattern challenge cards</li>
                        <li>Calculator (optional)</li>
                    </ul>
                </div>

                <div class="pattern-examples">
                    <h4>Pattern Types to Explore:</h4>
                    <div class="pattern-grid">
                        <div class="pattern-box">
                            <p><strong>Number Patterns</strong></p>
                            <p>2, 4, 6, 8, ___</p>
                        </div>
                        <div class="pattern-box">
                            <p><strong>Shape Patterns</strong></p>
                            <p>🔷 🔶 🔷 🔶 ___</p>
                        </div>
                        <div class="pattern-box">
                            <p><strong>Skip Counting</strong></p>
                            <p>5, 10, 15, 20, ___</p>
                        </div>
                        <div class="pattern-box">
                            <p><strong>Growing Patterns</strong></p>
                            <p>1, 3, 6, 10, ___</p>
                        </div>
                    </div>
                </div>

                <div class="instructions">
                    <h3>Activity Steps:</h3>
                    <ol>
                        <li>Begin with simple number patterns and skip counting exercises</li>
                        <li>Introduce geometric shape patterns and their sequences</li>
                        <li>Practice identifying missing numbers in patterns</li>
                        <li>Create your own patterns using numbers and shapes</li>
                        <li>Solve pattern puzzles of increasing difficulty</li>
                        <li>Document patterns found in everyday life</li>
                        <li>Work on growing and shrinking number patterns</li>
                        <li>Complete pattern-based word problems</li>
                    </ol>
                </div>

                <div class="safety-note">
                    <h4>Learning Tips:</h4>
                    <p>Encourage students to explain their pattern-finding strategies and reasoning. Connect patterns to real-world examples like calendar dates, clock times, and nature.</p>
                </div>
            </div>

            <div class="activity-sidebar">
                <div class="learning-outcomes">
                    <h3>Learning Outcomes</h3>
                    <ul>
                        <li>Mathematical pattern recognition</li>
                        <li>Logical reasoning skills</li>
                        <li>Problem-solving abilities</li>
                        <li>Skip counting mastery</li>
                        <li>Geometric shape understanding</li>
                        <li>Number sequence comprehension</li>
                        <li>Mathematical communication</li>
                    </ul>
                </div>

                <div class="tips-section">
                    <h3>Extension Activities</h3>
                    <ul>
                        <li>Create pattern art projects</li>
                        <li>Design pattern games</li>
                        <li>Find patterns in nature</li>
                        <li>Make pattern predictions</li>
                    </ul>
                </div>
            </div>
        </div>

        <a href="../learning-activities.php" class="back-btn">← Back to Activities</a>
    </div>

    <?php include("../includes/footer.php"); ?>
</body>
</html> 