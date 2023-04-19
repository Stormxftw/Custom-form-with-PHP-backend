
function toggleStreamingOptions(show) {
    const streamingOptions = document.getElementById("streaming-options");
    streamingOptions.style.display = show ? "block" : "none";
}

function toggleOtherOption() {
    const otherCheckbox = document.getElementById("other");
    const otherPlatform = document.getElementById("other-platform");
    otherPlatform.style.display = otherCheckbox.checked ? "block" : "none";
}

function toggleOtherSocialMedia() {
    const otherSocialMediaCheckbox = document.getElementById("other-social-media");
    const otherSocialMediaInput = document.getElementById("other-social-media-input");
    otherSocialMediaInput.style.display = otherSocialMediaCheckbox.checked ? "block" : "none";
}

function toggleSubstituteExpression(show) {
    const substituteExpressionDetails = document.getElementById("substitute-expression-details");
    substituteExpressionDetails.style.display = show ? "block" : "none";
}

function toggleExtraOutfit(show) {
    const extraOutfitDetails = document.getElementById("extra-outfit-details");
    extraOutfitDetails.style.display = show ? "block" : "none";
}

function toggleExtraHairstyle(show) {
    const extraHairstyleDetails = document.getElementById("extra-hairstyle-details");
    extraHairstyleDetails.style.display = show ? "block" : "none";
}

function togglePet(show) {
    const petDetails = document.getElementById("pet-details");
    petDetails.style.display = show ? "block" : "none";
}

function toggleExtraObject(show) {
    const extraObjectDetails = document.getElementById("extra-object-details");
    extraObjectDetails.style.display = show ? "block" : "none";
}

function toggleExtraExpression(show) {
    const extraExpressionDetails = document.getElementById("extra-expression-details");
    extraExpressionDetails.style.display = show ? "block" : "none";
}

function toggleUsernameField(checkboxId, inputId) {
    const checkbox = document.getElementById(checkboxId);
    const inputField = document.getElementById(inputId);
    inputField.style.display = checkbox.checked ? "block" : "none";
}

function validateForm() {
    const codeWordInput = document.getElementById("code-word");
    const codeWord = codeWordInput.value.trim();

    if (codeWord.toLowerCase() !== "pineapple") {
        alert("Incorrect code word. Please enter the correct code word found in Prisma's TOS.");
        return false;
    }

    return true;
}



document.getElementById("commission-form").addEventListener("submit", function (event) {
    const privateOption = document.getElementById("private-Value");
    const acceptPrivateFee = document.getElementById("private-fee");
    if (privateOption.checked && !acceptPrivateFee.checked) {
        event.preventDefault();
        alert("You must accept the extra $300 fee for a private commission before submitting the form.");
    }
});

document.getElementById("commission-form").addEventListener("submit", function (event) {
    const tosAcknowledgmentNo = document.getElementById("tos-acknowledgment-no");
    if (tosAcknowledgmentNo.checked) {
        event.preventDefault();
        alert("You must agree to the Terms of Service and Commission Pricing & Info to submit the form.");
    }
});

document.getElementById("twitch").addEventListener("click", function () {
    toggleUsernameField("twitch", "twitch-username");
});
document.getElementById("youtube").addEventListener("click", function () {
    toggleUsernameField("youtube", "youtube-username");
});
document.getElementById("youtube2").addEventListener("click", function () {
    toggleUsernameField("youtube2", "youtube-username2");
});
document.getElementById("other").addEventListener("click", function () {
    toggleUsernameField("other", "other-platform");
});

document.getElementById("twitter").addEventListener("click", function () {
    toggleUsernameField("twitter", "twitter-username");
});
document.getElementById("youtube").addEventListener("click", function () {
    toggleUsernameField("youtube", "youtube-username2");
});
document.getElementById("instagram").addEventListener("click", function () {
    toggleUsernameField("instagram", "instagram-username");
});
document.getElementById("tiktok").addEventListener("click", function () {
    toggleUsernameField("tiktok", "tiktok-username");
});
document.getElementById("other-social-media").addEventListener("click", function () {
    toggleUsernameField("other-social-media", "other-social-media-input");
});


const selectedFilesList = document.getElementById('selected-files');
const fileInput = document.getElementById('reference-art');

let selectedFiles = [];

fileInput.addEventListener('change', (event) => {
    const newFiles = event.target.files;
    selectedFiles = [...selectedFiles, ...newFiles];

    displaySelectedFiles();
});

function displaySelectedFiles() {
    selectedFilesList.innerHTML = '';

    selectedFiles.forEach((file, index) => {
        const fileElement = document.createElement('div');
        const fileName = document.createElement('span');
        const removeButton = document.createElement('button');

        fileName.textContent = file.name;
        fileName.classList.add('file-name'); // Add class to the file name
        removeButton.textContent = 'Remove';
        removeButton.classList.add('remove-btn'); // Add class to the remove button
        removeButton.onclick = () => {
            removeSelectedFile(index);
        };

        fileElement.appendChild(fileName);
        fileElement.appendChild(removeButton);
        selectedFilesList.appendChild(fileElement);
    });
}

function removeSelectedFile(index) {
    selectedFiles.splice(index, 1);
    displaySelectedFiles();
}

const form = document.getElementById('commission-form');

form.addEventListener('submit', async (event) => {
    event.preventDefault();

    const formData = new FormData(form);

    // Remove the file input field's value from formData
    formData.delete('reference-art[]');

    // Add each file from selectedFiles to formData
    for (const file of selectedFiles) {
        formData.append('reference-art[]', file);
    }

    const response = await fetch('send_email.php', {
        method: 'POST',
        body: formData,
    });

    if (response.ok) {
        // Redirect to the thank you page if the email was sent successfully
        window.location.href = 'html/thankyou.html';
    } else {
        // Handle errors here
        console.error('Error sending email:', response.statusText);
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const privateOption = document.getElementById('private-value');
    const privateFeeContainer = document.getElementById('private-fee-container');
    const privateFeeLabel = document.getElementById('private-fee-label');
    const radioOptions = document.getElementsByName('model-privacy');

    for (const option of radioOptions) {
        option.addEventListener('change', function () {
            if (privateOption.checked) {
                privateFeeContainer.style.display = 'block';
                privateFeeLabel.classList.add('noticeable-checkbox');
            } else {
                privateFeeContainer.style.display = 'none';
                privateFeeLabel.classList.remove('noticeable-checkbox');
            }
        });
    }
});

document.getElementById("custom-file-btn").addEventListener("click", function () {
    document.getElementById("reference-art").click();
});
