function sendLocation() {
    const status = document.getElementById('status');
    status.textContent = "Requesting your location...";
    status.style.color = "#2563eb";

    if (!navigator.geolocation) {
        status.textContent = "Geolocation not supported in this browser";
        status.style.color = "#ef4444";
        return;
    }

    navigator.geolocation.getCurrentPosition(
        pos => {
            const lat = pos.coords.latitude;
            const lon = pos.coords.longitude;

            status.textContent = `Location acquired (${lat.toFixed(5)}, ${lon.toFixed(5)}) — Sending...`;

            const formData = new FormData();
            formData.append('latitude', lat);
            formData.append('longitude', lon);
            formData.append('plate', document.getElementById('plate').value || '');
            formData.append('details', document.getElementById('details').value || '');
            const media = document.getElementById('media').files[0];
            if (media) formData.append('media', media);

            fetch('save_location.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error(`HTTP ${response.status}`);
                return response.json();
            })
            .then(res => {
                if (res.status === 'success') {
                    status.innerHTML = "Success! Report submitted.<br>Check dashboard for pin.";
                    status.style.color = "#10b981";
                    setTimeout(() => window.location.href = "dashboard.html", 2500);
                } else {
                    status.textContent = "Server error: " + (res.message || "Unknown");
                    status.style.color = "#ef4444";
                }
            })
            .catch(err => {
                status.textContent = "Failed to send — " + err.message;
                status.style.color = "#ef4444";
                console.error(err);
            });
        },
        err => {
            let msg = "Location access failed: ";
            if (err.code === 1) msg += "Permission denied — allow location in browser settings";
            else if (err.code === 3) msg += "Timeout — try again or check GPS";
            else msg += err.message;
            status.textContent = msg;
            status.style.color = "#ef4444";
        },
        { enableHighAccuracy: true, timeout: 20000, maximumAge: 0 }
    );
}