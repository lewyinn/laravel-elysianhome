// Print invoice functionality
document.addEventListener('DOMContentLoaded', function () {
    const printButtons = document.querySelectorAll('.btn-print');

    printButtons.forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const orderData = JSON.parse(row.dataset.order);

            // Fetch the invoice template
            fetch('invoice-template.html')
                .then(response => response.text())
                .then(template => {
                    // Replace placeholders in the template
                    let invoiceContent = template
                        .replace('{{order_id}}', orderData.id)
                        .replace('{{order_date}}', orderData.date)
                        .replace('{{shipping_address}}', orderData.shipping_address)
                        .replace('{{payment_method}}', orderData.payment_method)
                        .replace('{{total}}', orderData.total.toFixed(2))
                        .replace('{{items}}', orderData.items.map(item => `
                                    <tr>
                                        <td>${item.name}</td>
                                        <td>$${item.price.toFixed(2)}</td>
                                        <td>${item.quantity}</td>
                                        <td>$${(item.price * item.quantity).toFixed(2)}</td>
                                    </tr>
                                `).join(''));

                    // Open and print the invoice
                    const printWindow = window.open('', '_blank');
                    printWindow.document.write(invoiceContent);
                    printWindow.document.close();
                    printWindow.print();
                    setTimeout(() => printWindow.close(), 1000); // Auto-close after printing
                })
                .catch(error => {
                    console.error('Error loading invoice template:', error);
                    alert('Failed to load invoice template. Please try again.');
                });
        });
    });
});