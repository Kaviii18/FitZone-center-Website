<?php
session_start();

// Ensure $loggedIn is initialized
$loggedIn = isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);

// Set username and profile photo variables
if ($loggedIn) {
    $username = isset($_SESSION['username']) ? htmlspecialchars($_SESSION['username']) : 'User';
    $profilePhoto = isset($_SESSION['profile_photo']) ? htmlspecialchars($_SESSION['profile_photo']) : 'default_profile.svg';
} else {
    $username = 'Guest';
    $profilePhoto = 'default_profile.svg';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/x-icon" href="./img/fav-icon.svg">
    <title>FitZone</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <div class="logo">
            <h1>FitZone</h1>
            <p>Transform Your Body</p>
        </div>
        <nav>
            <ul>
                <li><a href="#home">Home</a></li>
                <li><a href="#class-schedule">Schedule</a></li>
                <li><a href="#programs">Programs</a></li>
                <li><a href="#blog-posts">Blog</a></li>
                <li><a href="#about-us">About Us</a></li>
            </ul>
        </nav>
        <div class="auth-buttons">
            <?php if ($loggedIn): ?>
                <div class="user-info">
                    <span>Welcome, <?php echo $username; ?>!</span>
                    <button class="logout" onclick="location.href='./logout.php';">Logout</button>
                </div>
            <?php else: ?>
                <button class="login" onclick="location.href='./login.php';">Login</button>
                <button class="signup" onclick="location.href='./signup.php';">Sign Up</button>
            <?php endif; ?>
        </div>
    </header>
    

        <!-- Swiper CSS -->
    <link

        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
        rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    />

   
    </header>
    <main>
    <div class="hero-section">
    <div class="hero-content">
        <h1>Achieve Your <span>Fitness Goals</span> With FitZone</h1>
        <p>
            Join the FitZone community and transform your fitness journey. Our expert coaches and personalized programs are designed to help you achieve your goals and exceed your expectations. Ready to make a change?
        </p>
        <div class="cta-buttons">
            <button class="primary-btn">Start Your Journey</button>
            <button class="secondary-btn">Explore Programs</button>
        </div>
    </div>

    <!-- Swiper Container -->
    <div class="hero-image-card">
        <div class="swiper-container mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <img src="./img/hero5.jpg" alt="Image 1">
                </div>
                <div class="swiper-slide">
                    <img src="./img/hero1.jpg" alt="Image 2">
                </div>
                <div class="swiper-slide">
                    <img src="./img/hero2.jpg" alt="Image 3">
                </div>
                <div class="swiper-slide">
                    <img src="./img/hero3.jpg" alt="Image 4">
                </div>
                <div class="swiper-slide">
                    <img src="./img/hero4.jpg" alt="Image 5">
                </div>
            </div>
            <!-- Pagination -->
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>
    <!-- About Us Section -->
    <section id="about-us">
        <h2>About Us</h2>
        <p>
            Welcome to FITZONE Fitness Center, where your health and wellness are our top priority. 
            Our team is dedicated to helping you achieve your fitness goals through personalized 
            training and support. Explore our mission, vision, and meet the amazing individuals who make this possible!
        </p>

        <div class="card-container">
            <!-- Mission Card -->
            <div class="card">
                <img src="./img/mission.jpg" alt="Our Mission">
                <h3>Our Mission</h3>
                <p>
                    To inspire and empower individuals to lead healthier, happier lives by providing exceptional fitness 
                    facilities and expert guidance.
                </p>
            </div>

            <!-- Vision Card -->
            <div class="card">
                <img src="./img/vision.jpg" alt="Our Vision">
                <h3>Our Vision</h3>
                <p>
                    To be the leading fitness center in the community, fostering a culture of health and wellness 
                    for people of all ages and backgrounds.
                </p>
            </div>

            <!-- Team Card -->
            <div class="card">
                <img src="./img/team.jpg" alt="Our Team">
                <h3>Meet Our Team</h3>
                <p>
                    Our team of certified trainers and friendly staff are here to support you every step of the way 
                    on your fitness journey.
                </p>
            </div>
        </div>
    </section>

    <section id="services" class="services">
    <div class="services-header">
        <h1>Our <span>Services</span></h1>
        <p>At this part, you can easily access all of our services. Take a look at them and choose whichever you want.</p>
    </div>
    <div class="services-container">
        <div class="service-card">
            <img src="./img/losing-weight.jpg" alt="Losing Weight">
            <h2>LOSING WEIGHT</h2>
            <p>Click to join our losing weight plans. Achieve sustainable weight loss with our customized programs, designed to help you burn fat and build a healthier, leaner body. Start your journey to a fitter you today.</p>
            <button>Learn More →</button>
        </div>
        <div class="service-card">
            <img src="./img/building-muscle.jpg" alt="Building Muscle">
            <h2>BUILDING MUSCLE</h2>
            <p>Click to join our building muscle plans. Develop strength and define your muscles with tailored programs designed to help you gain lean mass efficiently. Start your journey right now.</p>
            <button>Learn More →</button>
        </div>
        <div class="service-card">
            <img src="./img/training-in-home.jpg" alt="Training in Home">
            <h2>TRAINING IN HOME</h2>
            <p>Click to see our ultimate home plans. Stay fit and strong with our effective home workout plans, requiring minimal equipment. Gain access to a lot of plans by just clicking on "Learn More".</p>
            <button>Learn More →</button>
        </div>
        <div class="service-card">
            <img src="./img/gym-plan.jpg" alt="Gym Plan">
            <h2>GYM PLAN</h2>
            <p>Click, enter your details, get your plan! Maximize your gym sessions with structured plans that guide you towards your fitness goals.</p>
            <button>Learn More →</button>
        </div>
    </div>
</section>

<section id="class-schedule" class="class-schedule">
    <div class="schedule-header">
        <h1>Class <span>Schedule</span></h1>
        <p>Explore our weekly class schedule and find the right sessions to fit your fitness journey.</p>
    </div>
    <div class="classes-container">
        <button class="scroll-btn left-scroll">&larr;</button>
        <div class="classes-scroll">
            <!-- Card 1 -->
            <div class="class-card">
                <h3>Monday</h3>
                <ul>
                    <li>6:00 AM - Yoga</li>
                    <li>8:00 AM - HIIT</li>
                    <li>6:00 PM - Strength Training</li>
                </ul>
                <button class="book-btn">Book Now</button>
            </div>
            <!-- Card 2 -->
            <div class="class-card">
                <h3>Tuesday</h3>
                <ul>
                    <li>7:00 AM - Pilates</li>
                    <li>5:00 PM - Zumba</li>
                    <li>7:00 PM - Cardio Blast</li>
                </ul>
                <button class="book-btn">Book Now</button>
            </div>
            <!-- Card 3 -->
            <div class="class-card">
                <h3>Wednesday</h3>
                <ul>
                    <li>6:00 AM - Meditation</li>
                    <li>9:00 AM - CrossFit</li>
                    <li>6:00 PM - Boxing</li>
                </ul>
                <button class="book-btn">Book Now</button>
            </div>
            <!-- Add more cards as needed -->
        </div>
        <button class="scroll-btn right-scroll">&rarr;</button>
    </div>
</section>

        <!-- Add other days in the same format -->
    </div>
</section>

<!-- Modal for Booking and Payment Form -->
<div id="class-modal" class="modal hidden">
    <div class="modal-content">
        <span class="close-btn">&times;</span>
        <h2>Book Your Class</h2>
        <form id="booking-form">
            <p><strong>Class:</strong> <span id="class-name"></span></p>
            <p><strong>Day:</strong> <span id="class-day"></span></p>
            <p><strong>Time:</strong> <span id="class-time"></span></p>

            <!-- User Details -->
            <label for="full-name">Full Name:</label>
            <input type="text" id="full-name" name="full-name" required>
            
            <label for="email">Email Address:</label>
            <input type="email" id="email" name="email" required>

            <!-- Payment Details -->
            <h3>Payment Details</h3>
            <label for="card-number">Card Number:</label>
            <input type="text" id="card-number" name="card-number" maxlength="16" required pattern="\d{16}" placeholder="1234 5678 9123 4567">

            <label for="expiry-date">Expiration Date:</label>
            <input type="month" id="expiry-date" name="expiry-date" required>

            <label for="cvv">CVV:</label>
            <input type="text" id="cvv" name="cvv" maxlength="3" required pattern="\d{3}" placeholder="123">

            <!-- Buttons -->
            <div class="form-buttons">
                <button type="submit" class="confirm-btn">Confirm Booking</button>
                <button type="reset" class="reset-btn">Reset</button>
            </div>
        </form>
    </div>
</div>

<!-- The Plans Section -->
<section id="our-plans" class="plans">
    <div class="plans-header">
        <h1>Our <span>Plans</span></h1>
        <p>Select the plan that suits your fitness goals and let our expert coaches guide you every step of the way.</p>
        <div class="toggle-buttons">
            <button class="toggle-btn active" data-plan="monthly">Monthly</button>
            <button class="toggle-btn" data-plan="annually">Annually</button>
        </div>
    </div>
    <div class="plans-container">
        <!-- Pro Plan -->
        <div class="plan-card" data-price-monthly="99" data-price-annually="999">
            <h2>Package</h2>
            <h3>PRO PLAN</h3>
            <p>Our Pro Plan offers advanced workouts and personalized nutrition coaching to help you reach your goals faster. Sign up now!</p>
            <ul>
                <li>Access to all exercise videos</li>
                <li>Progress tracking</li>
                <li>Supportive online community</li>
                <li>Personalized workout plans</li>
                <li>Nutrition coaching</li>
                <li>Body composition analysis</li>
            </ul>
            <div class="price"><span class="price-value">99</span>$<span>/USDT</span></div>
            <form action="payment_form.php" method="POST">
                <input type="hidden" name="plan_name" value="PRO PLAN">
                <input type="hidden" name="plan_price" value="99">
                <input type="hidden" name="plan_duration" value="monthly">
                <button type="submit">Choose This Plan</button>
            </form>
        </div>

        <!-- Custom Plan -->
        <div class="plan-card" data-price-monthly="149" data-price-annually="1499">
            <h2>Package</h2>
            <h3>CUSTOM PLAN</h3>
            <p>Experience a fully tailored fitness experience with our custom plan. Work one-on-one with a dedicated trainer to achieve your goals.</p>
            <ul>
                <li>Access to all exercise videos</li>
                <li>Progress tracking</li>
                <li>Supportive online community</li>
                <li>Customized workout and nutrition plan</li>
                <li>Weekly trainer check-ins</li>
                <li>Exclusive gear discounts</li>
            </ul>
            <div class="price"><span class="price-value">149</span>$<span>/USDT</span></div>
            <form action="payment_form.php" method="POST">
                <input type="hidden" name="plan_name" value="CUSTOM PLAN">
                <input type="hidden" name="plan_price" value="149">
                <input type="hidden" name="plan_duration" value="monthly">
                <button type="submit">Choose This Plan</button>
            </form>
        </div>

        <!-- Beginner Plan -->
        <div class="plan-card" data-price-monthly="49" data-price-annually="499">
            <h2>Package</h2>
            <h3>BEGINNER PLAN</h3>
            <p>Start your fitness journey with our beginner plan. Build a strong foundation with basic workouts and nutrition guidance.</p>
            <ul>
                <li>Access to all exercise videos</li>
                <li>Progress tracking</li>
                <li>Supportive online community</li>
                <li>Basic nutrition guidance</li>
                <li>Group fitness classes</li>
            </ul>
            <div class="price"><span class="price-value">49</span>$<span>/USDT</span></div>
            <form action="payment_form.php" method="POST">
                <input type="hidden" name="plan_name" value="BEGINNER PLAN">
                <input type="hidden" name="plan_price" value="49">
                <input type="hidden" name="plan_duration" value="monthly">
                <button type="submit">Choose This Plan</button>
            </form>
        </div>
    </div>
</section>


    <section class="fitness-tools">
    <h1>Our <span>Fitness Tools</span></h1>
    <p>Access a variety of tools to help you reach your fitness goals more effectively.</p>
    <div class="tools-container">
        <div class="tool-card">
            <img src="./img/calorie-calculator-icon.png" alt="Calorie Calculator">
            <h3>CALORIE CALCULATOR</h3>
            <a href="#">Learn More →</a>
        </div>
        <div class="tool-card">
            <img src="./img/bmi-calculator-icon.png" alt="BMI Calculator">
            <h3>BMI CALCULATOR</h3>
            <a href="#">Learn More →</a>
        </div>
        <div class="tool-card">
            <img src="./img/macro-calculator-icon.png" alt="Macronutrient Calculator">
            <h3>MACRONUTRIENT CALCULATOR</h3>
            <a href="#">Learn More →</a>
        </div>
        <div class="tool-card">
            <img src="./img/goal-setting-tool-icon.png" alt="Goal Setting Tool">
            <h3>GOAL SETTING TOOL</h3>
            <a href="#">Learn More →</a>
        </div>
    </div>
</section>

<section class="customer-reviews">
    <h1>What Our <span>Customers Say</span></h1>
    <p>At this part, you can see a few of the many positive reviews of our customers.</p>
    <div class="review-container">
        <div class="review-text">
            <h2>Steven Haward</h2>
            <p>Our Trainer</p>
            <p>
                "I've been using FitZone for the past three months, and I'm genuinely impressed. The website is easy to navigate, and everything is laid out clearly. I purchased the Premium Plan, and the personalized coaching has been a game-changer for me..."
            </p>
        </div>
        <div class="review-images">
            <div class="image-card active">
                <img src="./img/reviewer1.jpg" alt="Steven Haward">
                <p>Steven Haward</p>
            </div>
            <div class="image-card">
                <img src="./img/reviewer2.jpg" alt="Josh Oliver">
                <p>Josh Oliver</p>
            </div>
            <div class="image-card">
                <img src="./img/reviewer3.jpg" alt="Edward Hawley">
                <p>Edward Hawley</p>
            </div>
        </div>
    </div>
    <div class="review-controls">
        <button class="prev-btn">←</button>
        <button class="next-btn">→</button>
    </div>
</section>

<section class="trainers">
    <h1>Meet Our <span>Trainers</span></h1>
    <p>At this part, you can see a few of the many positive reviews of our customers.</p>
    <div class="trainers-container">
        <div class="trainer-card">
            <img src="./img/trainer1.jpg" alt="Sam Cole">
            <h3>Sam Cole</h3>
            <p>Personal Trainer</p>
            <a href="#">Learn More →</a>
        </div>
        <div class="trainer-card">
            <img src="./img/trainer2.jpg" alt="Michael Harris">
            <h3>Michael Harris</h3>
            <p>Personal Trainer</p>
            <a href="#">Learn More →</a>
        </div>
        <div class="trainer-card">
            <img src="./img/trainer3.jpg" alt="John Anderson">
            <h3>John Anderson</h3>
            <p>Personal Trainer</p>
            <a href="#">Learn More →</a>
        </div>
        <div class="trainer-card">
            <img src="./img/trainer4.jpg" alt="Tom Blake">
            <h3>Tom Blake</h3>
            <p>Personal Trainer</p>
            <a href="#">Learn More →</a>
        </div>
    </div>
    <div class="carousel-controls">
        <button class="prev-btn">←</button>
        <button class="next-btn">→</button>
    </div>
    <div class="view-all">
        <a href="#">View All →</a>
    </div>
</section>

<section id="blog-posts"  class="blog-posts">
    <h1>FitZone <span>Blog Posts</span></h1>
    <p class="blog-intro">Discover Essential Tips To Maximize Your Workout Results And Reach Your Fitness Goals Faster.</p>
    <div class="blog-container">
        <!-- Featured Card -->
        <div class="blog-card featured">
            <img src="./img/blog1.jpg" alt="Feature Image">
            <div class="blog-content">
                <h3>5 Essential Exercises For Building Muscle</h3>
                <div class="metadata">
                    <span><i class="fa fa-calendar"></i> August 14</span>
                    <span><i class="fa fa-dumbbell"></i> Strength Training</span>
                </div>
                <a href="#" class="learn-more">Learn More</a>
            </div>
        </div>
        <!-- Blog Posts -->
        <div class="blog-right">
            <div class="blog-card">
                <img src="./img/blog2.jpg" alt="Post 1">
                <div class="blog-content">
                    <h3>The Ultimate Guide To A Balanced Diet</h3>
                    <span><i class=" Nutrition"></i> 🍴 Nutrition</span>
                    <a href="#" class="learn-more">Learn More</a>
                </div>
            </div>
            <div class="blog-card">
                <img src="./img/blog3.jpg" alt="Post 2">
                <div class="blog-content">
                    <h3>The Benefits Of HIIT Training</h3>
                    <span><i class="  Cardio"></i> 🏃 Cardio</span>
                    <a href="#" class="learn-more">Learn More</a>
                </div>
            </div>
            <div class="blog-card">
                <img src="./img/blog4.jpg" alt="Post 3">
                <div class="blog-content">
                    <h3>Home Workouts For Busy People</h3>
                    <span><i class=" Home Workouts "></i> 🏠 Home Workouts</span>
                    <a href="#" class="learn-more">Learn More</a>
                   
                </div>
            </div>
            <div class="blog-card">
                <img src="./img/blog5.jpg" alt="Post 4">
                <div class="blog-content">
                    <h3>How To Always Stay Motivated</h3>
                    <span><i class=" Motivation  "></i> 💪 Motivation</span>
                    <a href="#" class="learn-more">Learn More</a>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="fitness-community" section class="fitness-community">
        <h1>Join Our <span>Fitness Community</span></h1>
        <p>Sign up now to unlock exclusive access to personalized workout plans, expert coaching, and a supportive community that will help you achieve your fitness goals.</p>
        <div class="community-container">
            <div class="features">
                <div class="feature-card">
                    <h3>Personalized Workout Plans</h3>
                    <p>Customized routines that match your fitness level and goals, ensuring you achieve the best results in the most efficient way.</p>
                </div>
                <div class="feature-card">
                    <h3>Expert Coaching</h3>
                    <p>Work with certified trainers who will guide you every step of the way to ensure you’re on the right track.</p>
                </div>
                <div class="feature-card">
                    <h3>Community Support</h3>
                    <p>Join a vibrant community of fitness enthusiasts where you can share experiences, get motivated, and stay inspired.</p>
                </div>
                <div class="feature-card">
                    <h3>Exclusive Resources</h3>
                    <p>Access premium content, including video tutorials, nutrition guides, and member-only discounts on fitness gear.</p>
                </div>
            </div>
            <div class="signup-form">
                <div class="form-header">
                    <h2>Sign Up</h2>
                    <a href="#">Login</a>
                </div>
                <form>
                    <input type="text" placeholder="Enter Your Name" required>
                    <input type="email" placeholder="Enter Your E-Mail" required>
                    <button type="submit">Sign Up</button>
                    <div class="social-login">
                        <p>Or</p>
                        <button type="button">Sign Up With Google</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

<section class="faq">
    <h1>FAQ</h1>
    <div class="faq-container">
        <div class="faq-item">
            <div class="faq-question">
                What Is FitZone And How Can It Help Me Reach My Fitness Goals?
                <span class="arrow">▼</span>
            </div>
            <div class="faq-answer">
                FitZone is an online fitness platform that offers personalized workout plans, expert coaching, and comprehensive nutritional guidance.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                How Do I Get Started With A Workout Plan On FitZone?
                <span class="arrow">▼</span>
            </div>
            <div class="faq-answer">
                Getting started is easy! Sign up, select your plan, and begin your journey to a healthier lifestyle with our expert-designed programs.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                What Is Included In The Custom Plan?
                <span class="arrow">▼</span>
            </div>
            <div class="faq-answer">
                The custom plan includes a personalized workout and meal plan tailored to your goals, progress tracking, and weekly check-ins with a trainer.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                Can I Change My Plan After Signing Up?
                <span class="arrow">▼</span>
            </div>
            <div class="faq-answer">
                Yes, you can change your plan at any time by contacting support or navigating to your account settings.
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                What Kind Of Support Can I Expect From My Trainer?
                <span class="arrow">▼</span>
            </div>
            <div class="faq-answer">
                Our trainers provide personalized guidance, answer your questions, and offer motivation to help you stay on track.
            </div>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="footer-container">
        <!-- Footer Logo and About Section -->
        <div class="footer-logo">
            <h1><span style="color: #4CAF50;">Fit</span>Zone</h1>
            <p>Transform Your Body</p>
            <p>
                Achieve your fitness goals with <strong>FitZone</strong>, your trusted partner in fitness.
                With over <span style="color: red;">5 Years</span> of expertise, we provide expert coaching,
                personalized workout plans, and comprehensive nutritional guidance.
                <br />
                <a href="#">Join Our Community</a> and start your journey today!
            </p>
            <div class="social-icons">
                <a href="https://www.facebook.com" target="_blank" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                <a href="https://www.instagram.com" target="_blank" class="social-icon"><i class="fab fa-instagram"></i></a>
                <a href="https://www.twitter.com" target="_blank" class="social-icon"><i class="fab fa-twitter"></i></a>
                <a href="https://www.youtube.com" target="_blank" class="social-icon"><i class="fab fa-youtube"></i></a>
                <a href="https://www.linkedin.com" target="_blank" class="social-icon"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>

        <!-- Footer Links Section -->
        <div class="footer-links">
            <div class="footer-column">
                <h3>Company</h3>
                <ul>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Our Services</a></li>
                    <li><a href="#">Careers</a></li>
                    <li><a href="#">Blog</a></li>
                    <li><a href="#">Testimonials</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Resources</h3>
                <ul>
                    <li><a href="#">Fitness Tools</a></li>
                    <li><a href="#">Workout Videos</a></li>
                    <li><a href="#">Nutrition Guides</a></li>
                    <li><a href="#">FAQ</a></li>
                    <li><a href="#">Success Stories</a></li>
                    <li><a href="#">Membership</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Programs</h3>
                <ul>
                    <li><a href="#">Weight Loss</a></li>
                    <li><a href="#">Building Muscles</a></li>
                    <li><a href="#">Home Workouts</a></li>
                    <li><a href="#">Gym Plans</a></li>
                    <li><a href="#">Our Plans</a></li>
                    <li><a href="#">Fitness Groups</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact Us</h3>
                <ul>
                    <li><i class="fas fa-map-marker-alt"></i> Srilanka-Kurunagala</li>
                    <li><i class="fas fa-phone"></i> 077-5678912</li>
                    <li><i class="fas fa-envelope"></i> FitZoneinfo@Gmail.com</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2024 FitZone. All rights reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a></p>
    </div>
</footer>






<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        var swiper = new Swiper(".mySwiper", {
            effect: "coverflow", /* Enables coverflow effect */
            grabCursor: true, /* Cursor behaves like grabbing */
            centeredSlides: true, /* Center the active slide */
            slidesPerView: "auto", /* Show partial slides on both sides */
            coverflowEffect: {
                rotate: 0, /* Disable rotation for modern look */
                stretch: 0, /* No stretching */
                depth: 100, /* Adds 3D depth to slides */
                modifier: 1, /* Controls the effect intensity */
                slideShadows: false /* No shadows for cleaner look */
            },
            loop: true, /* Loop slides infinitely */
            autoplay: {
                delay: 3000, /* Automatic slide every 3 seconds */
                disableOnInteraction: false, /* Keep autoplay on user interaction */
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true, /* Allow clicking on pagination bullets */
            },
        });
    });


    var swiper = new Swiper('.mySwiper', {
        effect: 'coverflow',        // Enable 3D coverflow effect
        centeredSlides: true,       // Center the active slide
        slidesPerView: 2.5,         // Show side slides partially (adjust as needed)
        loop: true,                 // Enable infinite sliding
        coverflowEffect: {
            rotate: 0,              // No tilt rotation
            stretch: 50,            // Space between slides (adjust for visibility)
            depth: 200,             // Depth for 3D effect
            modifier: 1,            // Scale effect intensity
            slideShadows: true      // Add shadows for 3D effect
        },
        pagination: {
            el: '.swiper-pagination', // Enable pagination
            clickable: true           // Make pagination dots clickable
        },
        autoplay: {
            delay: 3000,              // Auto-slide every 3 seconds
            disableOnInteraction: false
        },
        grabCursor: true,             // Change cursor to grab
        speed: 800                    // Transition speed
    });
</script>

    <!-- Link to External JavaScript -->
    <script src="script.js"></script>


</body>
</html>
