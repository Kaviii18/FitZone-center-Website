document.addEventListener("DOMContentLoaded", function () {
    // Select all navigation links
    const navLinks = document.querySelectorAll("nav ul li a");

    // Add a click event listener to each link
    navLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault(); // Prevent default anchor behavior

            // Get the target section ID
            const targetID = this.getAttribute("data-target");
            const targetSection = document.getElementById(targetID);

            // Smoothly scroll to the section
            if (targetSection) {
                window.scrollTo({
                    top: targetSection.offsetTop - 50, // Adjust for fixed header
                    behavior: "smooth"
                });
            }
        });
    });
});








document.addEventListener("DOMContentLoaded", () => {
    const scrollContainer = document.querySelector(".classes-scroll");
    const leftScrollBtn = document.querySelector(".left-scroll");
    const rightScrollBtn = document.querySelector(".right-scroll");

    // Scroll left
    leftScrollBtn.addEventListener("click", () => {
        scrollContainer.scrollBy({
            left: -300, // Adjust scroll distance as needed
            behavior: "smooth",
        });
    });

    // Scroll right
    rightScrollBtn.addEventListener("click", () => {
        scrollContainer.scrollBy({
            left: 300, // Adjust scroll distance as needed
            behavior: "smooth",
        });
    });
});



document.addEventListener("DOMContentLoaded", () => {
    const bookButtons = document.querySelectorAll(".book-btn");
    const modal = document.getElementById("class-modal");
    const closeModalBtn = modal.querySelector(".close-btn");
    const bookingForm = document.getElementById("booking-form");

    // Modal fields
    const classNameField = document.getElementById("class-name");
    const classDayField = document.getElementById("class-day");
    const classTimeField = document.getElementById("class-time");

    // Open modal and populate details
    bookButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const className = button.getAttribute("data-class");
            const classTime = button.getAttribute("data-time");
            const classDay = button.getAttribute("data-day");

            classNameField.textContent = className;
            classDayField.textContent = classDay;
            classTimeField.textContent = classTime;

            modal.classList.remove("hidden");
        });
    });

    // Close modal
    closeModalBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // Handle form submission
    bookingForm.addEventListener("submit", (event) => {
        event.preventDefault(); // Prevent page reload

        const formData = new FormData(bookingForm);
        const fullName = formData.get("full-name");
        const email = formData.get("email");
        const cardNumber = formData.get("card-number");
        const expiryDate = formData.get("expiry-date");
        const cvv = formData.get("cvv");

        // Simulate payment processing and booking confirmation
        alert(
            `Booking Confirmed!\n\nClass: ${classNameField.textContent}\nDay: ${classDayField.textContent}\nTime: ${classTimeField.textContent}\nName: ${fullName}\nEmail: ${email}\nCard: ${cardNumber.replace(
                /\d{12}(\d{4})/,
                "**** **** **** $1"
            )}\nExpiry: ${expiryDate}\nCVV: ${cvv}`
        );

        // Reset form and close modal
        bookingForm.reset();
        modal.classList.add("hidden");
    });

    // Close modal by clicking outside the content
    window.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.classList.add("hidden");
        }
    });
});






document.addEventListener("DOMContentLoaded", () => {
    const bookButtons = document.querySelectorAll(".book-btn");
    const modal = document.getElementById("class-modal");
    const closeModalBtn = modal.querySelector(".close-btn");
    const confirmBtn = modal.querySelector(".confirm-btn");

    // Modal fields
    const classNameField = document.getElementById("class-name");
    const classDayField = document.getElementById("class-day");
    const classTimeField = document.getElementById("class-time");

    // Open modal and populate details
    bookButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const className = button.getAttribute("data-class");
            const classTime = button.getAttribute("data-time");
            const classDay = button.getAttribute("data-day");

            classNameField.textContent = className;
            classDayField.textContent = classDay;
            classTimeField.textContent = classTime;

            modal.classList.remove("hidden");
        });
    });

    // Close modal
    closeModalBtn.addEventListener("click", () => {
        modal.classList.add("hidden");
    });

    // Confirm booking (placeholder functionality)
    confirmBtn.addEventListener("click", () => {
        alert("Your booking has been confirmed!");
        modal.classList.add("hidden");
    });

    // Close modal by clicking outside the content
    window.addEventListener("click", (event) => {
        if (event.target === modal) {
            modal.classList.add("hidden");
        }
    });
});



document.addEventListener("DOMContentLoaded", function () {
    const toggleButtons = document.querySelectorAll(".toggle-btn");
    const priceElements = document.querySelectorAll(".plan-card .price");

    // Prices for Monthly and Annually
    const prices = {
        monthly: ["99$", "149$", "49$"],
        annually: ["999$", "1499$", "499$"], // Annual prices
    };

    // Function to update prices
    const updatePrices = (billingCycle) => {
        priceElements.forEach((priceElement, index) => {
            priceElement.innerHTML = prices[billingCycle][index] + "<span>/USDT</span>";
        });
    };

    // Add event listeners to toggle buttons
    toggleButtons.forEach((button) => {
        button.addEventListener("click", () => {
            // Remove active class from all buttons
            toggleButtons.forEach((btn) => btn.classList.remove("active"));

            // Add active class to the clicked button
            button.classList.add("active");

            // Update prices based on selected billing cycle
            const billingCycle = button.textContent.trim().toLowerCase();
            updatePrices(billingCycle);
        });
    });

    // Set default to Monthly
    updatePrices("monthly");
});


document.addEventListener("DOMContentLoaded", function () {
    const imageCards = document.querySelectorAll(".image-card");
    const reviewText = document.querySelector(".review-text");
    const reviews = [
        {
            name: "Steven Haward",
            role: "Our Trainer",
            text: "I've been using FitZone for the past three months, and I'm genuinely impressed. The website is easy to navigate, and everything is laid out clearly. I purchased the Premium Plan, and the personalized coaching has been a game-changer for me...",
        },
        {
            name: "Josh Oliver",
            role: "Fitness Enthusiast",
            text: "FitZone has completely changed the way I approach my fitness journey. The tools are intuitive, and the trainers are highly professional. My results speak for themselves!",
        },
        {
            name: "Edward Hawley",
            role: "Beginner Trainer",
            text: "As someone new to fitness, FitZone has been my best investment. Their beginner programs and support system have made my journey smooth and rewarding.",
        },
    ];

    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");

    let currentIndex = 0;

    const updateReview = (index) => {
        reviewText.querySelector("h2").textContent = reviews[index].name;
        reviewText.querySelector("p:nth-of-type(1)").textContent = reviews[index].role;
        reviewText.querySelector("p:nth-of-type(2)").textContent = reviews[index].text;

        imageCards.forEach((card, i) => {
            card.classList.toggle("active", i === index);
        });
    };

    prevBtn.addEventListener("click", () => {
        currentIndex = (currentIndex - 1 + reviews.length) % reviews.length;
        updateReview(currentIndex);
    });

    nextBtn.addEventListener("click", () => {
        currentIndex = (currentIndex + 1) % reviews.length;
        updateReview(currentIndex);
    });

    // Set the initial review
    updateReview(currentIndex);
});


document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".trainers-container");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");

    let scrollAmount = 0;

    const scrollStep = container.offsetWidth / 4; // Scroll one card at a time

    prevBtn.addEventListener("click", () => {
        scrollAmount -= scrollStep;
        if (scrollAmount < 0) scrollAmount = 0;
        container.scrollTo({
            left: scrollAmount,
            behavior: "smooth",
        });
    });

    nextBtn.addEventListener("click", () => {
        scrollAmount += scrollStep;
        if (scrollAmount > container.scrollWidth - container.offsetWidth) {
            scrollAmount = container.scrollWidth - container.offsetWidth;
        }
        container.scrollTo({
            left: scrollAmount,
            behavior: "smooth",
        });
    });
});


document.addEventListener("DOMContentLoaded", () => {
    const container = document.querySelector(".blog-container");
    const prevBtn = document.querySelector(".prev-btn");
    const nextBtn = document.querySelector(".next-btn");

    const cardWidth = container.querySelector(".blog-card").offsetWidth + 20; // Card width + gap
    let scrollPosition = 0;

    // Function to scroll left
    const scrollLeft = () => {
        scrollPosition -= cardWidth;
        if (scrollPosition < 0) scrollPosition = 0; // Prevent scrolling before the first card
        container.scrollTo({
            left: scrollPosition,
            behavior: "smooth",
        });
    };

    // Function to scroll right
    const scrollRight = () => {
        scrollPosition += cardWidth;
        const maxScroll = container.scrollWidth - container.clientWidth;
        if (scrollPosition > maxScroll) scrollPosition = maxScroll; // Prevent scrolling past the last card
        container.scrollTo({
            left: scrollPosition,
            behavior: "smooth",
        });
    };

    // Attach event listeners
    prevBtn.addEventListener("click", scrollLeft);
    nextBtn.addEventListener("click", scrollRight);
});


document.addEventListener("DOMContentLoaded", () => {
    const faqItems = document.querySelectorAll(".faq-item");

    faqItems.forEach((item) => {
        const question = item.querySelector(".faq-question");
        const answer = item.querySelector(".faq-answer");
        const arrow = item.querySelector(".arrow");

        question.addEventListener("click", () => {
            const isOpen = answer.style.display === "block";
            faqItems.forEach((i) => {
                i.querySelector(".faq-answer").style.display = "none";
                i.querySelector(".arrow").textContent = "▼";
            });

            if (!isOpen) {
                answer.style.display = "block";
                arrow.textContent = "▲";
            } else {
                answer.style.display = "none";
                arrow.textContent = "▼";
            }
        });
    });
});
