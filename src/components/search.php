<form method="GET" action="">
    <div class="input-group input-group-lg bg-light">
        <!-- Search Icon -->
        <span class="input-group-text search-icon">
            <i class="fa fa-search" aria-hidden="true"></i>
        </span>

        <!-- Search Input -->
        <input autocomplete="off" type="text" id="searchBar" name="search" class="form-control"
            style="background-color: white;" 
            placeholder="Search job" value="<?php echo htmlspecialchars($search); ?>">

        <!-- Microphone Button -->
        <button type="button" id="micButton" class="input-group-text mic-btn">
            <i class="fa fa-microphone" aria-hidden="true"></i>
        </button>

        <!-- Search Button -->
        <button class="input-group-text search-btn" type="submit">
            Search
        </button>
    </div>               
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const micButton = document.getElementById('micButton');
        const searchBar = document.getElementById('searchBar');

        // Check if SpeechRecognition is supported
        if (!('SpeechRecognition' in window || 'webkitSpeechRecognition' in window)) {
            console.error('Speech Recognition API not supported');
            return;
        }
        
        const recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = 'en-US';
        recognition.continuous = false;  // Set to false to stop automatically after one speech input

        let noInputTimeout;

        recognition.onresult = function(event) {
            const transcript = event.results[0][0].transcript;
            const formattedTranscript = transcript.charAt(0).toUpperCase() + transcript.slice(1).toLowerCase();
            searchBar.value = formattedTranscript;

            // Reset the timeout when input is detected
            resetNoInputTimeout();
        };

        recognition.onend = function() {
            micButton.disabled = false;
        };

        micButton.addEventListener('click', () => {
            micButton.disabled = true; // Disable the button while recognition is in progress
            micButton.style.color = "red"
            searchBar.value = ""; // Clear the input field for new speech input

            recognition.start(); // Start speech recognition

            // Start the no input timeout
            resetNoInputTimeout();
        });

        function resetNoInputTimeout() {
            clearTimeout(noInputTimeout);
            noInputTimeout = setTimeout(() => {
                recognition.stop(); // Automatically stop recognition after 2 seconds of no input
            }, 2000); // 2 seconds of no input
        }
    });
</script>
