function exportReports() {
    // Get current filter values
    const startDate = document.getElementById('start_date').value;
    const endDate = document.getElementById('end_date').value;
    const userId = document.getElementById('user_id').value;
    const assessmentId = document.getElementById('assessment_id').value;

    // Construct query parameters
    const params = new URLSearchParams();
    if (startDate) params.append('start_date', startDate);
    if (endDate) params.append('end_date', endDate);
    if (userId) params.append('user_id', userId);
    if (assessmentId) params.append('assessment_id', assessmentId);

    // Make API request
    fetch(`/admin/reports/export?${params.toString()}`)
        .then(response => response.json())
        .then(data => {
            // Convert data to CSV format
            const csvContent = convertToCSV(data.data);
            
            // Create and trigger download
            const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
            const link = document.createElement('a');
            const url = URL.createObjectURL(blob);
            
            link.setAttribute('href', url);
            link.setAttribute('download', `assessment_reports_${new Date().toISOString().split('T')[0]}.csv`);
            link.style.visibility = 'hidden';
            
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        })
        .catch(error => {
            console.error('Error exporting reports:', error);
            alert('Failed to export reports. Please try again.');
        });
}

function convertToCSV(data) {
    if (!data || !data.length) return '';

    // Define CSV headers
    const headers = [
        'Assessment',
        'Employee',
        'Score',
        'Status',
        'Submitted At',
        'Questions Answered',
        'Time Taken'
    ];

    // Convert data to CSV rows
    const rows = data.map(response => [
        response.assessment.title,
        response.employee.name,
        `${response.score}%`,
        response.status,
        new Date(response.created_at).toLocaleString(),
        response.question_responses.length,
        calculateTimeTaken(response.started_at, response.completed_at)
    ]);

    // Combine headers and rows
    return [
        headers.join(','),
        ...rows.map(row => row.map(cell => `"${cell}"`).join(','))
    ].join('\n');
}

function calculateTimeTaken(startTime, endTime) {
    if (!startTime || !endTime) return 'N/A';
    
    const start = new Date(startTime);
    const end = new Date(endTime);
    const diffMinutes = Math.round((end - start) / (1000 * 60));
    
    if (diffMinutes < 60) {
        return `${diffMinutes} minutes`;
    }
    
    const hours = Math.floor(diffMinutes / 60);
    const minutes = diffMinutes % 60;
    return `${hours}h ${minutes}m`;
}