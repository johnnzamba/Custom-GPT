
const chatForm = document.getElementById("chat-form");
const chatInput = document.getElementById("chat-input");
const chatOutput = document.getElementById("chat-output");

chatForm.addEventListener("submit", async (e) => {
    e.preventDefault();
    const message = chatInput.value.trim();
    if (!message) return;

    displayUserMessage(message);

    try {
        const response = await fetch("gptchat.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({ message }),
        });

        if (response.ok) {
            const data = await response.json();
            if (data.message) {

                displayBotMessage(data.message);
            } else {
                console.error("Error: Unexpected response format", data);
            }
        } else {
            console.error("Error communicating with GPTChat API");
        }
    } catch (error) {
        console.error("Fetch error:", error);
    }

    // Clear input field
    chatInput.value = "";
});

// Function to display user message in chat
function displayUserMessage(message) {
    chatOutput.innerHTML += `
        <div class="user-message speech-bubble">
            ${message}
        </div>
    `;
    chatOutput.scrollTop = chatOutput.scrollHeight;
}

// Function to display bot message in chat
function displayBotMessage(message) {
    chatOutput.innerHTML += `
        <div class="bot-message speech-bubble">
            ${message}
        </div>
    `;
    chatOutput.scrollTop = chatOutput.scrollHeight;
}
