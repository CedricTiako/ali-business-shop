// api.js
const BASE_URL = '../back-end';

// Fonction générique pour les appels API
const fetchData = async (endpoint, options = {}) => {
    try {
        const response = await fetch(`${BASE_URL}${endpoint}`, options);
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return await response.json();
    } catch (error) {
        console.error('Fetch error:', error);
        throw error;
    }
};

// Produits
export const getProducts = () => fetchData('/products.php');
export const getProductById = (id) => fetchData(`/products.php?id=${id}`);
export const createProduct = (data) => fetchData('/products.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateProduct = (id, data) => fetchData(`/products.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteProduct = (id) => fetchData(`/products.php?id=${id}`, { method: 'DELETE' });

// Catégories
export const getCategories = () => fetchData('/categories.php');
export const getCategoryById = (id) => fetchData(`/categories.php?id=${id}`);
export const createCategory = (data) => fetchData('/categories.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateCategory = (id, data) => fetchData(`/categories.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteCategory = (id) => fetchData(`/categories.php?id=${id}`, { method: 'DELETE' });

// Images de Produits
export const getProductImages = () => fetchData('/product_images.php');
export const getProductImageById = (id) => fetchData(`/product_images.php?id=${id}`);
export const createProductImage = (data) => fetchData('/product_images.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateProductImage = (id, data) => fetchData(`/product_images.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteProductImage = (id) => fetchData(`/product_images.php?id=${id}`, { method: 'DELETE' });

// Tailles
export const getSizes = () => fetchData('/sizes.php');
export const getSizeById = (id) => fetchData(`/sizes.php?id=${id}`);
export const createSize = (data) => fetchData('/sizes.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateSize = (id, data) => fetchData(`/sizes.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteSize = (id) => fetchData(`/sizes.php?id=${id}`, { method: 'DELETE' });

// Couleurs
export const getColors = () => fetchData('/colors.php');
export const getColorById = (id) => fetchData(`/colors.php?id=${id}`);
export const createColor = (data) => fetchData('/colors.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateColor = (id, data) => fetchData(`/colors.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteColor = (id) => fetchData(`/colors.php?id=${id}`, { method: 'DELETE' });

// Avis
export const getReviews = () => fetchData('/reviews.php');
export const getReviewById = (id) => fetchData(`/reviews.php?id=${id}`);
export const createReview = (data) => fetchData('/reviews.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateReview = (id, data) => fetchData(`/reviews.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteReview = (id) => fetchData(`/reviews.php?id=${id}`, { method: 'DELETE' });

// Informations Supplémentaires
export const getAdditionalInformation = () => fetchData('/additional_information.php');
export const getAdditionalInformationById = (id) => fetchData(`/additional_information.php?id=${id}`);
export const createAdditionalInformation = (data) => fetchData('/additional_information.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateAdditionalInformation = (id, data) => fetchData(`/additional_information.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteAdditionalInformation = (id) => fetchData(`/additional_information.php?id=${id}`, { method: 'DELETE' });

// Utilisateurs
export const getUsers = () => fetchData('/users.php');
export const getUserById = (id) => fetchData(`/users.php?id=${id}`);
export const createUser = (data) => fetchData('/users.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateUser = (id, data) => fetchData(`/users.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteUser = (id) => fetchData(`/users.php?id=${id}`, { method: 'DELETE' });

// Produits Associés
export const getRelatedProducts = () => fetchData('/related_products.php');
export const getRelatedProductById = (id) => fetchData(`/related_products.php?id=${id}`);
export const createRelatedProduct = (data) => fetchData('/related_products.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateRelatedProduct = (id, data) => fetchData(`/related_products.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteRelatedProduct = (id) => fetchData(`/related_products.php?id=${id}`, { method: 'DELETE' });

// Panier
export const getCarts = () => fetchData('/carts.php');
export const getCartById = (id) => fetchData(`/carts.php?id=${id}`);
export const createCart = (data) => fetchData('/carts.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateCart = (id, data) => fetchData(`/carts.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteCart = (id) => fetchData(`/carts.php?id=${id}`, { method: 'DELETE' });

// Éléments du Panier
export const getCartItems = () => fetchData('/cart_items.php');
export const getCartItemById = (id) => fetchData(`/cart_items.php?id=${id}`);
export const createCartItem = (data) => fetchData('/cart_items.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateCartItem = (id, data) => fetchData(`/cart_items.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteCartItem = (id) => fetchData(`/cart_items.php?id=${id}`, { method: 'DELETE' });

// Commandes
export const getOrders = () => fetchData('/orders.php');
export const getOrderById = (id) => fetchData(`/orders.php?id=${id}`);
export const createOrder = (data) => fetchData('/orders.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateOrder = (id, data) => fetchData(`/orders.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteOrder = (id) => fetchData(`/orders.php?id=${id}`, { method: 'DELETE' });

// Détails des Commandes
export const getOrderDetails = () => fetchData('/order_details.php');
export const getOrderDetailById = (id) => fetchData(`/order_details.php?id=${id}`);
export const createOrderDetail = (data) => fetchData('/order_details.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateOrderDetail = (id, data) => fetchData(`/order_details.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteOrderDetail = (id) => fetchData(`/order_details.php?id=${id}`, { method: 'DELETE' });

// Favoris
export const getFavorites = () => fetchData('/favorites.php');
export const getFavoriteById = (id) => fetchData(`/favorites.php?id=${id}`);
export const createFavorite = (data) => fetchData('/favorites.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const updateFavorite = (id, data) => fetchData(`/favorites.php?id=${id}`, {
    method: 'PUT',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(data)
});
export const deleteFavorite = (id) => fetchData(`/favorites.php?id=${id}`, { method: 'DELETE' });
