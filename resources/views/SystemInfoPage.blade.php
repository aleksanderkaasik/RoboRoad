<div id="system-info" style="margin-top: 20px; font-family: monospace;">
    Loading system info...
</div>

<script>
    function updateSystemInfo() {
        fetch(`/system-info/{{ $id }}`)
            .then(response => response.json())
            .then(data => {
                const infoDiv = document.getElementById('system-info');
                infoDiv.innerHTML = `
                    <strong>Name:</strong> {{ $nodeName }}<br>
                    <strong>Uptime:</strong> ${data.uptime}<br>
                    <strong>CPU Cores:</strong> ${data.cpu.cores}, <strong>Usage:</strong> ${data.cpu.percent}%<br>
                    <strong>RAM Usage:</strong> ${data.ram.used} / ${data.ram.total} (${data.ram.percent}%)<br>
                    <strong>Disk Usage:</strong> ${data.disk.used} / ${data.disk.total} (${data.disk.percent}%)
                `;
            })
            .catch(error => {
                console.error('Failed to fetch system info:', error);
                document.getElementById('system-info').innerText = 'Failed to load system info.';
            });
    }
    
    updateSystemInfo();
    setInterval(updateSystemInfo, 60000);
</script>