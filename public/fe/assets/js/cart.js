// Cart functionality
document.addEventListener('DOMContentLoaded', function () {
    const cartItemsContainer = document.getElementById('cart-items');
    const subtotalElement = document.getElementById('subtotal');
    const totalElement = document.getElementById('total');

    function updateCart() {
        let subtotal = 0;
        const cartItems = document.querySelectorAll('.cart-item');

        cartItems.forEach(item => {
            const price = parseFloat(item.dataset.price);
            const quantity = parseInt(item.querySelector('.quantity-input').value);
            const itemTotal = price * quantity;
            item.querySelector('.item-total').textContent = itemTotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
            subtotal += itemTotal;
        });

        subtotalElement.textContent = subtotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });
        totalElement.textContent = subtotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }); // Add shipping or taxes if needed

        // Show/hide empty cart message
        if (cartItems.length === 0) {
            cartItemsContainer.innerHTML = '<tr><td colspan="5" class="text-center text-muted py-5">Keranjang Anda kosong.</td></tr>';
        }
    }

    // Quantity change handler
    cartItemsContainer.addEventListener('input', function (e) {
        if (e.target.classList.contains('quantity-input')) {
            if (e.target.value < 1) e.target.value = 1;

            const itemId = e.target.dataset.itemId;
            const newQuantity = e.target.value;

            // Kirim ke server (pakai fetch API)
            fetch('/cart/update-quantity', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    item_id: itemId,
                    quantity: newQuantity
                })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateCart(); // update tampilan
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    });
    
    // Remove item handler
    cartItemsContainer.addEventListener('click', function (e) {
        if (e.target.closest('.btn-remove')) {
            e.target.closest('.cart-item').remove();
            updateCart();
        }
    });

    // Initial cart update
    updateCart();
});