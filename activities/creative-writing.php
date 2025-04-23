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
    <title>Creative Writing Adventure - Little Learners Emporium</title>
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

        .story-prompts {
            background: #fff3e0;
            padding: 20px;
            border-radius: 10px;
            margin: 20px 0;
        }

        .story-prompts h4 {
            color: #e65100;
            margin-bottom: 15px;
        }

        .prompt-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .prompt-box {
            background: white;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .story-elements {
            background: #f3e5f5;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
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
            <h1>📝 Creative Writing Adventure</h1>
            <span class="age-tag">Age Group: 6-8 Years</span>
        </div>

        <img src="../images/activities/icons/creative-writing.jpg" alt="Creative Writing Adventure" class="activity-image">

        <div class="activity-content">
            <div class="activity-description">
                <div class="materials-list">
                    <h3>Materials Needed:</h3>
                    <ul>
                        <li>Writing notebook or paper</li>
                        <li>Pencils and erasers</li>
                        <li>Story prompt cards</li>
                        <li>Character development worksheets</li>
                        <li>Setting description cards</li>
                        <li>Story planning templates</li>
                        <li>Colored markers for editing</li>
                    </ul>
                </div>

                <div class="story-prompts">
                    <h4>Story Starter Ideas:</h4>
                    <div class="prompt-grid">
                        <div class="prompt-box">
                            <p><strong>Magic Discovery</strong></p>
                            <p>"One day, I found a glowing stone..."</p>
                        </div>
                        <div class="prompt-box">
                            <p><strong>Animal Adventure</strong></p>
                            <p>"The talking squirrel needed my help..."</p>
                        </div>
                        <div class="prompt-box">
                            <p><strong>Space Journey</strong></p>
                            <p>"The spaceship landed in my backyard..."</p>
                        </div>
                        <div class="prompt-box">
                            <p><strong>Time Travel</strong></p>
                            <p>"The old clock started spinning backwards..."</p>
                        </div>
                    </div>
                </div>

                <div class="story-elements">
                    <h4>Key Story Elements to Include:</h4>
                    <ul>
                        <li>Main character description</li>
                        <li>Setting details</li>
                        <li>Problem or conflict</li>
                        <li>Solution or resolution</li>
                        <li>Beginning, middle, and end</li>
                    </ul>
                </div>

                <div class="instructions">
                    <h3>Activity Steps:</h3>
                    <ol>
                        <li>Choose a story prompt or create your own idea</li>
                        <li>Plan your story using the planning template</li>
                        <li>Develop your main character's traits and goals</li>
                        <li>Describe the story setting in detail</li>
                        <li>Write your first draft</li>
                        <li>Review and edit your work</li>
                        <li>Add illustrations if desired</li>
                        <li>Share your story with others</li>
                    </ol>
                </div>

                <div class="safety-note">
                    <h4>Writing Tips:</h4>
                    <p>Encourage creativity and imagination while maintaining basic story structure. Help students use descriptive words and varying sentence lengths to make their writing more interesting.</p>
                </div>
            </div>

            <div class="activity-sidebar">
                <div class="learning-outcomes">
                    <h3>Learning Outcomes</h3>
                    <ul>
                        <li>Story structure understanding</li>
                        <li>Vocabulary development</li>
                        <li>Creative thinking skills</li>
                        <li>Writing mechanics practice</li>
                        <li>Character development</li>
                        <li>Descriptive writing skills</li>
                        <li>Self-expression</li>
                    </ul>
                </div>

                <div class="tips-section">
                    <h3>Extension Activities</h3>
                    <ul>
                        <li>Create a story collection</li>
                        <li>Write collaborative stories</li>
                        <li>Make story illustrations</li>
                        <li>Present stories to the class</li>
                    </ul>
                </div>
            </div>
        </div>

        <a href="../learning-activities.php" class="back-btn">← Back to Activities</a>
    </div>

    <?php include("../includes/footer.php"); ?>
</body>
</html> 