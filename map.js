document.addEventListener('DOMContentLoaded', () => {
    // Create map with placeholder center (will be updated)
    const map = L.map('map').setView([0, 0], 2);

    // Add OpenStreetMap tiles
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        maxZoom: 19
    }).addTo(map);

    // Load saved reports from server
    fetch('get_location.php')
        .then(response => response.json())
        .then(reports => {
            console.log('Loaded reports:', reports);

            if (reports.length > 0) {
                // Show pins for all reports
                reports.forEach(r => {
                    L.marker([parseFloat(r.latitude), parseFloat(r.longitude)])
                        .addTo(map)
                        .bindPopup(`Reported: ${r.added || 'time unknown'}`);
                });

                // Center & zoom on the MOST RECENT report (last in array)
                const latest = reports[reports.length - 1];
                const lat = parseFloat(latest.latitude);
                const lon = parseFloat(latest.longitude);
                map.setView([lat, lon], 17);  // 17 = street-level precision

                alert('Map centered on your latest reported location!');
            } else {
                // No reports yet → ask for live location and center there
                alert('No reports yet. Centering on your current live location...');

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        pos => {
                            const lat = pos.coords.latitude;
                            const lon = pos.coords.longitude;
                            map.setView([lat, lon], 17);
                            L.marker([lat, lon]).addTo(map)
                                .bindPopup('Your current live location (not saved yet)');
                            alert('Centered on your current position!');
                        },
                        err => {
                            alert('Could not get live location: ' + err.message);
                            // Fallback to Nyeri if permission denied
                            map.setView([-0.42, 36.95], 10);
                        },
                        { enableHighAccuracy: true, timeout: 10000 }
                    );
                } else {
                    alert('Geolocation not supported. Map stays at default.');
                }
            }
        })
        .catch(err => {
            console.error('Fetch error:', err);
            alert('Could not load reports. Check get_location.php');
        });
});