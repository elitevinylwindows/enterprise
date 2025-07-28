(function () {
    var savedColor = localStorage.getItem("primaryColor");
    if (savedColor) {
        document.documentElement.style.setProperty("--pc-sidebar-active-color", savedColor);
        document.documentElement.style.setProperty("--bs-secondary", savedColor);

        // Convert hex to RGB for other styles
        function hexToRgb(hex) {
            hex = hex.replace("#", "");
            var bigint = parseInt(hex, 16);
            var r = (bigint >> 16) & 255;
            var g = (bigint >> 8) & 255;
            var b = bigint & 255;
            return `${r},${g},${b}`;
        }
        var rgbColor = hexToRgb(savedColor);
        document.documentElement.style.setProperty("--pc-sidebar-active-color-rgb", rgbColor);
    }
})();
