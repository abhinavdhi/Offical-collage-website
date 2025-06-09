const texts = ["Gautam Buddha University", "School of ICT"];
let index = 0;
let charIndex = 0;
let typingActive = true;
let stopTyping = false;  // Flag to control stopping of the typing animation

const logoText = document.getElementById("logo-text");
const cursor = document.createElement("span");
cursor.className = "cursor";
logoText.appendChild(cursor);

function updateTypingStatus() {
    if (window.innerWidth > 768 && !stopTyping) {  // Ensure typing happens only if not stopped
        typingActive = true;
        cursor.style.display = "inline"; // Show cursor on larger screens
        logoText.textContent = ""; // Reset text for animation
        charIndex = 0; // Reset character index
        type(); // Restart animation
    } else {
        typingActive = false;
        cursor.style.display = "none"; // Hide cursor on smaller screens
        logoText.textContent = "Gautam Buddha University"; // Display static text
    }
}

function type() {
    if (stopTyping) return; // Permanently stop typing if stopTyping is true

    if (charIndex < texts[index].length) {
        logoText.textContent += texts[index].charAt(charIndex);
        charIndex++;
        setTimeout(type, 100); // Adjust typing speed here (100ms)
    } else {
        setTimeout(deleteText, 1000); // Pause before deleting
    }
}

function deleteText() {
    if (stopTyping) return; // Permanently stop deleting if stopTyping is true

    if (charIndex > 0) {
        logoText.textContent = texts[index].substring(0, charIndex - 1);
        charIndex--;
        setTimeout(deleteText, 50); // Adjust deleting speed here (50ms)
    } else {
        index = (index + 1) % texts.length; // Move to the next text
        setTimeout(type, 500); // Pause before typing the next text
    }
}

// Add resize event listener
window.addEventListener("resize", updateTypingStatus);

// Initial check for screen size
updateTypingStatus();

// Function to permanently stop typing
function stopTypingAnimation() {
    stopTyping = true; // Set stopTyping flag to true
    cursor.style.display = "none"; // Hide the cursor permanently
    logoText.textContent = "Gautam Buddha University"; // Optionally display a message
}

// Call stopTypingAnimation to permanently stop typing when needed
stopTypingAnimation(); // This will stop the animation permanently
