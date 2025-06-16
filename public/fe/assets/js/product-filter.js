document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.querySelector('.search-filter input');
    const categorySelect = document.querySelector('.search-filter select');
    const productCards = document.querySelectorAll('.product-card');
    const productsContainer = document.querySelector('.row:not(.mb-4)');

    function filterProducts() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const selectedCategory = categorySelect.value;

        let visibleProducts = 0;

        productCards.forEach(card => {
            const productName = card.querySelector('h5').textContent.toLowerCase();
            const productCategory = card.dataset.category; // Assumes data-category attribute

            const matchesSearch = productName.includes(searchTerm);
            const matchesCategory = selectedCategory === 'All Categories' || productCategory === selectedCategory;

            if (matchesSearch && matchesCategory) {
                card.parentElement.style.display = 'block';
                visibleProducts++;
            } else {
                card.parentElement.style.display = 'none';
            }
        });

        // Show message if no products match
        if (visibleProducts === 0) {
            productsContainer.innerHTML = '<p class="text-center text-muted">No products found.</p>';
        } else if (productsContainer.querySelector('p')) {
            productsContainer.querySelector('p').remove();
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterProducts);
    categorySelect.addEventListener('change', filterProducts);
});