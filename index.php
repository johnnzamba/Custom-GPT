<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>CUSTOM GPT - Your Personal AI Assistant</title>
<meta name="description" content="Empower your productivity with a personalized AI assistant.">
<meta name="keywords" content="AI assistant, chatbot, artificial intelligence, productivity tool">


  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">

  <link href="assets/css/main.css" rel="stylesheet">
  <style>
    body, html {
        height: 100%;
        margin: 0;
        font-family: Arial, Helvetica, sans-serif;
    }
    .chat-container {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        height: calc(100vh - 60px);
        background: #1a1a1a;
        color: #fff;
        padding: 20px;
    }
    .chat-output {
        flex: 1;
        overflow-y: auto;
        background: #333;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .chat-input-form {
        display: flex;
        align-items: center;
    }
    .chat-input {
        flex: 1;
        padding: 10px;
        border: none;
        background: #ffffff;
        color: #000000;
        border-top-left-radius: 8px;
        border-bottom-left-radius: 8px;
    }
    .chat-submit {
        padding: 10px 20px;
        background: #444;
        border: none;
        color: #fff;
        cursor: pointer;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }
    .user-message {
        text-align: right;
        margin: 5px 0;
    }
    .bot-message {
        text-align: left;
        margin: 5px 0;
    }
    .speech-bubble {
    background-color: #f1f1f1;
    border-radius: 10px;
    padding: 10px;
    margin: 10px 0;
    max-width: 80%;
    word-wrap: break-word;
    color: #333; /* Adjust text color for readability */
    position: relative; /* Positioning for tail */
}

/* Adjust speech bubble styles for bot messages */
.bot-message .speech-bubble {
    background-color: #4CAF50;
    color: #fff; 
}
.speech-bubble::after {
    content: '';
    position: absolute;
    bottom: -15px; 
    left: 10%;
    border-width: 10px; 
    border-style: solid;
    border-color: #f1f1f1 transparent transparent transparent; 
}


    .loading-spinner {
        border: 4px solid rgba(255, 255, 255, 0.3);
        border-left-color: #fff;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        animation: spin 1s linear infinite;
        display: inline-block;
        margin-left: 10px;
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
  <script src="script.js" defer></script>
</head>
<body class="index-page">
  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">
      <nav id="navmenu" class="navmenu">
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
    </div>
  </header>

  <div class="chat-container">
    <div id="chat-output" class="chat-output"></div>
    <form id="chat-form" class="chat-input-form">
        <input type="text" id="chat-input" class="chat-input form-control" placeholder="Type your message here" autocomplete="off" aria-label="Type your message here" aria-describedby="button-send">
        <button type="submit" class="chat-submit btn btn-primary"><i class="bi bi-arrow-right-circle"></i> Send</button>
    </form>
    </div>
</body>

  <footer id="footer" class="footer dark-background">
    <div class="footer-top">
        <div class="container">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="index.html" class="logo d-flex align-items-center">
                        <span class="sitename">CUSTOM GPT</span>
                    </a>
                </div>
                <div class="col-lg-10 col-md-13 footer-newsletter">
                    <h4>Our Newsletter</h4>
                    <p>Subscribe by email</p>
                    <form action="subscribe.php" method="post" id="newsletter-form">
                        <input type="email" name="email" placeholder="Your Email" required>
                        <input type="submit" value="Subscribe">
                    </form>
                    <div id="newsletter-message"></div>
                </div>
            </div>
        </div>
    </div>
</footer>
<script>
document.getElementById('newsletter-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this);
    const email = formData.get('email');
    const messageDiv = document.getElementById('newsletter-message');

    // Show loading spinner
    messageDiv.innerHTML = '<div class="loading-spinner"></div>';

    fetch('subscribe.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.error === false) {
            messageDiv.innerHTML = '<p>Successfully subscribed to the newsletter!</p>';
        } else {
            messageDiv.innerHTML = '<p>Subscription failed. Please try again.</p>';
        }
    })
    .catch(error => {
        messageDiv.innerHTML = '<p>An error occurred. Please try again.</p>';
        console.error('Error:', error);
    });
});
</script>

<!-- Vendor JS Files -->

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/vendor/aos/aos.js"></script>
<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
<script src="assets/vendor/glightbox/js/glightbox.min.js"></script>

<!-- Main JS File -->
<script src="assets/js/main.js"></script>


</html>
