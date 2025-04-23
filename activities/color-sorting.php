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
    <title>Color Sorting Activity - Little Learners Emporium</title>
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

        .tips-section {
            margin-top: 20px;
        }

        .tips-section h3 {
            color: #333;
            margin-bottom: 15px;
        }

        .tips-section ul {
            list-style: none;
            padding: 0;
        }

        .tips-section li {
            margin: 10px 0;
            padding-left: 25px;
            position: relative;
        }

        .tips-section li:before {
            content: "💡";
            position: absolute;
            left: 0;
        }

        .activity-image {
            width: 100%;
            height: 300px;
            object-fit: cover;
            border-radius: 15px;
            margin: 20px 0;
        }

        .safety-note {
            background: #fff3e0;
            padding: 15px;
            border-radius: 10px;
            margin: 20px 0;
            border-left: 4px solid #ff9800;
        }

        .safety-note h4 {
            color: #f57c00;
            margin-bottom: 10px;
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

        .progress-tracker {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-top: 20px;
        }

        .progress-tracker h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .color-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .color-box {
            aspect-ratio: 1;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: white;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>
    <div class="activity-container">
        <div class="activity-header">
            <h1>🌈 Rainbow Sorting Play</h1>
            <span class="age-tag">Age Group: 3-5 Years</span>
        </div>

        <img src="../images/activities/icons/color-sorting.jpg" alt="Color Sorting Activity" class="activity-image">

        <div class="activity-content">
            <div class="activity-description">
                <div class="materials-list">
                    <h3>Materials Needed:</h3>
                    <ul>
                        <li>Colorful blocks, toys, or objects of various sizes</li>
                        <li>Sorting containers or boxes (one for each color)</li>
                        <li>Color cards with names and pictures</li>
                        <li>Simple color-related worksheets</li>
                        <li>Color matching games</li>
                    </ul>
                </div>

                <div class="instructions">
                    <h3>Activity Steps:</h3>
                    <ol>
                        <li>Set up sorting containers and label them with color names and pictures</li>
                        <li>Introduce each color with its name and example objects</li>
                        <li>Demonstrate sorting items by color while saying the color names</li>
                        <li>Let children sort items independently and practice naming colors</li>
                        <li>Use color cards to reinforce learning and play matching games</li>
                        <li>Challenge children to find objects of specific colors in the room</li>
                        <li>Practice writing color names for advanced learners</li>
                    </ol>
                </div>

                <div class="safety-note">
                    <h4>Learning Tips:</h4>
                    <p>Encourage children to explain their sorting choices and use complete sentences when describing colors. Make connections to everyday objects and nature.</p>
                </div>
            </div>

            <div class="activity-sidebar">
                <div class="learning-outcomes">
                    <h3>Learning Outcomes</h3>
                    <ul>
                        <li>Advanced color recognition and naming</li>
                        <li>Sorting and categorization skills</li>
                        <li>Fine motor skills development</li>
                        <li>Vocabulary expansion</li>
                        <li>Basic literacy skills</li>
                        <li>Pattern recognition</li>
                    </ul>
                </div>

                <div class="tips-section">
                    <h3>Helpful Tips</h3>
                    <ul>
                        <li>Start with just 2-3 colors</li>
                        <li>Use clear, consistent color names</li>
                        <li>Make it fun and playful</li>
                        <li>Don't rush - let them explore</li>
                    </ul>
                </div>

                <div class="progress-tracker">
                    <h3>Colors to Practice</h3>
                    <div class="color-grid">
                        <div class="color-box" style="background: #ff6b6b;">Red</div>
                        <div class="color-box" style="background: #4dabf7;">Blue</div>
                        <div class="color-box" style="background: #ffd43b;">Yellow</div>
                        <div class="color-box" style="background: #51cf66;">Green</div>
                        <div class="color-box" style="background: #cc5de8;">Purple</div>
                        <div class="color-box" style="background: #ff922b;">Orange</div>
                    </div>
                </div>
            </div>
        </div>

        <a href="../learning-activities.php" class="back-btn">← Back to Activities</a>
    </div>

    <?php include("../includes/footer.php"); ?>
</body>
</html> 