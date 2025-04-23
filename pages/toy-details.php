<?php
session_start();
include("../includes/db.php");

// Get toy ID from URL
$toy_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch toy details
$stmt = $conn->prepare("SELECT * FROM toys WHERE id = ?");
$stmt->bind_param("i", $toy_id);
$stmt->execute();
$result = $stmt->get_result();
$toy = $result->fetch_assoc();

// Handle add to cart
if (isset($_POST['add_to_cart'])) {
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    $selected_image = $_POST['selected_image'];
    $selected_price = $_POST['selected_price'];
    
    $_SESSION['cart'][] = [
        'toy_id' => $toy_id,
        'name' => $toy['name'],
        'price' => $selected_price,
        'image' => $selected_image,
        'quantity' => 1
    ];
    
    header("Location: ../cart.php");
    exit();
}

// Get all images for the toy
$images = [];
if (isset($toy['image'])) {
    $images[] = $toy['image'];
}

// Set fixed prices for each image
$image_prices = [];

if ($toy_id == 1) { // Color Blocks
    $images = [
        '../images/images/toys/color-blocks-2.jpg',
        '../images/images/toys/color-blocks-3.jpg',
        '../images/images/toys/color-blocks-4.jpg',
        '../images/images/toys/color-blocks-5.jpg'
    ];
    $image_prices = [
        '2.99',  // color-blocks-2.jpg
        '3.49',  // color-blocks-3.jpg
        '4.25',  // color-blocks-4.jpg
        '3.99'   // color-blocks-5.jpg
    ];
} elseif ($toy_id == 2) { // Alphabet Puzzle
    $images = [
        '../images/images/toys/alphabet-puzzle-2.jpg',
        '../images/images/toys/alphabet-puzzle-3.jpg',
        '../images/images/toys/alphabet-puzzle-4.jpg',
        '../images/images/toys/alphabet-puzzle-5.jpg'
    ];
    $image_prices = [
        '2.49',  // alphabet-puzzle-2.jpg
        '3.99',  // alphabet-puzzle-3.jpg
        '4.50',  // alphabet-puzzle-4.jpg
        '3.75'   // alphabet-puzzle-5.jpg
    ];
} elseif ($toy_id == 3) { // Number Match
    $images = [
        '../images/images/toys/number-match-2.jpg',
        '../images/images/toys/number-match-3.jpg',
        '../images/images/toys/number-match-4.jpg',
        '../images/images/toys/number-match-5.jpg'
    ];
    $image_prices = [
        '2.99',  // number-match-2.jpg
        '3.25',  // number-match-3.jpg
        '4.00',  // number-match-4.jpg
        '3.50'   // number-match-5.jpg
    ];
}

// If there are additional images in the images column
if (isset($toy['images']) && !empty($toy['images'])) {
    $additional_images = explode(',', $toy['images']);
    $images = array_merge($images, $additional_images);
}

// If no images found, use a default image
if (empty($images)) {
    $images[] = 'images/images/toys/color-blocks-2.jpg';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $toy['name']; ?> - Little Learners Emporium</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .toy-details {
            max-width: 1200px;
            margin: 40px auto;
            padding: 20px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
        }

        .toy-images {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
        }

        .toy-images img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            border-radius: 8px;
            cursor: pointer;
            transition: transform 0.3s ease;
            position: relative;
        }

        .toy-images img:hover {
            transform: scale(1.05);
        }

        .toy-images img.selected {
            border: 3px solid #5db075;
            transform: scale(1.05);
        }

        .image-price {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: rgba(93, 176, 117, 0.9);
            color: white;
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .toy-info {
            padding: 20px;
        }

        .toy-info h1 {
            font-size: 2rem;
            margin-bottom: 20px;
            color: #333;
        }

        .toy-info .price {
            font-size: 1.5rem;
            color: #5db075;
            margin: 20px 0;
        }

        .toy-info .description {
            margin: 20px 0;
            line-height: 1.6;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .add-to-cart-btn, .wishlist-btn {
            flex: 1;
            padding: 15px 30px;
            border-radius: 8px;
            font-size: 1.1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            border: none;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .add-to-cart-btn {
            background: #5db075;
            color: white;
        }

        .add-to-cart-btn:hover {
            background: #46925d;
        }

        .wishlist-btn {
            background: #f8f9fa;
            color: #333;
            border: 1px solid #ddd;
        }

        .wishlist-btn:hover {
            background: #e9ecef;
        }

        .selected-image-preview {
            margin: 30px 0;
            text-align: center;
        }

        .selected-image-preview img {
            max-width: 100%;
            max-height: 500px;
            border-radius: 8px;
            display: none;
        }

        .age-group {
            display: inline-block;
            padding: 5px 10px;
            background: #f0f0f0;
            border-radius: 4px;
            margin: 10px 0;
        }

        @media (max-width: 768px) {
            .toy-details {
                grid-template-columns: 1fr;
            }
            
            .toy-images {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        .nav-container {
            background-color: #ffd9d9;
            padding: 15px 0;
            margin-bottom: 20px;
        }

        .nav-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .logo {
            font-size: 1.5rem;
            color: #333;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo i {
            font-size: 2rem;
            color: #5db075;
        }

        .nav-links {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            padding: 8px 15px;
            border-radius: 20px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            background-color: #5db075;
            color: white;
        }

        .nav-links a.active {
            background-color: #5db075;
            color: white;
        }

        .nav-links a i {
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <nav class="nav-container">
        <div class="nav-content">
            <a href="../index.php" class="logo">
                <i class="fas fa-brain"></i>
                Little Learners Emporium
            </a>
            <div class="nav-links">
                <a href="../index.php"><i class="fas fa-home"></i> Home</a>
                <a href="../catalog.php"><i class="fas fa-book"></i> Catalog</a>
                <?php if (isset($_SESSION['user'])): ?>
                    <a href="../wishlist.php"><i class="fas fa-heart"></i> Wishlist</a>
                    <a href="../cart.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                    <a href="../logout.php"><i class="fas fa-sign-out-alt"></i> Logout (<?php echo $_SESSION['user']; ?>)</a>
                <?php else: ?>
                    <a href="../login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                    <a href="../register.php"><i class="fas fa-user-plus"></i> Register</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="toy-details">
        <div class="toy-images">
            <?php 
            foreach ($images as $index => $image): 
            ?>
                <div style="position: relative;">
                    <img src="<?php echo trim($image); ?>" 
                         alt="<?php echo $toy['name']; ?> - Image <?php echo $index + 1; ?>" 
                         data-index="<?php echo $index; ?>"
                         data-price="<?php echo $image_prices[$index]; ?>"
                         onclick="selectImage(this)">
                    <div class="image-price">$<?php echo $image_prices[$index]; ?></div>
                </div>
            <?php endforeach; ?>
        </div>

        <div class="toy-info">
            <h1><?php echo $toy['name']; ?></h1>
            <div class="age-group">Age: <?php echo $toy['age_group']; ?></div>
            <div class="price" id="selectedPrice">Select an image to see price</div>
            <div class="description"><?php echo $toy['description']; ?></div>

            <div class="selected-image-preview">
                <img id="selectedImagePreview" src="" alt="Selected Image">
            </div>

            <form method="POST" action="">
                <input type="hidden" name="selected_image" id="selectedImageInput">
                <input type="hidden" name="selected_price" id="selectedPriceInput">
                <input type="hidden" name="toy_id" value="<?php echo $toy_id; ?>">
                <input type="hidden" name="toy_name" value="<?php echo $toy['name']; ?>">
                <div class="button-group">
                    <button type="button" class="wishlist-btn" onclick="addToWishlist()">
                        <i class="fas fa-heart"></i> Add to Wishlist
                    </button>
                    <button type="submit" name="add_to_cart" class="add-to-cart-btn" disabled>
                        <i class="fas fa-shopping-cart"></i> Add to Cart
                    </button>
                </div>
            </form>
        </div>
    </div>

    <?php include("../includes/footer.php"); ?>

    <script>
        function selectImage(img) {
            // Remove selected class from all images
            document.querySelectorAll('.toy-images img').forEach(i => {
                i.classList.remove('selected');
            });

            // Add selected class to clicked image
            img.classList.add('selected');

            // Get the price from data attribute
            const price = img.getAttribute('data-price');

            // Update selected image preview
            const preview = document.getElementById('selectedImagePreview');
            preview.src = img.src;
            preview.style.display = 'block';

            // Update hidden inputs with exact values
            document.getElementById('selectedImageInput').value = img.src;
            document.getElementById('selectedPriceInput').value = price;

            // Update price display
            document.getElementById('selectedPrice').textContent = '$' + price;

            // Enable add to cart button
            document.querySelector('.add-to-cart-btn').disabled = false;
        }

        function addToWishlist() {
            // Add wishlist functionality here
            alert('Added to wishlist!');
        }

        // Select first image by default if there's only one image
        if (document.querySelectorAll('.toy-images img').length === 1) {
            const firstImage = document.querySelector('.toy-images img');
            selectImage(firstImage);
        }
    </script>
</body>
</html>
