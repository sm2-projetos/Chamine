// Toggle notifications
function toggleNotifications() {
    const dropdown = document.getElementById('notificationDropdown');
    dropdown.classList.toggle('show');
}

// Close notifications when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.notification-icon') && 
        !event.target.matches('.fa-bell')) {
        const dropdown = document.getElementById('notificationDropdown');
        if (dropdown.classList.contains('show')) {
            dropdown.classList.remove('show');
        }
    }
}

// Gráficos
const andamentoChart = new Chart(document.getElementById('andamentoChart'), {
    type: 'line',
    data: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
        datasets: [{
            label: 'OS em Andamento',
            data: [8, 10, 12, 9, 11, 12],
            borderColor: '#00a65a',
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

const concluidasChart = new Chart(document.getElementById('concluidasChart'), {
    type: 'bar',
    data: {
        labels: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun'],
        datasets: [{
            label: 'OS Concluídas',
            data: [35, 40, 38, 42, 45, 45],
            backgroundColor: '#00a65a'
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

const pendentesChart = new Chart(document.getElementById('pendentesChart'), {
    type: 'doughnut',
    data: {
        labels: ['Alta', 'Média', 'Baixa'],
        datasets: [{
            data: [1, 1, 1],
            backgroundColor: ['#ff6b6b', '#ffd93d', '#00a65a']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});