// Function to set the color variable and save to local storage
$(document).ready(function () {
    if ($("#color_type").val() == "custom") {
        var color = $("#custom_color_code").val();
        localStorage.setItem("primaryColor", color);
        setColorAndSave(color);
    } else {
        localStorage.removeItem("primaryColor");
    }
});

function setColorAndSave(color) {
    // Convert hex color to RGB
    const rgbColor = hexToRgb(color);

    // Set the RGB CSS variable
    $("#custom_color").val("--primary-rgb: " + rgbColor);
    $("#color_type").val("custom");
    document.documentElement.style.setProperty(
        "--pc-sidebar-active-color-rgb",
        rgbColor
    );
    document.documentElement.style.setProperty(
        "--pc-sidebar-active-color",
        color
    );
    document.documentElement.style.setProperty("--bs-secondary", color);
    // Save to local storage
    localStorage.setItem("primaryColor", color);
}

// Function to convert hex color to RGB
function hexToRgb(hex) {
    // Remove the leading '#' if present
    hex = hex.replace("#", "");
    // Convert to RGB
    const bigint = parseInt(hex, 16);
    const r = (bigint >> 16) & 255;
    const g = (bigint >> 8) & 255;
    const b = bigint & 255;
    return `${r},${g},${b}`;
}

// Get the color picker input element
const colorPicker = document.getElementById("colorChange");

// Initialize with the default color from local storage, if available
const savedColor = localStorage.getItem("primaryColor");
if (savedColor) {
    setColorAndSave(savedColor);
    colorPicker.value = savedColor;
}

// Listen for changes in the color picker
if (colorPicker) {
    colorPicker.addEventListener("input", function (event) {
        const selectedColor = event.target.value;
        $("#custom_color_code").val(selectedColor);
        setColorAndSave(selectedColor);
    });
} else {
    console.error("colorPicker element not found!");
}

$(document).on("click", ".color_type", function () {
    var val = $(this).attr("data-color-type");
    $(".color_type").removeClass("active");
    $(this).addClass("active");
    $("#color_type").val(val);
    if (val == "custom") {
        $("#Pstylesheet").attr("href", custom_color);
    } else {
        $("#Pstylesheet").attr("href", style_preset);
    }
});
