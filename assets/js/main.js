const books = [
    {
        img: "book1.jpg",
        title: "Le Petit Prince",
        author: "Antoine de Saint-Exupéry",
        price: 19.99,
        category: "Fiction",
        rating: 4.5,
        stock: 10
    },
    {
        img: "book2.png",
        title: "Les Misérables",
        author: "Victor Hugo",
        price: 24.99,
        category: "Classique",
        rating: 4.8,
        stock: 5
    },
    {
        img: "book3.jpg",
        title: "L'Étranger",
        author: "Albert Camus",
        price: 18.99,
        category: "Philosophie",
        rating: 4.3,
        stock: 8
    },
    {
        img: "book4.jpg",
        title: "Madame Bovary",
        author: "Gustave Flaubert",
        price: 21.99,
        category: "Classique",
        rating: 4.6,
        stock: 3
    }
];

let cart = [];

function createBookCard(book) {
    const stars = "★".repeat(Math.floor(book.rating)) + "☆".repeat(5 - Math.floor(book.rating));
    return `
        <div class="book-card">
            <span class="category-tag">${book.category}</span>
            <img src="./assets/images/${book.img}" alt="${book.title}" class="book-img">
            <div class="book-info">
                <h3>${book.title}</h3>
                <p>${book.author}</p>
                <div class="rating">${stars}</div>
                <p>Stock: ${book.stock}</p>
                <p>${book.price.toFixed(2)}€</p>
                <button class="btn" onclick="addToCart(${books.indexOf(book)})" 
                    ${book.stock === 0 ? 'disabled' : ''}>
                    ${book.stock === 0 ? 'Rupture de stock' : 'Ajouter au panier'}
                </button>
            </div>
        </div>
    `;
}

function addToCart(index) {
    const book = books[index];
    if (book.stock > 0) {
        cart.push(book);
        book.stock--;
        updateCartCount();
        updateDisplay();
    }
}

function updateCartCount() {
    document.querySelector('.cart-count').textContent = cart.length;
}

function updateDisplay() {
    document.getElementById('books-container').innerHTML = 
        books.map(book => createBookCard(book)).join('');
}

function toggleCart() {
    const modal = document.getElementById('cartModal');
    modal.style.display = modal.style.display === 'none' ? 'block' : 'none';
    
    if (modal.style.display === 'block') {
        let total = 0;
        const cartHtml = cart.map(item => {
            total += item.price;
            return `<p>${item.title} - ${item.price.toFixed(2)}€</p>`;
        }).join('');
        
        document.getElementById('cartItems').innerHTML = `
            ${cartHtml}
            <h3>Total: ${total.toFixed(2)}€</h3>
        `;
    }
}

function checkout() {
    if (cart.length === 0) {
        alert('Votre panier est vide!');
        return;
    }
    alert('Merci de votre achat!');
    cart = [];
    updateCartCount();
    toggleCart();
}

updateDisplay();