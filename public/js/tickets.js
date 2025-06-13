document.addEventListener('DOMContentLoaded', function() {
    const ticketSearchForm = document.getElementById('ticketSearchForm');
    const ticketsContainer = document.getElementById('ticketsContainer');
    const ticketsTableBody = document.getElementById('ticketsTableBody');
    const loadingIndicator = document.getElementById('loading');
    const errorContainer = document.getElementById('errorContainer');
    const processWithOpenAIBtn = document.getElementById('processWithOpenAI');
    const openAiResponseContainer = document.getElementById('openAiResponseContainer');
    const openAiResponse = document.getElementById('openAiResponse');

    let currentTickets = [];

    // Form submission handler
    ticketSearchForm.addEventListener('submit', function(e) {
        e.preventDefault();
        fetchTickets();
    });

    // Process with OpenAI button handler
    processWithOpenAIBtn.addEventListener('click', function() {
        processTicketsWithOpenAI();
    });

    // Function to fetch tickets from the API
    function fetchTickets() {
        // Get form data
        const formData = new FormData(ticketSearchForm);
        const sinceDate = formData.get('since_date');
        const sinceTime = formData.get('since_time');
        const customer = formData.get('customer');

        // Validate date
        if (!sinceDate) {
            showError('Bitte geben Sie ein Datum ein.');
            return;
        }

        // Create query parameters
        const since = `${sinceDate} ${sinceTime}`;
        let queryParams = `?since=${encodeURIComponent(since)}`;
        if (customer) {
            queryParams += `&customer=${encodeURIComponent(customer)}`;
        }

        // Show loading indicator
        loadingIndicator.classList.remove('d-none');
        ticketsContainer.classList.add('d-none');
        openAiResponseContainer.classList.add('d-none');
        errorContainer.classList.add('d-none');

        // Fetch tickets from API
        fetch(`/api/tickets${queryParams}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Fehler beim Abrufen der Tickets');
                }
                return response.json();
            })
            .then(data => {
                currentTickets = data.tickets;
                displayTickets(currentTickets);
                loadingIndicator.classList.add('d-none');
                ticketsContainer.classList.remove('d-none');
            })
            .catch(error => {
                loadingIndicator.classList.add('d-none');
                showError(error.message);
            });
    }

    // Function to display tickets in the table
    // Function to display tickets in the table
    function displayTickets(tickets) {
        ticketsTableBody.innerHTML = '';

        if (tickets.length === 0) {
            ticketsTableBody.innerHTML = '<tr><td colspan="6" class="text-center">Keine Tickets gefunden</td></tr>';
            processWithOpenAIBtn.disabled = true;
            return;
        }

        processWithOpenAIBtn.disabled = false;

        tickets.forEach(ticket => {
            const row = document.createElement('tr');

            row.innerHTML = `
            <td>${ticket.id || 'N/A'}</td>
            <td>${ticket.kunden_id || 'N/A'}</td>
            <td>${ticket.betreff || 'Kein Betreff'}</td>
            <td>${ticket.status || 'Unbekannt'}</td>
            <td>${formatDate(ticket.created_at) || 'Unbekannt'}</td>
            <td>
                <button class="btn btn-sm btn-info view-details" data-ticket-id="${ticket.id}">Details</button>
            </td>
        `;

            ticketsTableBody.appendChild(row);
        });

        // Add event listeners to detail buttons
        document.querySelectorAll('.view-details').forEach(button => {
            button.addEventListener('click', function() {
                const ticketId = this.getAttribute('data-ticket-id');
                viewTicketDetails(ticketId);
            });
        });
    }
    // Function to process tickets with OpenAI
    function processTicketsWithOpenAI() {
        if (currentTickets.length === 0) {
            showError('Keine Tickets zum Verarbeiten verfügbar.');
            return;
        }

        loadingIndicator.classList.remove('d-none');
        openAiResponseContainer.classList.add('d-none');
        errorContainer.classList.add('d-none');

        fetch('/api/openai/process-tickets', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ tickets: currentTickets })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Fehler bei der Verarbeitung mit OpenAI');
                }
                return response.json();
            })
            .then(data => {
                loadingIndicator.classList.add('d-none');
                openAiResponseContainer.classList.remove('d-none');
                openAiResponse.innerHTML = formatOpenAIResponse(data.response);
            })
            .catch(error => {
                loadingIndicator.classList.add('d-none');
                showError(error.message);
            });
    }

    // Helper function to format OpenAI response
    function formatOpenAIResponse(response) {
        if (typeof response === 'string') {
            // Ersetze ** mit <strong> Tags für Fettdruck
            let formatted = response.replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>');
            // Erhalte Zeilenumbrüche
            formatted = formatted.replace(/\n/g, '<br>');
            return formatted;
        } else if (typeof response === 'object') {
            return `<pre>${JSON.stringify(response, null, 2)}</pre>`;
        }
        return response;
    }

    // Helper function to format date
    function formatDate(dateString) {
        if (!dateString) return '';

        const date = new Date(dateString);
        return date.toLocaleString('de-DE');
    }

    // Function to view ticket details
    function viewTicketDetails(ticketId) {
        const ticket = currentTickets.find(t => t.id == ticketId);

        if (!ticket) {
            showError('Ticket nicht gefunden.');
            return;
        }

        // You can implement a modal or redirect to ticket details page
        alert(`Ticket Details:\n\nID: ${ticket.id}\nBetreff: ${ticket.betreff}\nBeschreibung: ${ticket.beschreibung || 'Keine Beschreibung'}`);
    }

    // Function to show error messages
    function showError(message) {
        errorContainer.textContent = message;
        errorContainer.classList.remove('d-none');
    }
});
