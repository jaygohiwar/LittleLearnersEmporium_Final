<?php
// No session_start() here - it's handled in the main files

// Get cart count if user is logged in
$cart_count = 0;
if (isset($_SESSION['user_id'])) {
    require_once 'db_connection.php';
    $stmt = $conn->prepare("SELECT SUM(quantity) as total FROM cart WHERE user_id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $cart_count = $result->fetch_assoc()['total'] ?? 0;
    $stmt->close();
}
?>

<header style="background: #ffccbc; padding: 15px 0; font-family: 'Comic Sans MS', cursive;">
  <div style="max-width: 1100px; margin: auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px;">
    
    <h1 style="margin: 0; font-size: 1.8rem; color: #5d4037;">
      <a href="/LittleLearnersEmporium_Final/index.php" style="text-decoration: none; color: inherit;">
        🧠 Little Learners Emporium
      </a>
    </h1>

    <nav>
      <a href="/LittleLearnersEmporium_Final/index.php" style="margin: 0 12px; color: #4e342e; text-decoration: none; font-weight: bold;">🏠 Home</a>
      <a href="/LittleLearnersEmporium_Final/catalog.php" style="margin: 0 12px; color: #4e342e; text-decoration: none; font-weight: bold;">🧸 Catalog</a>
      
      <?php if (isset($_SESSION['user_email'])): ?>
        <a href="/LittleLearnersEmporium_Final/wishlist.php" style="margin: 0 12px; color: #4e342e; text-decoration: none; font-weight: bold;">💖 Wishlist</a>
        <a href="/LittleLearnersEmporium_Final/cart.php" style="margin: 0 12px; color: #4e342e; text-decoration: none; font-weight: bold; position: relative;">
          🛒 Cart
          <?php if ($cart_count > 0): ?>
            <span class="cart-count" style="position: absolute; top: -8px; right: -8px; background: #e53935; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px;"><?php echo $cart_count; ?></span>
          <?php endif; ?>
        </a>
        <a href="/LittleLearnersEmporium_Final/games.php" style="margin: 0 12px; color: #4e342e; text-decoration: none; font-weight: bold;">🎮 Games</a>
        <span style="margin: 0 12px; color: #2e7d32;">👋 <?php echo htmlspecialchars($_SESSION['user_email']); ?></span>
        <a href="/LittleLearnersEmporium_Final/logout.php" style="margin: 0 12px; color: #e53935; text-decoration: none; font-weight: bold;">🚪 Logout</a>
      <?php else: ?>
        <a href="/LittleLearnersEmporium_Final/login.php" style="margin: 0 12px; color: #2e7d32; text-decoration: none; font-weight: bold;">🔐 Login</a>
        <a href="/LittleLearnersEmporium_Final/register.php" style="margin: 0 12px; color: #1565c0; text-decoration: none; font-weight: bold;">📝 Register</a>
      <?php endif; ?>
    </nav>
  </div>
</header>
