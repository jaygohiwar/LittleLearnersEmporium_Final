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
    <title>Texture Explorer Activity - Little Learners Emporium</title>
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

        .texture-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-top: 20px;
        }

        .texture-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            text-align: center;
        }

        .texture-box img {
            width: 60px;
            height: 60px;
            margin-bottom: 10px;
        }

        .texture-box p {
            font-size: 0.9rem;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="activity-container">
        <div class="activity-header">
            <h1>👋 Texture Explorer</h1>
            <span class="age-tag">Age Group: 3-5 Years</span>
        </div>

        <img src="../images/activities/icons/texture-play.jpg" alt="Texture Play Activity" class="activity-image">

        <div class="activity-content">
            <div class="activity-description">
                <div class="materials-list">
                    <h3>Materials Needed:</h3>
                    <ul>
                        <li>Various textured materials (smooth, rough, bumpy, soft)</li>
                        <li>Texture cards with descriptive words</li>
                        <li>Art supplies for texture rubbings</li>
                        <li>Sorting mats with texture categories</li>
                        <li>Texture matching cards</li>
                        <li>Simple texture-related worksheets</li>
                    </ul>
                </div>

                <div class="instructions">
                    <h3>Activity Steps:</h3>
                    <ol>
                        <li>Introduce different textures with their descriptive words</li>
                        <li>Practice identifying textures through touch and sight</li>
                        <li>Sort objects by their textures into categories</li>
                        <li>Create texture rubbings using crayons and paper</li>
                        <li>Play texture matching games with cards</li>
                        <li>Practice using descriptive words in complete sentences</li>
                        <li>Create a texture collage with various materials</li>
                    </ol>
                </div>

                <div class="safety-note">
                    <h4>Learning Tips:</h4>
                    <p>Encourage children to describe textures using rich vocabulary and make connections to everyday objects. Incorporate texture-related stories and songs into the activity.</p>
                </div>
            </div>

            <div class="activity-sidebar">
                <div class="learning-outcomes">
                    <h3>Learning Outcomes</h3>
                    <ul>
                        <li>Advanced sensory discrimination</li>
                        <li>Descriptive vocabulary development</li>
                        <li>Scientific observation skills</li>
                        <li>Fine motor skills</li>
                        <li>Classification abilities</li>
                        <li>Creative expression</li>
                    </ul>
                </div>

                <div class="tips-section">
                    <h3>Helpful Tips</h3>
                    <ul>
                        <li>Start with familiar textures</li>
                        <li>Use simple descriptive words</li>
                        <li>Follow your child's lead</li>
                        <li>Keep sessions short and fun</li>
                    </ul>
                </div>

                <div class="texture-grid">
                    <div class="texture-box">
                        <img src="../images/activities/icons/soft-textures.jpg" alt="Soft">
                        <p>Soft Textures</p>
                    </div>
                    <div class="texture-box">
                        <img src="../images/activities/icons/smooth-textures.jpg" alt="Smooth">
                        <p>Smooth Textures</p>
                    </div>
                    <div class="texture-box">
                        <img src="../images/activities/icons/rough-textures.jpg" alt="Rough">
                        <p>Rough Textures</p>
                    </div>
                    <div class="texture-box">
                        <img src="../images/activities/icons/bumpy-textures.jpg" alt="Bumpy">
                        <p>Bumpy Textures</p>
                    </div>
                </div>
            </div>
        </div>

        <a href="../learning-activities.php" class="back-btn">← Back to Activities</a>
    </div>

    <?php include("../includes/footer.php"); ?>
</body>
</html> 