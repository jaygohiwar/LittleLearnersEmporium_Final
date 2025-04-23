<div class="newsletter-section">
    <h2>Stay Updated!</h2>
    <p>Subscribe to our newsletter for exclusive offers and new arrivals</p>
    <div class="subscription-form">
        <input type="email" id="subscribe-email" placeholder="Enter your email" value="">
        <button onclick="subscribe()" class="subscribe-btn">Subscribe</button>
    </div>
    <div id="subscription-message"></div>
</div>

<style>
.newsletter-section {
    background-color: #ef5350;
    color: white;
    padding: 60px 20px;
    text-align: center;
}

.newsletter-section h2 {
    font-size: 2.5em;
    margin-bottom: 15px;
}

.subscription-form {
    max-width: 500px;
    margin: 20px auto;
    display: flex;
    gap: 10px;
}

#subscribe-email {
    flex: 1;
    padding: 12px 15px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
}

.subscribe-btn {
    padding: 12px 30px;
    background-color: #4e342e;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.subscribe-btn:hover {
    background-color: #3e2723;
}

#subscription-message {
    margin-top: 15px;
    padding: 10px;
    border-radius: 8px;
    display: none;
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
}

#subscription-message.success {
    background-color: #4CAF50;
    color: white;
}

#subscription-message.error {
    background-color: #f44336;
    color: white;
}

@media (max-width: 600px) {
    .subscription-form {
        flex-direction: column;
        padding: 0 20px;
    }
    
    .subscribe-btn {
        width: 100%;
    }
}
</style>

<script>
function subscribe() {
    const email = document.getElementById('subscribe-email').value.trim();
    const messageDiv = document.getElementById('subscription-message');
    
    if (!email) {
        showMessage('Please enter your email address', false);
        return;
    }
    
    // Basic email validation
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        showMessage('Please enter a valid email address', false);
        return;
    }
    
    fetch('subscribe.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email: email })
    })
    .then(response => response.json())
    .then(data => {
        showMessage(data.message, data.success);
        if (data.success) {
            document.getElementById('subscribe-email').value = '';
        }
    })
    .catch(error => {
        showMessage('Error subscribing. Please try again later.', false);
        console.error('Error:', error);
    });
}

function showMessage(message, isSuccess) {
    const messageDiv = document.getElementById('subscription-message');
    messageDiv.textContent = message;
    messageDiv.className = isSuccess ? 'success' : 'error';
    messageDiv.style.display = 'block';
    
    setTimeout(() => {
        messageDiv.style.display = 'none';
    }, 5000);
}
</script> 